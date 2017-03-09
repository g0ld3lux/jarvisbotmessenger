<?php

namespace App\Wizard\Steps;


class ChooseTemplate extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function getFormData()
    {
        $formData = ['template' => []];

        return $formData;
    }

    public function apply($formData)
    {
        return true;
    }

    public function undo()
    {
        return true;
    }

}