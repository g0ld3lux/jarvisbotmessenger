<?php

namespace App\Wizard\Steps;

use App\Models\Bot;

class CreateANewBot extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function apply($formData)
    {
        if(empty($formData['title'])){
            return false;
        }
        // Create A New Bot
        $bot = new Bot([
            'title' => $formData['title'],
            'timezone' => $formData['timezone'],
        ]);
        $bot->user()->associate(request()->user());
        $bot->save();
        return true;
    }

    // Here If we Undo We Can Delete The Bot From Database
    public function undo()
    {
       // Delete the Latest Bot We Create
       $bot =  request()->user()->bots()->latest()->first();
       $bot->delete();
        return true;
    }


}