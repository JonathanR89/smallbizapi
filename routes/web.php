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

// Route::get('login', 'Auth\AuthController@login');
// Route::post('login', 'Auth\AuthController@postLogin');
// Route::get('auth/token/{token}', 'Auth\AuthController@authenticate');
// Route::get('logout', 'Auth\AuthController@logout');
//
// Route::get('dashboard', function () {
//     return 'Welcome, ' . Auth::user()->name;
// })->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/packages', [ "as" => "packages", "uses" =>'PackageController@index']);
    Route::post('/packages/search', [ "as" => "package_search", "uses" =>'PackageController@searchTable']);
    Route::post('/update_package_score', [ 'as' => "update_package_score", 'uses' => "PackageController@updateScore"]);
    Route::post('/update_package_score', [ 'as' => "update_package_score", 'uses' => "PackageController@updateScore"]);
    Route::post('/update_package_availability', [ 'as' => "update_package_availability", 'uses' => "PackageController@packageAvailability"]);
    Route::post('/vendor', 'EmailController@listener');
    Route::get('/crm_vendors', 'VendorController@index');
});
