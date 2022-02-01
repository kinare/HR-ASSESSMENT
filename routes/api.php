<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'prefix' => 'auth'], function (){
    Route::post('/login', 'AuthController@login');
    Route::get('/logout', 'AuthController@logout')->middleware('auth:sanctum');
    Route::get('/reset', 'AuthController@reset');
});


Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'auth:sanctum'], function (){
    Route::get('/policies', 'PolicyController@index');
    Route::get('/assessments', 'EmployeeAssessmentController@index');
    Route::post('/assessments', 'EmployeeAssessmentController@store');
    Route::get('/scales', 'AssessmentScaleController@index');
});
