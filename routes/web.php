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
    Route::post('/update_package_availability', [ 'as' => "update_package_availability", 'uses' => "PackageController@packageAvailability"]);
    Route::get('/emails-sent', [ 'as' => "emails_sent", 'uses' => "EmailController@getEmailsSent"]);
    Route::get('/package/toggle_interested', [ 'as' => "toggle_interested", 'uses' => "VendorController@toggleInterested"]);
    Route::post('/package/toggle_interested/update', [ 'as' => "update_toggle_interested", 'uses' => "VendorController@packageInterested"]);
    Route::post('/packages/search/interested', [ "as" => "package_search_interested", "uses" =>'VendorController@searchTable']);

    Route::resource('/consultant-questionnaire', 'ConsultantCategoryController');
    // Route::get('/consultant-category', [ "as" => "consultant_questionnaire", "uses" =>'ConsultantCategoryController@index']);


    Route::get('/consultants', [ "as" => "consultants", "uses" =>'ConsultantsController@index']);
    Route::get('/add-consultant', [ "as" => "add_consultant", "uses" =>'ConsultantsController@create']);
    Route::post('/save-consultant', [ "as" => "save_consultant", "uses" =>'ConsultantsController@store']);
    Route::get('/consultant/{id}', [ "as" => "consultant_show", "uses" =>'ConsultantsController@show']);
});
Route::post('/vendor', 'EmailController@listener');
Route::get('/crm_vendors', ['as' => 'vendor_info', 'uses' => 'VendorController@index']);
Route::any('/email-results', ['as' => 'email_results', 'uses' => 'EmailController@sendUsersResults']);
Route::any('/email-user-scores', ['as' => 'email_results_scores', 'uses' => 'EmailController@sendUserScoreSheet']);
