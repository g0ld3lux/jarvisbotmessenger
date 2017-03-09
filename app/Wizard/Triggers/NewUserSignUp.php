<?php

namespace App\Wizard\Triggers;

use App\Contracts\Wizard\WizardTrigger;

/**
 * Class NewUserSignUp
 *
 * @package MarvinLabs\SetupWizard\Triggers
 *
 * Start the Wizard for New User or User Who Want to UnderGo Wizard in Setting Up Bot
 */
class NewUserSignUp implements WizardTrigger
{

    /**
     * Indicates if the wizard should be launched or not
     *
     * @return boolean
     */
    function shouldLaunchWizard()
    {
        $done = request()->user()->wizard;
        if(!$done){
            return true;
        }
   
    }
}