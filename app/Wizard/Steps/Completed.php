<?php

namespace App\Wizard\Steps;

class Completed extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function apply($formData)
    {
        $user = request()->user();
        if(!$user->wizard){
            $user->wizard = true;
            $user->save();
            return true;
        }
        return false;
    }

    public function undo()
    {
        $user = request()->user();
        if($user->wizard){
            $user->wizard = false;
            $user->save();
            return true;
        }
       return false; 
    }
}