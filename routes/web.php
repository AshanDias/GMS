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

//vehicle CRUD
Route::get('/populate/vehicles/{count}','VehicleController@populateVehicle');
Route::post('/create/vehicle','VehicleController@store');
Route::post('/update/vehicle','VehicleController@update');
Route::get('/delete/vehicle/{id}','VehicleController@destroy');

//vehicle CRUD
Route::get('/populate/employees/{count}','EmployeeController@populateEmployee');
Route::post('/create/employee','EmployeeController@store');
Route::post('/update/employee','EmployeeController@update');
Route::get('/delete/employee/{id}','EmployeeController@destroy');

//Route::post('/logout/user','Auth\LoginController@logout');
});