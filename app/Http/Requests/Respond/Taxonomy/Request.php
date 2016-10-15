<?php

namespace App\Http\Requests\Respond\Taxonomy;

use App\Http\Requests;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Gate;

abstract class Request extends Requests\Request
{
    protected function getType()
    {
        return $this->has('type') ? $this->get('type') : $this->route('respond')->type;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rulesByType($this->getType());
    }

    /**
     * Return rules by type.
     *
     * @param string $type
     * @return array
     */
    protected function rulesByType($type)
    {
        /** @var ValidationRulesRegistry $registry */
        $registry = app(ValidationRulesRegistry::class);

        try {
            $class = $registry->rules($type);

            if (class_exists($class)) {
                return app($class)->rules();
            }
        } catch (\Exception $e) {
            logger($e);
        }

        return [];
    }
}
