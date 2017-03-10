<?php

Route::get('/templates', [
    'prefix' => 'api',
    'uses' => 'Api\TemplateController@index',
    'as' => 'api.templates.index'
]);

Route::post('/loadTemplateToFlows/{bot?}', [
    'prefix' => 'api',
    'uses' => 'Api\TemplateController@loadTemplateToFlows',
    'as' => 'api.templates.loadTemplateToFlows'
]);