<?php
Route::group(['middleware' => 'prevent-back-history', 'namespace' => 'Auth', 'as' => 'auth.'], function () {
  Route::get('password/reset/{token?}', ['as' => 'showResetForm', 'uses' =>'PasswordController@showResetForm']);
  Route::post('password/email', ['as' => 'sendResetLinkEmail', 'uses' =>'PasswordController@sendResetLinkEmail']);
  Route::post('password/reset', ['as' => 'reset', 'uses' =>'PasswordController@reset']);
  Route::get('logout', ['as' => 'logout', 'uses' =>'AuthController@logout']);
  Route::get('login', ['as' => 'getLogin', 'uses' =>'AuthController@getLogin']);
  Route::post('login', ['as' => 'postLogin', 'uses' =>'AuthController@postLogin']);
  Route::get('register', ['as' => 'getRegister', 'uses' =>'AuthController@getRegister']);
  Route::post('register', ['as' => 'postRegister', 'uses' =>'AuthController@postRegister']);
  Route::get('user/activation/{token}', ['as' => 'userActivation', 'uses' =>'AuthController@userActivation']);
  Route::get('auth/token', ['as'  => 'get2FA', 'uses' => 'AuthController@getGoogle2fa']);
  Route::post('auth/token', [ 'as'  => 'post2FA', 'middleware' => 'throttle:3', 'uses' => 'AuthController@postGoogle2fa']);
  Route::get('redirect/{provider}', ['as' => 'redirect', 'uses' =>'SocialAuthController@redirect']);
  Route::get('callback/{provider}', ['as' => 'callback', 'uses' =>'SocialAuthController@callback']);
});
