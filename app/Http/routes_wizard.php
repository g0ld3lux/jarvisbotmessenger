<?php

/** @var \Config $config */

Route::group([
    'prefix' => $config->get('setup_wizard.routing.prefix'),
    'middleware' => ['web','auth']
], function() {

    // Show the first step of the wizard
    Route::get('/', [
        'as' => 'setup_wizard.start',
        'uses' => 'App\Http\Controllers\WizardController@showStep'
    ]);

    // Show a step for a wizard
    Route::get('{slug?}', [
        'as' => 'setup_wizard.show',
        'uses' => 'App\Http\Controllers\WizardController@showStep'
    ])->where('slug', '([a-zA-Z0-9\-])*');

    // Submit a step for a wizard
    Route::post('{slug?}', [
        'as' => 'setup_wizard.submit',
        'uses' => 'App\Http\Controllers\WizardController@submitStep'
    ])->where('slug', '([a-zA-Z0-9\-])*');
});