<?php

namespace App\Wizard;

use App\Contracts\Wizard\WizardTrigger;
use App\Exceptions\StepNotFoundException;

/**
 * Class TriggerHelper
 *
 *
 * Some utility functions to work with triggers
 */
class TriggerHelper
{
    /**
     * @return bool Returns true if the wizard has to be launched
     */
    public static function shouldWizardBeTriggered()
    {
        // Get triggers from configuration and redirect to wizard if any of them fires
        $triggerClasses = config('setup_wizard.triggers');
        foreach ($triggerClasses as $tc) {
            /** @var WizardTrigger $trigger */
            $trigger = new $tc();
            if ($trigger->shouldLaunchWizard()) return true;
        }

        return false;
    }
    /**
     * Check Database for Wizard 
     * @return bool Returns the Value of Wizard in User Model
     */
    public static function hasWizardCompleted()
    {
        
        // Check For Authenticated User!
        try{
            $done = request()->user()->wizard;
            return $done;
        }catch(\Exception $e) {
            throw new \Exception('No Authorize User, Please Log In First!');
        }

        
    }
}