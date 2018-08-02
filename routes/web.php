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

Route::get('/mfl', function () {
    return redirect('https://' . config('mfl.league_host') . '/' . config('mfl.league_year') . '/home/' . config('mfl.league_id'));
});

Route::get('/login', 'Auth\AuthController@login')->name('login');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
