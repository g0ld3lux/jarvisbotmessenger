<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

include 'routes_admin.php';

include 'routes_cron.php';

include 'routes_payment.php';

include 'routes_auth.php';

include 'routes_user.php';

include 'routes_features.php';

include 'routes_plan.php';

Route::get('/privacy', ['as'  => 'privacy', 'uses' => 'HomeController@privacy']);
