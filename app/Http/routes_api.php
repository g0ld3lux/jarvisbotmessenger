<?php

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {

    Route::post('/validate/matcher', [
        'uses' => 'ValidateController@validateMatcher',
        'as' => 'api.validate.matcher',
    ]);

    Route::get('bot/analytics', [
        'uses' => 'BotController@analytics',
        'as' => 'api.bot.analytics',
    ]);

    Route::resource('bot', 'BotController', [
        'only' => ['show'],
    ]);

    Route::post('/bot/{bot}/page/connect', [
        'uses' => 'BotController@connectPage',
        'as' => 'api.bot.page.connect',
    ]);

    Route::delete('/bot/{bot}/page/disconnect', [
        'uses' => 'BotController@disconnectPage',
        'as' => 'api.bot.page.disconnect',
    ]);

    Route::resource('bot.respond', 'BotRespondController', [
        'only' => ['index', 'destroy'],
    ]);

    Route::get('/bot/{bot}/flow/export', [
        'uses' => 'BotFlowController@export',
        'as' => 'api.bot.flow.export',
    ]);

    Route::post('/bot/{bot}/flow/import', [
        'uses' => 'BotFlowController@import',
        'as' => 'api.bot.flow.import',
    ]);

    Route::post('/bot/{bot}/flow/sort', [
        'uses' => 'BotFlowController@updateSort',
        'as' => 'api.bot.flow.sort',
    ]);

    Route::resource('bot.flow', 'BotFlowController', [
        'only' => ['show', 'index', 'store', 'destroy', 'update'],
    ]);

    Route::post('/bot/{bot}/flow/{flow}/default', [
        'uses' => 'BotFlowController@makeDefault',
        'as' => 'api.bot.flow.default',
    ]);

    Route::delete('/bot/{bot}/flow/{flow}/default', [
        'uses' => 'BotFlowController@deleteDefault',
        'as' => 'api.bot.flow.default.delete',
    ]);

    Route::resource('bot.flow.matcher', 'BotFlowMatcherController', [
        'only' => ['destroy', 'store', 'update'],
    ]);

    Route::group(['prefix' => '/bot/{bot}/subscription'], function () {
        Route::resource('channel', 'Bot\Subscription\ChannelController', [
            'only' => ['index', 'store', 'show', 'update', 'destroy'],
        ]);

        Route::get(
            '/channel/{channel}/recipient/missing',
            'Bot\Subscription\Channel\RecipientController@missingRecipients'
        );

        Route::resource('channel.recipient', 'Bot\Subscription\Channel\RecipientController', [
            'only' => ['index', 'destroy', 'store'],
        ]);

        Route::resource('channel.broadcast', 'Bot\Subscription\Channel\BroadcastController', [
            'only' => ['index', 'store', 'show', 'destroy'],
        ]);

        Route::resource('channel.broadcast.schedule', 'Bot\Subscription\Channel\Broadcast\ScheduleController', [
            'only' => ['index'],
        ]);
    });

    Route::resource('bot.recipient', 'Bot\RecipientController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('bot.message', 'Bot\MessageController', [
        'only' => ['index', 'store', 'show', 'destroy'],
    ]);

    Route::resource('bot.message.schedule', 'Bot\Message\ScheduleController', [
        'only' => ['index'],
    ]);

    Route::post('/bot/{bot}/recipient/{recipient}/chat/disable', [
        'uses' => 'Bot\RecipientController@disableChat',
        'as' => 'api.bot.recipient.chat.disable',
    ]);

    Route::post('/bot/{bot}/recipient/{recipient}/chat/enable', [
        'uses' => 'Bot\RecipientController@enableChat',
        'as' => 'api.bot.recipient.chat.enable',
    ]);

    Route::post('/bot/{bot}/recipient/{recipient}/refresh', [
        'uses' => 'Bot\RecipientController@refresh',
        'as' => 'api.bot.recipient.refresh',
    ]);

    Route::resource('bot.recipient.channel', 'Bot\Recipient\ChannelController', [
        'only' => ['index', 'destroy', 'store'],
    ]);

    Route::resource('bot.recipient.history', 'Bot\Recipient\HistoryController', [
        'only' => ['index'],
    ]);

});
