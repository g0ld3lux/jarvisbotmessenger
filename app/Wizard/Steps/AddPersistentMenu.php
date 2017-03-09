<?php

namespace App\Wizard\Steps;


class AddPersistentMenu extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function getFormData()
    {
        $formData = ['persistent_menu' => []];

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