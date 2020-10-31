<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'filemanager'], function () {
    Route::get('/', 'ContentBankController@index')->name('content_bank_index');

    Route::post('directory-store', 'ContentBankController@directoryStore');
    Route::post('directory-destroy/{id}', 'ContentBankController@directoryDestroy');
    Route::post('directory-edit/{id}', 'ContentBankController@directoryEdit');

    Route::get('directory-list', 'ContentBankController@directoryList');

    Route::post('content-store', 'ContentBankController@contentStore');
    Route::get('content-list/{id}', 'ContentBankController@contentList');

    Route::get('setting', 'SettingController@index')->name('setting_index');
    Route::post('setting-configuration', 'SettingController@settingConfiguration');
});
