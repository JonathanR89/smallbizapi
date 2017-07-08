<?php

use Illuminate\Http\Request;

// route
Route::get('auth', 'AuthController@auth');

// Route::group(['middleware' => 'auth:api'], function () {
    Route::get('save-submission-user', 'QuestionnaireController@saveSubmissionUser');
    Route::get('questions/{id}', 'QuestionnaireController@getMetrics');
    Route::get('categories', 'QuestionnaireController@getCategories');
    Route::post('questionnaire', 'QuestionnaireController@saveSubmissionScores');
// });
