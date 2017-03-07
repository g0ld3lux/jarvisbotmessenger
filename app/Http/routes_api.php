<?php

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {

    Route::post('/validate/matcher', [
        'uses' => 'ValidateController@validateMatcher',
        'as' => 'api.validate.matcher',
    ]);

    Route::get('bot/analytics', [
        'uses' => 'ProjectController@analytics',
        'as' => 'api.project.analytics',
    ]);

    Route::resource('bot', 'ProjectController', [
        'only' => ['show'],
    ]);

    Route::post('/bot/{bot}/page/connect', [
        'uses' => 'ProjectController@connectPage',
        'as' => 'api.project.page.connect',
    ]);

    Route::delete('/bot/{bot}/page/disconnect', [
        'uses' => 'ProjectController@disconnectPage',
        'as' => 'api.project.page.disconnect',
    ]);

    Route::resource('bot.respond', 'ProjectRespondController', [
        'only' => ['index', 'destroy'],
    ]);

    Route::get('/bot/{bot}/flow/export', [
        'uses' => 'ProjectFlowController@export',
        'as' => 'api.project.flow.export',
    ]);

    Route::post('/bot/{bot}/flow/import', [
        'uses' => 'ProjectFlowController@import',
        'as' => 'api.project.flow.import',
    ]);

    Route::post('/bot/{bot}/flow/sort', [
        'uses' => 'ProjectFlowController@updateSort',
        'as' => 'api.project.flow.sort',
    ]);

    Route::resource('bot.flow', 'ProjectFlowController', [
        'only' => ['show', 'index', 'store', 'destroy', 'update'],
    ]);

    Route::post('/bot/{bot}/flow/{flow}/default', [
        'uses' => 'ProjectFlowController@makeDefault',
        'as' => 'api.project.flow.default',
    ]);

    Route::delete('/bot/{bot}/flow/{flow}/default', [
        'uses' => 'ProjectFlowController@deleteDefault',
        'as' => 'api.project.flow.default.delete',
    ]);

    Route::resource('bot.flow.matcher', 'ProjectFlowMatcherController', [
        'only' => ['destroy', 'store', 'update'],
    ]);

    Route::group(['prefix' => '/bot/{bot}/subscription'], function () {
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

    Route::resource('bot.recipient', 'Project\RecipientController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('bot.message', 'Project\MessageController', [
        'only' => ['index', 'store', 'show', 'destroy'],
    ]);

    Route::resource('bot.message.schedule', 'Project\Message\ScheduleController', [
        'only' => ['index'],
    ]);

    Route::post('/bot/{bot}/recipient/{recipient}/chat/disable', [
        'uses' => 'Project\RecipientController@disableChat',
        'as' => 'api.project.recipient.chat.disable',
    ]);

    Route::post('/bot/{bot}/recipient/{recipient}/chat/enable', [
        'uses' => 'Project\RecipientController@enableChat',
        'as' => 'api.project.recipient.chat.enable',
    ]);

    Route::post('/bot/{bot}/recipient/{recipient}/refresh', [
        'uses' => 'Project\RecipientController@refresh',
        'as' => 'api.project.recipient.refresh',
    ]);

    Route::resource('bot.recipient.channel', 'Project\Recipient\ChannelController', [
        'only' => ['index', 'destroy', 'store'],
    ]);

    Route::resource('bot.recipient.history', 'Project\Recipient\HistoryController', [
        'only' => ['index'],
    ]);

});
