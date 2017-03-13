<?php

namespace App\Wizard\Steps;

use App\Http\Controllers\BotController;
use Notification;

class AddGreetings extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function getFormData()
    {
        $bot =  request()->user()->bots()->latest()->first();
        $formData['bot'] = $bot;
        return $formData;
    }

    public function apply($formData)
    {
 
        if(empty($formData['greeting_text'])){
            return false;
        }
        $bot =  request()->user()->bots()->latest()->first();
        $settings = $bot->threadSettings;

        $settings->fill([
            'greeting_text' => $formData['greeting_text'],
        ]);

        $settings->save();

        Notification::success('Bot thread settings updated successfully.');
       
        return true;
    }

    public function undo()
    {
        return true;
    }

}