<?php

namespace App\Services;

use App\Models\Flow;
use App\Models\Flow\Matcher as MatcherModel;
use App\Models\Recipient;
use Bot\Core\Matcher;
use App\Models\Project;
use App\Models\Respond;

class PostbackMatcher extends RespondMatcher
{
    /**
     * Match input and return respond object.
     *
     * @param Project $project
     * @param Recipient $recipient
     * @param string $input
     * @return \Bot\Core\Respond\Respond[]
     * @throws \Exception
     */
    public function match(Project $project, Recipient $recipient, $input)
    {
        $input = str_replace('$$POSTBACK$$', '', $input);

        try {
            $taxonomy = Respond\Taxonomy::select('responds_taxonomies.*')
                ->leftJoin('responds', 'responds.id', '=', 'responds_taxonomies.respond_id')
                ->where('responds.project_id', $project->id)
                ->findOrFail($input);

            $responds = [];

            foreach ($project->responds()->whereIn('id', $taxonomy->getParamValue('respond', 'array'))->get() as $respond) {
                $responds[] = $this->respond($respond, $recipient);
            }

            return $responds;
        } catch (\Exception $e) {
            logger($e);
        }


        throw new \Exception('Postback does not match.');
    }
}
