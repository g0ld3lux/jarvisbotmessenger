<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['middleware' => ['admin','prevent-back-history'], '__rp' => ['menu' => 'features']], function () {
        Route::resource('features', 'FeaturesController');
        Route::get('features/toggleActive/{id}', ['uses' => 'FeaturesController@toggleActive', 'as' => 'admin.features.toggleActive']);

    });

    Route::group(['middleware' => ['admin','prevent-back-history'], '__rp' => ['menu' => 'packages']], function () {
        Route::resource('packages', 'PackagesController');
        Route::get('packages/toggleFeatured/{id}', ['uses' => 'PackagesController@toggleFeatured', 'as' => 'admin.packages.toggleFeatured']);
        Route::get('packages/toggleActive/{id}', ['uses' => 'PackagesController@toggleActive', 'as' => 'admin.packages.toggleActive']);
    });
});
