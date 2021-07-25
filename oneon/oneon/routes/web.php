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
    return view('welcome');
});

Route::get('/test', function() {
    return view('test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/regist', 'EmployeeController@definitiveRegist')->name('definitive-regist');
Route::post('/regist/execute', 'EmployeeController@definitiveExecute')->name('definitive-execute');
Route::get('/employee/update', 'EmployeeController@update')->name('employee.update');
Route::post('/employee/update/execute', 'EmployeeController@updateExecute')->name('employee.update.execute');
Route::get('/matching/request', 'MatchingController@matchingRequest')->name('matching.request');
Route::post('/matching/search', 'MatchingController@matchingSearchExecute')->name('matching.search.execute');
Route::post('/matching/request/execute', 'MatchingController@matchingRequestExecute')->name('matching.search.execute');
Route::post('/matching/reception', 'MatchingReceptionController@reception')->name('matching.reception');
Route::post('/matching/reception/execute', 'MatchingReceptionController@receptionExecute')->name('matching.reception.execute');
Route::get('/matchingDetails', function() {
    return view('pages/matching/matchingDetails1onCompletion');
});
Route::get('/matching', 'MatchingDetails1onCompletionController@init');