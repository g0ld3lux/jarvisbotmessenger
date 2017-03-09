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
        $bot =  request()->user()->bots()->latest()->first();
        $formData['bot'] = $bot;
        // This will be return as $bot variable in your view
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