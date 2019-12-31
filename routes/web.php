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

// Route::get('/', function () {
//     return view('home');
// });


Route::group(['middleware' => ['web']], function () {

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

//user CRUD
Route::get('/populate/users/{count}','Auth\RegisterController@populateUsers');
Route::post('/create/user','Auth\RegisterController@createUser');
Route::post('/update/user','Auth\RegisterController@updateUser');
Route::get('/delete/user/{id}','Auth\RegisterController@deleteUser');

//Route::post('/logout/user','Auth\LoginController@logout');
});