<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | You can configure the routing for the wizard here (or even turn it off
    | altogether)
    */

    'routing' => [
        // Load the routes specified by the package, if not, you have to create
        // the routes by yourself in your project's route file
        'load_default'  => true,

        // When using default routes, here are some ways to customize them
        'prefix'        => 'bot-wizard',

        // Once the wizard completes, you can redirect to a specific route name
        'success_route' => 'account.index',

        // Once the wizard completes, you can redirect to a specific route url
        // (if not using the success route name)
        'success_url'   => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Triggers
    |--------------------------------------------------------------------------
    |
    | Triggers are used to determine if the wizard has to be ran. Each of the
    | triggers is a class which implements the
    | App\Contracts\Wizard\WizardTrigger interface
    */

    'triggers' => [
        \App\Wizard\Triggers\NewUserSignUp::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steps
    |--------------------------------------------------------------------------
    |
    | Each step will be ran in order. Each of the step is a class which
    | implements the MarvinLabs\SetupWizard\Contracts\WizardStep interface
    |
    | REMEMBER THIS:
    | Each Key Must be the Same in the steps.php in resources/lang/wizard/en/steps.php
    | Each Key Must Also Be the Same name for their corresponding view example: create-bot.blade.php
    */

    
    'steps' => [
        // Create A Bot
        'create-bot'       => \App\Wizard\Steps\CreateANewBot::class,
        // Get Permission For Facebook To Manage Page -> javascript related
        'connect-fanpage' => \App\Wizard\Steps\ManageFanPage::class,
        // Ask if You Want to Import A Template or Blank Template
        'choose-bot-template' => \App\Wizard\Steps\ChooseTemplate::class,
        // Add Greetings Text
        'add-greetings' => \App\Wizard\Steps\AddGreetings::class,
        // Add Get Started Responds
        'add-get-started-message' => \App\Wizard\Steps\AddGetStartedMessage::class,
        // Add Persistent Menu
        'add-persistent-menu'   => \App\Wizard\Steps\AddPersistentMenu::class,
        // Start Talking to A Bot
        'completed'        => \App\Wizard\Steps\Completed::class,
        
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Theming
    |--------------------------------------------------------------------------
    |
    | You can indicate the name of the CSS file to use to customize the wizard
    | appearance
    */

    'theme'              => 'material',

];