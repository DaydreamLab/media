<?php

use DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController;
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

Route::post('api/admin/media/upload', [MediaAdminController::class, 'upload'])
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/move', [MediaAdminController::class, 'move'])
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/folder/items', [MediaAdminController::class, 'getFolderItems'])
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/folder/create', [MediaAdminController::class, 'createFolder'])
    ->middleware(['expired', 'admin']);
Route::get('api/admin/media/folder/all', [MediaAdminController::class, 'getAllFolders'])
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/remove', [MediaAdminController::class, 'remove'])
    ->middleware(['expired', 'admin']);
Route::post('api/admin/media/rename', [MediaAdminController::class, 'rename'])
    ->middleware(['expired', 'admin']);

