<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('project_home'));
});

Route::group(['prefix'=>'admin'],function(){
    Route::group(['prefix'=>'project'],function(){
        Route::get('/','ProjectController@project_home')->name('project_home');
        Route::get('/add','ProjectController@project_add')->name('project_add');
        Route::post('/action','ProjectController@project_action')->name('project_action');
    });

});
