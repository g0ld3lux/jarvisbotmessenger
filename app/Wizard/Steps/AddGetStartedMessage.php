<?php

namespace App\Wizard\Steps;


class AddGetStartedMessage extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function getFormData()
    {
        $formData = ['get_started_message' => []];

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