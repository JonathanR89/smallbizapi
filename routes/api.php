<?php

use Illuminate\Http\Request;

// route
Route::get('auth', 'AuthController@auth');

Route::group(['middleware' => ['api']], function () {
    Route::get('industries', 'QuestionnaireController@getIndustries');
    Route::get('user-size', 'QuestionnaireController@getSubmissionUserSize');
    Route::get('save-submission-user', 'QuestionnaireController@saveSubmissionUser');
    Route::get('questions', 'QuestionnaireController@getMetrics');
    Route::get('categories', 'QuestionnaireController@getCategories');
    Route::post('questionnaire', 'QuestionnaireController@saveSubmissionScores');
    Route::post('save-initial-user-details', 'QuestionnaireController@saveSubmissionUserDetails');
});
