<?php

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {

    Route::post('/validate/matcher', [
        'uses' => 'ValidateController@validateMatcher',
        'as' => 'api.validate.matcher',
    ]);

    Route::get('/project/{project}/analytics', [
        'uses' => 'ProjectController@analytics',
        'as' => 'api.project.analytics',
    ]);

    Route::resource('project', 'ProjectController', [
        'only' => ['show'],
    ]);

    Route::post('/project/{project}/page/connect', [
        'uses' => 'ProjectController@connectPage',
        'as' => 'api.project.page.connect',
    ]);

    Route::delete('/project/{project}/page/disconnect', [
        'uses' => 'ProjectController@disconnectPage',
        'as' => 'api.project.page.disconnect',
    ]);

    Route::resource('project.respond', 'ProjectRespondController', [
        'only' => ['index', 'destroy'],
    ]);

    Route::get('/project/{project}/flow/export', [
        'uses' => 'ProjectFlowController@export',
        'as' => 'api.project.flow.export',
    ]);

    Route::post('/project/{project}/flow/import', [
        'uses' => 'ProjectFlowController@import',
        'as' => 'api.project.flow.import',
    ]);

    Route::post('/project/{project}/flow/sort', [
        'uses' => 'ProjectFlowController@updateSort',
        'as' => 'api.project.flow.sort',
    ]);

    Route::resource('project.flow', 'ProjectFlowController', [
        'only' => ['show', 'index', 'store', 'destroy', 'update'],
    ]);

    Route::post('/project/{project}/flow/{flow}/default', [
        'uses' => 'ProjectFlowController@makeDefault',
        'as' => 'api.project.flow.default',
    ]);

    Route::delete('/project/{project}/flow/{flow}/default', [
        'uses' => 'ProjectFlowController@deleteDefault',
        'as' => 'api.project.flow.default.delete',
    ]);

    Route::resource('project.flow.matcher', 'ProjectFlowMatcherController', [
        'only' => ['destroy', 'store', 'update'],
    ]);

    Route::group(['prefix' => '/project/{project}/subscription'], function () {
        Route::resource('channel', 'Project\Subscription\ChannelController', [
            'only' => ['index', 'store', 'show', 'update', 'destroy'],
        ]);

        Route::get(
            '/channel/{channel}/recipient/missing',
            'Project\Subscription\Channel\RecipientController@missingRecipients'
        );

        Route::resource('channel.recipient', 'Project\Subscription\Channel\RecipientController', [
            'only' => ['index', 'destroy', 'store'],
        ]);

        Route::resource('channel.broadcast', 'Project\Subscription\Channel\BroadcastController', [
            'only' => ['index', 'store', 'show', 'destroy'],
        ]);

        Route::resource('channel.broadcast.schedule', 'Project\Subscription\Channel\Broadcast\ScheduleController', [
            'only' => ['index'],
        ]);
    });

    Route::resource('project.recipient', 'Project\RecipientController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('project.message', 'Project\MessageController', [
        'only' => ['index', 'store', 'show', 'destroy'],
    ]);

    Route::resource('project.message.schedule', 'Project\Message\ScheduleController', [
        'only' => ['index'],
    ]);

    Route::post('/project/{project}/recipient/{recipient}/chat/disable', [
        'uses' => 'Project\RecipientController@disableChat',
        'as' => 'api.project.recipient.chat.disable',
    ]);

    Route::post('/project/{project}/recipient/{recipient}/chat/enable', [
        'uses' => 'Project\RecipientController@enableChat',
        'as' => 'api.project.recipient.chat.enable',
    ]);

    Route::post('/project/{project}/recipient/{recipient}/refresh', [
        'uses' => 'Project\RecipientController@refresh',
        'as' => 'api.project.recipient.refresh',
    ]);

    Route::resource('project.recipient.channel', 'Project\Recipient\ChannelController', [
        'only' => ['index', 'destroy', 'store'],
    ]);

    Route::resource('project.recipient.history', 'Project\Recipient\HistoryController', [
        'only' => ['index'],
    ]);

});
