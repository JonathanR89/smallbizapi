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

// Route::get("test", function () {
//     throw new \Illuminate\Database\Eloquent\MassAssignmentException;
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/analytics', ['as' => 'analytics', 'uses' => 'HomeController@analyticsData']);
    Route::get('/packages', ["as" => "packages", "uses" => 'PackageController@index']);
    Route::any('/packages/search', ["as" => "package_search", "uses" => 'PackageController@searchTable']);
    Route::post('/update_package_score', ['as' => "update_package_score", 'uses' => "PackageController@updateScore"]);
    Route::post('/update_package_availability', ['as' => "update_package_availability", 'uses' => "PackageController@packageAvailability"]);
    Route::get('/package/toggle_interested', ['as' => "toggle_interested", 'uses' => "VendorController@toggleInterested"]);
    Route::post('/package/toggle_interested/update', ['as' => "update_toggle_interested", 'uses' => "VendorController@packageInterested"]);
    Route::post('/packages/search/interested', ["as" => "package_search_interested", "uses" => 'VendorController@searchTable']);
    Route::get('/package/toggle_review', ['as' => "toggle_review", 'uses' => "VendorController@toggleReview"]);
    Route::post('/package/toggle_review/update', ['as' => "update_toggle_review", "uses" => 'VendorController@packageReview']);
    Route::post('/packages/search/review', ["as" => "package_search_review", "uses" => 'VendorController@searchTableReview']);

    Route::get('package/toggle_get_quote', ['as' => "toggle_get_quote", 'uses' => "VendorController@toggleGetQuote"]);
    Route::post('package/toggle_get_quote/update', ['as' => "update_toggle_get_quote", 'uses' => 'VendorController@packageQuote']);
    Route::post('package/search/quote', ["as" => "package_search_quote", "uses" => 'VendorController@searchTableQuote']);

    Route::get('package/toggle_visit_website', ['as' => "toggle_visit_website", 'uses' => "VendorController@toggleVisitWebsite"]);
    Route::post('package/toggle_visit_website/update', ['as' => "update_toggle_visit_website"]);
    Route::post('package/search/website', ['as' => "package_search_website", "uses" =>'VendorController@searchTableWebsite']);

    Route::resource('/consultant-questionnaire', 'ConsultantCategoryController');
    Route::resource('/consultant-questions', 'ConsultantQuestionController');

    // Dash
    Route::get('/emails-sent', ['as' => "emails_sent", 'uses' => "DashboardController@index"]);
    Route::get('/referrals-sent', ['as' => "referrals_sent", 'uses' => "DashboardController@getRefferalsSent"]);

    //questions
    Route::get('/question-selects', ["as" => "question_selects", "uses" => 'QuestionsController@index']);
    Route::resource('/submission-industries', 'SubmissionIndustryController');
    Route::resource('/submission-price-ranges', 'SubmissionPriceRangeController');
    Route::resource('/submission-user-sizes', 'SubmissionUserSizeController');
//consultants
    Route::get('/consultants', ["as" => "consultants", "uses" => 'ConsultantsController@index']);
    Route::get('/add-consultant', ["as" => "add_consultant", "uses" => 'ConsultantsController@create']);
    Route::post('/save-consultant', ["as" => "save_consultant", "uses" => 'ConsultantsController@store']);
    Route::get('/consultant/{id}', ["as" => "consultant_show", "uses" => 'ConsultantsController@show']);

    //vendor CRUD
    Route::get('/all-vendors', ["as" => "all_vendors", "uses" => 'VendorController@index']);
    Route::any('/vendor/search', ["as" => "search_vendors", "uses" => 'VendorController@searchVendors']);
    Route::get('/vendor/{id}/show/', ["as" => "show_vendor", "uses" => 'VendorController@show']);
    Route::get('/vendor/stats/', ["as" => "show_stats", "uses" => 'VendorController@stats']);
    Route::get('/vendor/stats/incomplete/{id}', ["as" => "show_vendor_incomplete", "uses" => 'VendorController@showVendorIncomplete']);
    Route::get('/vendor/create', ["as" => "create_vendor", "uses" => 'VendorController@create']);
    Route::post('/vendor/save', ["as" => "save_vendor", "uses" => 'VendorController@store']);
    Route::put('/vendor/update/{id}', ["as" => "update_vendor", "uses" => 'VendorController@update']);
    //all-vendors/{id} delete make it look like you tring to delete all vendors
    Route::get('vendor/{id}/destroy', 'VendorController@destroy');
   // Route::resource('/all-vendors/destroy/{id}', ["as" => "delete_vendor", "uses" =>'VendorController@destroy']);

});
Route::get('/crm_vendors', ['as' => 'vendor_info', 'uses' => 'VendorController@apiAirTableVendors']);
Route::post('/vendor', 'EmailController@listener');
Route::any('/email-results', ['as' => 'email_results', 'uses' => 'EmailController@sendUsersResults']);
Route::any('/email-user-scores', ['as' => 'email_results_scores', 'uses' => 'EmailController@sendUserScoreSheet']);
