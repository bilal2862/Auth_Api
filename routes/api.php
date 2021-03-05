<?php

use Illuminate\Http\Request;


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

Route::middleware(['auth:api'])->group(function () {



    Route::get('/user', function (Request $request) {
        return $request->user();
    });
  
    
});



Route::post('/register','AuthController@register');

Route::post('/login','AuthController@login');

Route::post('/logout','AuthController@logout')->middleware(['auth:api']);


Route::get('/show','AuthController@show')->middleware(['auth:api']);


Route::post('password/email', 'ForgotPasswordController@forgot');

Route::post('password/reset', 'ForgotPasswordController@reset');

