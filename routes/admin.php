<?php

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

Route::middleware('can:skin-api.manage')->group(function () {
    Route::get('/', 'AdminController@index')->name('home');
    Route::post('/', 'AdminController@update')->name('update');
    
    Route::get('/skins', 'AdminController@skins')->name('skins');
    Route::post('/skins', 'AdminController@updateSkins')->name('skins.update');
    
    Route::get('/capes', 'AdminController@capes')->name('capes');
    Route::post('/capes', 'AdminController@updateCapes')->name('capes.update');
});
