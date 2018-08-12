<?php


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

Route::middleware('api')->get('/league/{year?}', 'APIController@league');
Route::middleware('api')->get('/standings/{year?}', 'APIController@standings');
Route::middleware('api')->get('/scores/{year?}', 'APIController@scores');
Route::middleware('api')->get('/players', 'APIController@players');
Route::middleware('api')->get('/currentweek', 'APIController@currentWeek');
Route::middleware('api')->get('/rosters/{id?}', 'APIController@rosters');
