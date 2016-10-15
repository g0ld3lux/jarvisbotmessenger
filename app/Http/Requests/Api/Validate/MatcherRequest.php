<?php

namespace App\Http\Requests\Api\Validate;

use App\Http\Requests\Request;

class MatcherRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Return matcher type.
     *
     * @return string
     */
    protected function getType()
    {
        return $this->has('type') ? $this->get('type') : null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'type' => 'required',
        ], $this->rulesByType($this->getType()));
    }

    /**
     * Return rules by type.
     *
     * @param string $type
     * @return array
     */
    protected function rulesByType($type)
    {
        if (is_null($type)) {
            return [];
        }

        $method = 'rules'.ucfirst($type);

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return [];
    }

    /**
     * Return "equals" rules.
     *
     * @return array
     */
    protected function rulesEquals()
    {
        return [
            'text' => 'required',
            'case' => 'required|in:sensitive,insensitive',
        ];
    }

    /**
     * Return "equals" rules.
     *
     * @return array
     */
    protected function rulesContains()
    {
        return [
            'text' => 'required',
            'case' => 'required|in:sensitive,insensitive',
        ];
    }

    /**
     * Return "equals" rules.
     *
     * @return array
     */
    protected function rulesRegex()
    {
        return [
            'pattern' => 'required',
        ];
    }

    /**
     * Return "equals" rules.
     *
     * @return array
     */
    protected function rulesText()
    {
        return [
            'text' => 'required',
            'sensitivity' => 'required|numeric|min:0|max:1',
        ];
    }
}
