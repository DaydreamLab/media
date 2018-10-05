<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () {


    Route::group(['middleware' => ['auth:api', 'expired', 'admin'], 'prefix' => 'admin'], function (){

        Route::group(['prefix' => 'media'], function (){
            Route::post('upload', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@upload');
            Route::post('move', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@move');
            Route::post('folder/items', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@getFolderItems');
            Route::post('folder/create', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@createFolder');
            Route::get('folder/all', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@getAllFolders');
            Route::post('remove', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@remove');

        });
    });
});