<?php

namespace App\Services\Flow;

use App\Models\Flow;
use App\Models\Project;
use App\Models\Respond;
use App\Services\Flow\Contract\Exchanger;
use Carbon\Carbon;
use DB;

class Exchanger1 implements Exchanger
{
    /**
     * Version.
     */
    const VERSION = 1;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $import = [];

    /**
     * Import data.
     *
     * @param Project $project
     * @param object $data
     * @return bool
     */
    public function import(Project $project, $data)
    {
        DB::beginTransaction();

        if (isset($data->responds)) {
            foreach ($data->responds as $respond) {
                $this->importRespond($project, (array) $respond);
            }
        }

        if (isset($data->responds_taxonomies)) {
            foreach ($data->responds_taxonomies as $respondTaxonomy) {
                if (is_null($respondTaxonomy->parent_id)) {
                    $this->importRespondTaxonomy(
                        array_get($this->import, 'responds.'.$respondTaxonomy->respond_id),
                        (array) $respondTaxonomy,
                        null
                    );
                }
            }

            foreach ($data->responds_taxonomies as $respondTaxonomy) {
                if (!is_null($respondTaxonomy->parent_id)) {
                    $this->importRespondTaxonomy(
                        array_get($this->import, 'responds.'.$respondTaxonomy->respond_id),
                        (array) $respondTaxonomy,
                        array_get($this->import, 'responds_taxonomies.'.$respondTaxonomy->parent_id)
                    );
                }
            }
        }

        if (isset($data->responds_taxonomies_params)) {
            foreach ($data->responds_taxonomies_params as $respondTaxonomyParam) {
                $this->importRespondTaxonomyParam(
                    array_get($this->import, 'responds_taxonomies.'.$respondTaxonomyParam->respond_taxonomy_id),
                    (array) $respondTaxonomyParam
                );
            }
        }

        if (isset($data->flows)) {
            foreach ($data->flows as $flow) {
                $this->importFlow($project, (array) $flow);
            }

            if ($project->flows()->whereNotNull('defaulted_at')->count() <= 0) {
                foreach ($data->flows as $flow) {
                    if ($flow->is_default) {
                        $project->flows()->update(['defaulted_at' => null]);
                        $model = array_get($this->import, 'flows.'.$flow->id);
                        $model->defaulted_at = new Carbon();
                        $model->save();
                        break;
                    }
                }
            }
        }

        if (isset($data->matchers)) {
            foreach ($data->matchers as $matcher) {
                $this->importMatcher(array_get($this->import, 'flows.'.$matcher->flow_id), (array) $matcher);
            }
        }

        if (isset($data->matchers_params)) {
            foreach ($data->matchers_params as $matcherParam) {
                $this->importMatcherParam(
                    array_get($this->import, 'matchers.'.$matcherParam->matcher_id),
                    (array) $matcherParam
                );
            }
        }

        try {
            DB::commit();
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            return false;
        }

        return true;
    }

    /**
     * @param Project $project
     * @param array $respond
     */
    protected function importRespond(Project $project, array $respond)
    {
        $model = new Respond([
            'title' => array_get($respond, 'title'),
            'label' => array_get($respond, 'label'),
        ]);
        $model->project()->associate($project);
        $model->save();

        array_set($this->import, 'responds.'.array_get($respond, 'id'), $model);
    }

    /**
     * @param Respond $respond
     * @param array $taxonomy
     * @param Respond\Taxonomy $parent
     */
    protected function importRespondTaxonomy(Respond $respond, array $taxonomy, Respond\Taxonomy $parent = null)
    {
        $model = new Respond\Taxonomy([
            'order' => array_get($taxonomy, 'order'),
            'type' => array_get($taxonomy, 'type'),
        ]);
        $model->respond()->associate($respond);
        if (!is_null($parent)) {
            $model->parent()->associate($parent);
        }
        $model->save();

        array_set($this->import, 'responds_taxonomies.'.array_get($taxonomy, 'id'), $model);
    }

    /**
     * @param Respond\Taxonomy $taxonomy
     * @param array $param
     */
    protected function importRespondTaxonomyParam(Respond\Taxonomy $taxonomy, array $param)
    {
        $model = new Respond\Taxonomy\Param([
            'order' => array_get($param, 'order'),
            'key' => array_get($param, 'key'),
            'value' => array_get($param, 'value'),
        ]);

        try {
            if (in_array(array_get($param, 'key'), ['respond', 'quick_reply'])) {
                $model->value = array_get($this->import, 'responds.'.array_get($param, 'value'))->id;
            }
        } catch (\Exception $e) {
            logger($e, $param);
        }

        $model->taxonomy()->associate($taxonomy);
        $model->save();

        array_set($this->import, 'responds_taxonomies_params.'.array_get($taxonomy, 'id'), $model);
    }

    /**
     * @param Project $project
     * @param array $flow
     */
    protected function importFlow(Project $project, array $flow)
    {
        $order = $project->flows()->max('order') + array_get($flow, 'order') - count(array_get($this->import, 'flows'));

        $model = new Flow([
            'title' => array_get($flow, 'title'),
            'order' => $order,
        ]);
        $model->project()->associate($project);
        $model->save();

        foreach ((array) array_get($flow, 'responds', []) as $respond) {
            $model->responds()->attach(array_get($this->import, 'responds.'.$respond)->id);
        }

        array_set($this->import, 'flows.'.array_get($flow, 'id'), $model);
    }

    /**
     * @param Flow $flow
     * @param array $matcher
     */
    protected function importMatcher(Flow $flow, array $matcher)
    {
        $model = new Flow\Matcher([
            'type' => array_get($matcher, 'type'),
        ]);
        $model->flow()->associate($flow);
        $model->save();

        array_set($this->import, 'matchers.'.array_get($matcher, 'id'), $model);
    }

    /**
     * @param Flow\Matcher $matcher
     * @param array $param
     */
    protected function importMatcherParam(Flow\Matcher $matcher, array $param)
    {
        $model = new Flow\Matcher\Param([
            'order' => array_get($param, 'order'),
            'key' => array_get($param, 'key'),
            'value' => array_get($param, 'value'),
        ]);
        $model->matcher()->associate($matcher);
        $model->save();

        array_set($this->import, 'matchers_params.'.array_get($param, 'id'), $model);
    }

    /**
     * Export flows.
     *
     * @param array $flows
     * @return array
     */
    public function export(array $flows)
    {
        $this->beforeExport();

        /** @var Flow $flow */
        foreach ($flows as $flow) {
            $this->exportFlow($flow);
        }

        return array_map('array_values', $this->data);
    }

    /**
     * Reset data.
     */
    protected function beforeExport()
    {
        $this->data = [
            'flows' => [],
            'responds' => [],
            'responds_taxonomies' => [],
            'responds_taxonomies_params' => [],
            'matchers' => [],
            'matchers_params' => [],
        ];
    }

    /**
     * @param Flow $flow
     */
    protected function exportFlow(Flow $flow)
    {
        $this->data['flows'][$flow->id] = [
            'id' => md5($flow->id),
            'title' => $flow->title,
            'order' => $flow->order,
            'is_default' => $flow->defaulted_at ? true : false,
            'responds' => $flow->responds()->get()->map(function (Respond $respond) {
                return md5($respond->id);
            }),
        ];

        /** @var Respond $respond */
        foreach ($flow->responds as $respond) {
            $this->exportRespond($respond);
        }

        /** @var Flow\Matcher $matcher */
        foreach ($flow->matchers as $matcher) {
            $this->exportMatcher($matcher);
        }
    }

    /**
     * @param Respond $respond
     */
    protected function exportRespond(Respond $respond)
    {
        $this->data['responds'][$respond->id] = [
            'id' => md5($respond->id),
            'title' => $respond->title,
            'label' => $respond->label,
        ];

        /** @var Respond\Taxonomy $taxonomy */
        foreach ($respond->taxonomies as $taxonomy) {
            if (!in_array($taxonomy->type, ['subscribe', 'save_input'])) {
                $this->exportRespondTaxonomy($taxonomy);
            }
        }
    }

    /**
     * @param Respond\Taxonomy $taxonomy
     */
    protected function exportRespondTaxonomy(Respond\Taxonomy $taxonomy)
    {
        $this->data['responds_taxonomies'][$taxonomy->id] = [
            'id' => md5($taxonomy->id),
            'respond_id' => md5($taxonomy->respond_id),
            'parent_id' => $taxonomy->parent_id ? md5($taxonomy->parent_id) : null,
            'order' => $taxonomy->order,
            'type' => $taxonomy->type,
        ];

        /** @var Respond\Taxonomy\Param $param */
        foreach ($taxonomy->params as $param) {
            $this->exportRespondTaxonomyParam($param);
        }
    }

    /**
     * @param Respond\Taxonomy\Param $param
     */
    protected function exportRespondTaxonomyParam(Respond\Taxonomy\Param $param)
    {
        $this->data['responds_taxonomies_params'][$param->id] = [
            'id' => md5($param->id),
            'respond_taxonomy_id' => md5($param->respond_taxonomy_id),
            'order' => $param->order,
            'key' => $param->key,
            'value' => in_array($param->key, ['respond', 'quick_reply']) ? md5($param->value) : $param->value,
        ];
    }

    /**
     * @param Flow\Matcher $matcher
     */
    protected function exportMatcher(Flow\Matcher $matcher)
    {
        $this->data['matchers'][$matcher->id] = [
            'id' => md5($matcher->id),
            'flow_id' => md5($matcher->flow_id),
            'type' => $matcher->type,
        ];

        /** @var Flow\Matcher\Param $param */
        foreach ($matcher->params as $param) {
            $this->exportMatcherParam($param);
        }
    }

    /**
     * @param Flow\Matcher\Param $param
     */
    protected function exportMatcherParam(Flow\Matcher\Param $param)
    {
        $this->data['matchers_params'][$param->id] = [
            'id' => md5($param->id),
            'matcher_id' => md5($param->matcher_id),
            'order' => $param->order,
            'key' => $param->key,
            'value' => $param->value,
        ];
    }
}
