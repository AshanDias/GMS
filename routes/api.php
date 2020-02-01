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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => 'hasApiToken'], function() {

//Customer
// api/customer/create
Route::post('/customer/create','CustomerController@store');
Route::get('/customer/email/{email}','CustomerController@index');
Route::get('/customer/all','CustomerController@all');

//CustomerRequest
Route::post('/customer/request','CustomerRequestController@store');
Route::get('/customer/all/request','CustomerRequestController@populateData');
Route::get('/customer/request/email/{email}','CustomerRequestController@userViceData');
Route::get('/driver/request/get','CustomerRequestController@driverRequestData');

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


Route::get('/data', function() {
    return "sadasd";
});


});

