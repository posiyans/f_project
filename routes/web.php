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

Auth::routes();
Route::group(['middleware' => 'auth'], function () {

Route::get('/home', 'HomeController@index')->name('home');

/*
група маршрутов для медиков
*/
Route::get('/med', 'WorkerController@index')->name('WorkerSearchIndex');
Route::match(['get', 'post'],'/med/worker/{id?}', 'WorkerController@show')->name('WorkerView');
Route::match(['get', 'post'],'/med/worker/{id?}/edit', 'WorkerController@edit')->name('WorkerEdit');

Route::get('/med/downloadfile/{id}', 'FileController@medDownload')->name('MedFileDownload');
Route::match(['get', 'post'],'/med/complaint/edit/{id}', 'ComplaintController@Edit')->name('MedComplaintEdit');
Route::post('/med/post/worker/search', 'WorkerController@search')->name('WorkerSearch');
Route::post('/med/post/worker/repotr', 'ActionController@actionPeport')->name('WorkeractionPeport');
Route::post('/med/post/worker/complaint/close', 'ComplaintController@close')->name('ComplaintClose');
Route::post('/med/post/worker/action/close', 'ActionController@close')->name('ActionClose');

Route::post('/med/post/smssend', 'SmsController@send')->name('SmsSend');


});