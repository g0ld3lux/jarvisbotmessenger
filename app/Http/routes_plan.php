<?php


Route::group([
  'middleware' => ['auth','prevent-back-history'],
  'prefix' => 'plans',
  'namespace' => 'Plan',
  'as' => 'plans.'
  ], function () {

  Route::get('/', ['as'  => 'index', 'uses' => 'SubscriptionPlanController@index']);


});
