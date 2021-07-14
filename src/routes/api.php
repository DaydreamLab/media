<?php

use DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController;
use DaydreamLab\Media\Controllers\File\Admin\FileAdminController;
use DaydreamLab\Media\Controllers\File\Front\FileFrontController;
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

Route::post('api/admin/file/store', [FileAdminController::class, 'store'])
    ->middleware(['expired', 'admin']);
Route::post('api/admin/file/remove', [FileAdminController::class, 'remove'])
    ->middleware(['expired', 'admin']);


Route::get('api/file/download/{uuid}', [FileFrontController::class, 'download']);
