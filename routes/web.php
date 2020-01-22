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


//Auth::routes(['verify' => true]);
Auth::routes();
Route::group(['middleware' => ['web']], function () { 

//Route::group(['middleware' => 'verified'], function () {  

    Route::get('/', 'HomeController@index');

    //user CRUD
    Route::get('/initial/users/data/{count}','Auth\RegisterController@populateUsersData');
    Route::get('/populate/users/{count}','Auth\RegisterController@populateUsers');
    Route::post('/create/user','Auth\RegisterController@createUser');
    Route::post('/update/user','Auth\RegisterController@updateUser');
    Route::get('/delete/user/{id}','Auth\RegisterController@deleteUser');

    //vehicle CRUD
    Route::get('/populate/vehicles/{count}','VehicleController@populateVehicle');
    Route::get('/populate/all/data/{count}','VehicleController@index');
    Route::post('/create/vehicle','VehicleController@store');
    Route::post('/update/vehicle','VehicleController@update');
    Route::get('/delete/vehicle/{id}','VehicleController@destroy');

    //Employee CRUD
    Route::get('/populate/employees/{count}','EmployeeController@populateEmployee');
    Route::post('/create/employee','EmployeeController@store');
    Route::post('/update/employee','EmployeeController@update');
    Route::get('/delete/employee/{id}','EmployeeController@destroy');
    Route::post('/update/employee/password','EmployeeController@passwordChange');

    //Collector Group
    Route::get('/collector/groups/{count}','EmployeeGroupController@index');
    Route::post('/create/employee/group','EmployeeGroupController@store');
    
    //Customer Request
    Route::get('/customer/request/{count}','CustomerRequestController@index');
    Route::post('/approve/customer/request','CustomerRequestController@update');
   
 
});
 
//Mobile Web api

//Customer
Route::post('/customer/create','CustomerController@store');

//CustomerRequest
Route::post('/customer/request','CustomerRequestController@store');
Route::get('/customer/all/request','CustomerRequestController@populateData');
Route::get('/customer/request/email/{email}','CustomerRequestController@userViceData');

//Area
Route::get('/areas/all','AreaController@populateArea');

//Category
Route::get('/category/all','CategoryController@populateCategory');

//Vehicle
Route::get('/vehicle/types','VehicleTypeController@populateData');

//Payment
Route::get('/payment/history/email/{email}','PaymentController@index'); 

//Driver Login
Route::post('/driver/login','EmployeeController@driverLogin');

