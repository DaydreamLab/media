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

Route::post('api/admin/media/upload', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@upload')
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/move', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@move')
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/folder/items', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@getFolderItems')
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/folder/create', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@createFolder')
    ->middleware(['expired', 'admin']);
Route::get('api/admin/media/folder/all', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@getAllFolders')
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/remove', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@remove')
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/rename', 'DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController@rename')
    ->middleware(['expired', 'admin']);

