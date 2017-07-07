<?php

use Illuminate\Http\Request;

// header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
// header('Access-Control-Allow-Headers: content-type');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'cors'], function () {
Route::get('questions/{id}', 'QuestionnaireController@getMetrics');
Route::get('categories', 'QuestionnaireController@getCategories');
// Route::post('questionnaire', 'QuestionnaireController@saveSubmission');
Route::post('questionnaire', 'QuestionnaireController@neilsway');
// });

// Route::group(['middleware' => 'cors'], function(){
//     // Route::post('/api/chargeCustomer', 'Backend\PaymentController@chargeCustomer');
// });
