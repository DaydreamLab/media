<?php

use DaydreamLab\Media\Controllers\Media\Admin\MediaAdminController;
use DaydreamLab\Media\Controllers\File\Admin\FileAdminController;
use DaydreamLab\Media\Controllers\File\Front\FileFrontController;
use DaydreamLab\Media\Controllers\FileCategory\Admin\FileCategoryAdminController;
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



/************** File（檔案） ************/
# 上傳檔案
Route::post('api/admin/file/upload', [FileAdminController::class, 'upload'])->middleware(['expired', 'admin']);
# 刪除上傳檔案
Route::post('api/admin/file/deleteUpload', [FileAdminController::class, 'deleteUpload'])->middleware(['expired', 'admin']);
# 新增/編輯 檔案
Route::post('api/admin/file/store', [FileAdminController::class, 'store'])->middleware(['expired', 'admin']);
# 刪除檔案
Route::post('api/admin/file/remove', [FileAdminController::class, 'remove'])->middleware(['expired', 'admin']);
# 搜尋檔案
Route::post('api/admin/file/search', [FileAdminController::class, 'search'])->middleware(['expired', 'admin']);
# 更新檔案狀態
Route::post('api/admin/file/state', [FileAdminController::class, 'state'])->middleware(['expired', 'admin']);
# 回存檔案
Route::post('api/admin/file/restore', [FileAdminController::class, 'restore'])->middleware(['expired', 'admin']);
# 取得檔案
Route::get('api/admin/file/{id}', [FileAdminController::class, 'getItem'])->middleware(['expired', 'admin']);


/************** FileCategory（檔案類型） ************/
# 新增/編輯 檔案類型
Route::post('api/admin/file/category/store', [FileCategoryAdminController::class, 'store'])->middleware(['expired', 'admin']);
# 刪除檔案
Route::post('api/admin/file/category/remove', [FileCategoryAdminController::class, 'remove'])->middleware(['expired', 'admin']);
# 搜尋檔案
Route::post('api/admin/file/category/search', [FileCategoryAdminController::class, 'search'])->middleware(['expired', 'admin']);
# 更新檔案分類狀態
Route::post('api/admin/file/category/state', [FileCategoryAdminController::class, 'state'])->middleware(['expired', 'admin']);
# 回存檔案
Route::post('api/admin/file/category/restore', [FileCategoryAdminController::class, 'restore'])->middleware(['expired', 'admin']);
# 取得檔案
Route::get('api/admin/file/category/{id}', [FileCategoryAdminController::class, 'getItem'])->middleware(['expired', 'admin']);


# 下載檔案
Route::post('api/file/download/{uuid}', [FileFrontController::class, 'download']);
# 搜尋檔案
Route::post('api/file/search', [FileFrontController::class, 'search']);