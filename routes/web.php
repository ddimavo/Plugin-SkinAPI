<?php

use Azuriom\Plugin\SkinApi\Controllers\Admin\AdminController;
use Azuriom\Plugin\SkinApi\Controllers\SkinApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [SkinApiController::class, 'index'])->name('home');
Route::get('/capes', [SkinApiController::class, 'capes'])->name('capes');

Route::middleware('auth')->group(function () {
    // Skin Management Routes
    Route::post('/skin/update', [SkinApiController::class, 'updateSkin'])->name('skin.update');
    
    // Cape Management Routes
    Route::post('/capes/upload', [SkinApiController::class, 'uploadCape'])->name('capes.upload');
    Route::delete('/capes/delete', [SkinApiController::class, 'deleteCape'])->name('capes.delete');
});

Route::prefix('admin')->middleware(['admin-access', 'can:skin-api.admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/capes', [AdminController::class, 'capes'])->name('admin.capes');
    Route::post('/capes', [AdminController::class, 'updateCapes'])->name('admin.capes.update');
    Route::post('/capes/default', [AdminController::class, 'updateDefaultCape'])->name('admin.capes.default');
    Route::delete('/capes/default', [AdminController::class, 'removeDefaultCape'])->name('admin.capes.default.remove');
});
