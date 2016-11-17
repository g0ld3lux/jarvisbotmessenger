<?php

Route::group([
  'middleware' => ['auth','prevent-back-history'],
  'prefix' => 'payment',
  'namespace' => 'Payment',
  'as' => 'payment.'
  ], function () {

  Route::get('/', ['as'  => 'index', 'uses' => 'PaymentController@index']);

  Route::get('paypal', [
      'uses' => 'PaypalController@prepare',
      'as' => 'paypal.prepare',
  ]);

  Route::any('paypal/{payumToken}', [
      'uses' => 'PaypalController@done',
      'as' => 'done',
  ]);

  Route::any('offline',[
    'uses' => 'OfflineController@prepare',
    'as' => 'offline.prepare',
  ]);

  Route::any('offline/{payumToken}',[
    'uses' => 'OfflineController@done',
    'as' => 'offline.done',
  ]);

  // CRUD Payments -> Admin Stuff
    Route::any('test/paymentmodel',[
      'uses' => 'PaypalController@testPaymentModel',
      'as' => 'testPaymentModel',
    ]);
  // CRUD Gateway Config -> Admin Stuff
    Route::any('test/gatewaymodel',[
      'uses' => 'PaypalController@testGateWayModel',
      'as' => 'testGateWayModel',
    ]);

});
