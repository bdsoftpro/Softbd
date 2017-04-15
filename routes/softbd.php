<?php

use SBD\Softbd\Models\DataType;

/*
|--------------------------------------------------------------------------
| Softbd Routes
|--------------------------------------------------------------------------
|
| This file is where you may override any of the routes that are included
| with Softbd.
|
*/

Route::group(['as' => 'softbd.'], function () {
    event('softbd.routing', app('router'));

    $namespacePrefix = '\\'.config('softbd.controllers.namespace').'\\';

    Route::get('login', ['uses' => $namespacePrefix.'SoftbdAuthController@login',     'as' => 'login']);
    Route::post('login', ['uses' => $namespacePrefix.'SoftbdAuthController@postLogin', 'as' => 'postlogin']);

    Route::group(['middleware' => 'admin.user'], function () use ($namespacePrefix) {
        event('softbd.admin.routing', app('router'));

        // Main Admin and Logout Route
        Route::get('/', ['uses' => $namespacePrefix.'SoftbdController@index',   'as' => 'dashboard']);
        Route::post('logout', ['uses' => $namespacePrefix.'SoftbdController@logout',  'as' => 'logout']);
        Route::post('upload', ['uses' => $namespacePrefix.'SoftbdController@upload',  'as' => 'upload']);

        Route::get('profile', ['uses' => $namespacePrefix.'SoftbdController@profile', 'as' => 'profile']);

        try {
            foreach (DataType::all() as $dataType) {
                $breadController = $dataType->controller
                                 ? $dataType->controller
                                 : $namespacePrefix.'SoftbdBreadController';

                Route::resource($dataType->slug, $breadController);
            }
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
        } catch (\Exception $e) {
            // do nothing, might just be because table not yet migrated.
        }

        // Role Routes
        Route::resource('roles', $namespacePrefix.'SoftbdRoleController');

        // Menu Routes
        Route::group([
            'as'     => 'menus.',
            'prefix' => 'menus/{menu}',
        ], function () use ($namespacePrefix) {
            Route::get('builder', ['uses' => $namespacePrefix.'SoftbdMenuController@builder',    'as' => 'builder']);
            Route::post('order', ['uses' => $namespacePrefix.'SoftbdMenuController@order_item', 'as' => 'order']);

            Route::group([
                'as'     => 'item.',
                'prefix' => 'item',
            ], function () use ($namespacePrefix) {
                Route::delete('{id}', ['uses' => $namespacePrefix.'SoftbdMenuController@delete_menu', 'as' => 'destroy']);
                Route::post('/', ['uses' => $namespacePrefix.'SoftbdMenuController@add_item',    'as' => 'add']);
                Route::put('/', ['uses' => $namespacePrefix.'SoftbdMenuController@update_item', 'as' => 'update']);
            });
        });

        // Settings
        Route::group([
            'as'     => 'settings.',
            'prefix' => 'settings',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'SoftbdSettingsController@index',        'as' => 'index']);
            Route::post('/', ['uses' => $namespacePrefix.'SoftbdSettingsController@store',        'as' => 'store']);
            Route::put('/', ['uses' => $namespacePrefix.'SoftbdSettingsController@update',       'as' => 'update']);
            Route::delete('{id}', ['uses' => $namespacePrefix.'SoftbdSettingsController@delete',       'as' => 'delete']);
            Route::get('{id}/move_up', ['uses' => $namespacePrefix.'SoftbdSettingsController@move_up',      'as' => 'move_up']);
            Route::get('{id}/move_down', ['uses' => $namespacePrefix.'SoftbdSettingsController@move_down',    'as' => 'move_down']);
            Route::get('{id}/delete_value', ['uses' => $namespacePrefix.'SoftbdSettingsController@delete_value', 'as' => 'delete_value']);
        });

        // Admin Media
        Route::group([
            'as'     => 'media.',
            'prefix' => 'media',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'SoftbdMediaController@index',              'as' => 'index']);
            Route::post('files', ['uses' => $namespacePrefix.'SoftbdMediaController@files',              'as' => 'files']);
            Route::post('new_folder', ['uses' => $namespacePrefix.'SoftbdMediaController@new_folder',         'as' => 'new_folder']);
            Route::post('delete_file_folder', ['uses' => $namespacePrefix.'SoftbdMediaController@delete_file_folder', 'as' => 'delete_file_folder']);
            Route::post('directories', ['uses' => $namespacePrefix.'SoftbdMediaController@get_all_dirs',       'as' => 'get_all_dirs']);
            Route::post('move_file', ['uses' => $namespacePrefix.'SoftbdMediaController@move_file',          'as' => 'move_file']);
            Route::post('rename_file', ['uses' => $namespacePrefix.'SoftbdMediaController@rename_file',        'as' => 'rename_file']);
            Route::post('upload', ['uses' => $namespacePrefix.'SoftbdMediaController@upload',             'as' => 'upload']);
            Route::post('remove', ['uses' => $namespacePrefix.'SoftbdMediaController@remove',             'as' => 'remove']);
        });

        // Database Routes
        Route::group([
            'as'     => 'database.bread.',
            'prefix' => 'database',
        ], function () use ($namespacePrefix) {
            Route::get('{table}/bread/create', ['uses' => $namespacePrefix.'SoftbdDatabaseController@addBread',     'as' => 'create']);
            Route::post('bread', ['uses' => $namespacePrefix.'SoftbdDatabaseController@storeBread',   'as' => 'store']);
            Route::get('{table}/bread/edit', ['uses' => $namespacePrefix.'SoftbdDatabaseController@addEditBread', 'as' => 'edit']);
            Route::put('bread/{id}', ['uses' => $namespacePrefix.'SoftbdDatabaseController@updateBread',  'as' => 'update']);
            Route::delete('bread/{id}', ['uses' => $namespacePrefix.'SoftbdDatabaseController@deleteBread',  'as' => 'delete']);
        });

        Route::resource('database', $namespacePrefix.'SoftbdDatabaseController');
    });
});
