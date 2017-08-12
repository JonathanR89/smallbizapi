<?php

use Illuminate\Http\Request;

// route
Route::get('auth', 'AuthController@auth');

Route::group(['middleware' => ['api']], function () {
    Route::get('industries', 'QuestionnaireController@getIndustries');
    Route::get('price-ranges', 'QuestionnaireController@getPriceRanges');
    Route::get('user-size', 'QuestionnaireController@getSubmissionUserSize');
    Route::get('save-submission-user', 'QuestionnaireController@saveSubmissionUser');
    Route::get('questions', 'QuestionnaireController@getMetrics');
    Route::get('categories', 'QuestionnaireController@getCategories');
    Route::post('questionnaire', 'QuestionnaireController@saveSubmissionScores');
    Route::post('save-initial-user-details', 'QuestionnaireController@saveSubmissionUserDetails');
    Route::get('get-user-results/{submissionID}', 'QuestionnaireController@getUserResults');
    Route::post('vendor', 'EmailAPIController@listener');
    Route::any('email-results', ['as' => 'email_results_api', 'uses' => 'EmailAPIController@sendUsersResults']);
    Route::any('email-user-scores', ['as' => 'email_results_scores_api', 'uses' => 'EmailAPIController@sendUserScoreSheet']);
    Route::any('top-vendors', ['as' => 'top_vendors', 'uses' => 'VendorController@getTopVendors']);
    Route::any('all-vendors', ['as' => 'all_vendors', 'uses' => 'VendorController@getAllVendors']);
    Route::any('get-consultant-categories', ['as' => 'get_consultant_categories', 'uses' => 'ConsultantCategoryController@getCategories']);
    Route::any('get-consultant-questions', ['as' => 'get_consultant_questions', 'uses' => 'ConsultantCategoryController@getCategoryQuestions']);
    Route::any('consultant-questionnaire-results', ['as' => 'get_consultant_questions_results', 'uses' => 'ConsultantsController@getQustionnaireResults']);
});
