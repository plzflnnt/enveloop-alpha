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
    if(Auth::check()){
        return redirect('home');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/new-envelope', 'EnvelopeController@createEnvelope')->name('home');
Route::post('/new-earning', 'EnvelopeController@createEarning')->name('home');
Route::post('/new-expense', 'EnvelopeController@createExpense')->name('home');
Route::get('/undo-earning/{id}', 'EnvelopeController@undoEarning')->name('home');
Route::get('/transactions/', 'EnvelopeController@transactions')->name('home');
Route::get('/report/', 'EnvelopeController@report')->name('home');
Route::get('/envelope/{id}', 'EnvelopeController@envelope')->name('home');


