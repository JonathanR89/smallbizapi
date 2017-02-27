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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/packages', 'PackageController@index');
    // Route::get('/submissions', 'SubmissionController@index');
    Route::post('/update_package_score', [ 'as' => "update_package_score", 'uses' => "PackageController@updateScore"]);
    Route::post('/update_package_availability', [ 'as' => "update_package_availability", 'uses' => "PackageController@packageAvailability"]);
    // Route::resource('/categories', 'CategoryController@index');
});
