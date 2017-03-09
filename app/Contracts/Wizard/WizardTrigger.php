<?php

namespace App\Contracts\Wizard;


interface WizardTrigger
{

    /**
     * Indicates if the wizard should be launched or not
     *
     * @return boolean
     */
    function shouldLaunchWizard();

}