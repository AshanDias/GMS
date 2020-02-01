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

 
Route::get('/401', function() {
    return view('error');
});

Auth::routes(['verify' => true]);
Auth::routes();
// Route::group(['middleware' => ['web']], function () { 

Route::group(['middleware' => 'verified'], function () {  
   
    Route::get('/', 'HomeController@index');
    Route::get('/prp', function() {
        return [5,10,25,50,100,150,200,250,300];
    });

    //user CRUD
    Route::get('/initial/users/data/{count}','Auth\RegisterController@populateUsersData');
    Route::get('/populate/users/{count}','Auth\RegisterController@populateUsers');
    Route::post('/create/user','Auth\RegisterController@createUser');
    Route::post('/update/user','Auth\RegisterController@updateUser');
    Route::get('/delete/user/{id}','Auth\RegisterController@deleteUser');

    //vehicle CRUD
    Route::get('/populate/vehicles/{count}','VehicleController@populateVehicle');
    Route::post('/populate/all/data','VehicleController@index');
    Route::get('/populate/all/vehicles','VehicleController@vehicleData');
    Route::post('/create/vehicle','VehicleController@store');
    Route::post('/update/vehicle','VehicleController@update');
    Route::get('/delete/vehicle/{id}','VehicleController@destroy');

    //Employee CRUD
    Route::post('/populate/employees','EmployeeController@populateEmployee');
    Route::post('/create/employee','EmployeeController@store');
    Route::post('/update/employee','EmployeeController@update');
    Route::get('/delete/employee/{id}','EmployeeController@destroy');
    Route::post('/update/employee/password','EmployeeController@passwordChange');

    //Collector Group
    Route::post('/collector/groups','EmployeeGroupController@index');
    Route::post('/create/employee/group','EmployeeGroupController@store');
    
    //Customer Request
    Route::post('/customer/request/data','CustomerRequestController@index');
    Route::post('/approve/customer/request','CustomerRequestController@update');
    Route::get('/data','CustomerRequestController@data');

    //Customer Rrequest Approve Mail
    Route::post('/sendbasicemail','MailController@basic_email');

    //Vehicle Payment Assing
    Route::post('/populate/vehicle/payment/data/get','VehiclePaymentController@populateInitialData');
    Route::post('/assign/vehicle/type/payment/post','VehiclePaymentController@store');
    Route::post('/update/vehicle/type/payment/post','VehiclePaymentController@update');
    Route::get('/delete/vehicle/type/payment/get/{id}','VehiclePaymentController@destroy');

     //Area Payment Assing
     Route::post('/populate/area/payment/data/get','AreaPaymentController@populateInitialData');
     Route::post('/assign/area/payment/post','AreaPaymentController@store');
     Route::post('/update/area/payment/post','AreaPaymentController@update');
     Route::get('/delete/area/payment/get/{id}','AreaPaymentController@destroy');

     //Dashboard
     Route::get('/dashboard/data','CustomerRequestController@dashboardData');
    
    
 
});

//test

Route::get('/show/{id}', 'CustomerRequestController@show');

 
//Mobile Web api

//Customer
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
Route::post('/payment/approve','PaymentDetailController@store');

//Driver Login
Route::post('/driver/login','EmployeeController@driverLogin');

