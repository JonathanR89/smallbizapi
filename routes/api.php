<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'api'], function () {
    Route::get('questions/{id}', 'QuestionnaireController@getMetrics');
    Route::get('categories', 'QuestionnaireController@getCategories');
    Route::post('questionnaire', 'QuestionnaireController@saveSubmissionScores');

// Route::post('questionnaire', 'QuestionnaireController@neilsway');

// Route::group(['middleware' => 'Cors'], function () {
    Route::get('save-submission-user', 'QuestionnaireController@saveSubmissionUser');
    // Route::post('/api/chargeCustomer', 'Backend\PaymentController@chargeCustomer');
// });
