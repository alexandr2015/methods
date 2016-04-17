<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'as' => 'methods.main',
    'uses' => 'MethodsController@showForm',
]);

Route::post('/table', [
    'as' => 'methods.table',
    'uses' => 'MethodsController@showTable',
]);

Route::post('/calculate', [
    'as' => 'methods.calculate',
    'uses' => 'MethodsController@calculate'
]);
Route::post('/lexicographicOptimization', [
    'as' => 'methods.lexicographicOptimization',
    'uses' => 'MethodsController@lexicographicOptimization'
]);
Route::post('/linearConvolution', [
    'as' => 'methods.linearConvolution',
    'uses' => 'MethodsController@linearConvolution'
]);
Route::post('/multiplicativeConvolution', [
    'as' => 'methods.multiplicativeConvolution',
    'uses' => 'MethodsController@multiplicativeConvolution'
]);
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
