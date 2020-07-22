<?php
/*Event::listen('illuminate.query',function($query){
    var_dump($query);
});*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'Client\MainController@index');
Route::group(['middleware'=>'main'],function() {

    Route::get('/signup', 'Client\MainController@signup');
    Route::post('/signup/userdata', 'Client\MainController@userdata');
    Route::get('/search', 'Client\MainController@search');
    Route::get('/search/detail', 'Client\MainController@detail');
    Route::post('/signup/update', 'Client\MainController@update');

});

Route::group(['middleware'=>'login'],function() {
    Route::get('/admin', 'Admin\AdminController@index');
    Route::get('/admin/confirm', 'Admin\AdminController@confirm');
    Route::get('/admin/detail', 'Admin\AdminController@detail');
    Route::get('/admin/confirm/update', 'Admin\AdminController@update');
    Route::get('/admin/confirm/force', 'Admin\AdminController@force');
    //Route::get('/admin/overview', 'Admin\AdminController@overview');
    Route::get('/admin/overview/alllist', 'Admin\AdminController@alllist');
    Route::get('/admin/delete', 'Admin\AdminController@delete');
    Route::get('/admin/logout', 'UserController@logout');
    Route::get('/admin/classManager','Admin\ClassManagerController@classManager');
    Route::get('/admin/classManagerAdd','Admin\ClassManagerController@classManagerAdd');
    Route::get('/admin/classManagerUpdate','Admin\ClassManagerController@classManagerUpdate');
    Route::get('/admin/classManagerDetail','Admin\ClassManagerController@classManagerDetail');
    Route::get('/admin/classManagerDel','Admin\ClassManagerController@classManagerDel');
    Route::post('/admin/classManagerAction','Admin\ClassManagerController@classManagerAction');
    Route::post('/admin/classManagerConditionAction','Admin\ClassManagerController@classManagerConditionAction');
    Route::get('/admin/classManagerConditionDelete','Admin\ClassManagerController@classManagerConditionDelete');
    Route::get('/admin/classManagerDelete','Admin\ClassManagerController@classManagerDelete');
    Route::get('/admin/option','Admin\OptionController@index');
    Route::post('/admin/option/rule','Admin\OptionController@rule');
    Route::post('/admin/option/note','Admin\OptionController@note');
    Route::post('/admin/option/admin','Admin\OptionController@admin');
    Route::get('/admin/log',function(){
        return view('admin.log');
    });
    Route::get('/ajax/datechange', 'Client\AjaxController@datechange');
    Route::get('/ajax/switchs', 'Client\AjaxController@switchs');
    
});

Route::get('/ajax/class_check', 'Client\AjaxController@class_check');
Route::get('/ajax/remain_class', 'Client\AjaxController@remain_class');
Route::get('/ajax/check', 'Client\AjaxController@check');
Route::get('/ajax/idcheck', 'Client\AjaxController@idcheck');
Route::get('/ajax/show_class', 'Client\AjaxController@show_class');
Route::get('/ajax/abstracts', 'Client\AjaxController@abstracts');


Route::get('/admin/login','UserController@login');
Route::post('/admin/check','UserController@check');
