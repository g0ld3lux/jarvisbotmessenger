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
        $bot =  request()->user()->bots()->latest()->first();
        $formData['bot'] = $bot;

        $responds =  $bot->responds()->global()->get();

        $formData['responds'] = $responds;
        return $formData;
    }

    public function apply($formData)
    {
        $bot =  request()->user()->bots()->latest()->first();
        $settings = $bot->threadSettings;

        try {
            $settings->getStartedRespond()->associate(
                $bot->responds()->findOrFail(request()->input('get_started_respond_id'))
            );
        } catch (\Exception $e) {
            $settings->get_started_respond_id = null;
        }

        $settings->save();
        return true;
    }

    public function undo()
    {
        return true;
    }

}