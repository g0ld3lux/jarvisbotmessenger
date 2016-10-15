<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::group(['middleware' => ['admin']], function () {

        Route::get('/', [
            'uses' => 'DashboardController@getIndex',
            'as' => 'dashboard',
            '__rp' => [
                'menu' => 'dashboard',
            ],
        ]);

        Route::group(['prefix' => 'users', 'as' => 'users.', '__rp' => ['menu' => 'users']], function () {

            Route::get('/', [
                'uses' => 'UsersController@index',
                'as' => 'index',
                '__rp' => ['sub_menu' => 'index']
            ]);

            Route::get('/create', [
                'uses' => 'UsersController@create',
                'as' => 'create',
                '__rp' => ['sub_menu' => 'create',]
            ]);

            Route::post('/store', [
                'uses' => 'UsersController@store',
                'as' => 'store',
            ]);

            Route::group(['prefix' => '{user}'], function () {

                Route::get('/', [
                    'uses' => 'UsersController@show',
                    'as' => 'show',
                    '__rp' => ['sub_menu' => 'index', 'action' => 'show'],
                ]);

                Route::get('/edit', [
                    'uses' => 'UsersController@edit',
                    'as' => 'edit',
                    '__rp' => ['sub_menu' => 'index', 'action' => 'edit'],
                ]);

                Route::post('/update', [
                    'uses' => 'UsersController@update',
                    'as' => 'update',
                ]);

                Route::delete('/delete', [
                    'uses' => 'UsersController@delete',
                    'as' => 'delete',
                ]);

                Route::get('impersonate', [
                    'as' => 'impersonate',
                    'uses' => 'UsersController@impersonate'
                ]);

                Route::get('impersonate/stop', [
                    'as' => 'deimpersonate',
                    'uses' => 'UsersController@stopImpersonate'
                ]);
            });

        });

    });

});
