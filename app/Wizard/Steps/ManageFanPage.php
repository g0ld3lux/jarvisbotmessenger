<?php

namespace App\Wizard\Steps;


class ManageFanPage extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function getFormData()
    {

        $formData = ['fanpage' => []];

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