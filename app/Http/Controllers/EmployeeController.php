<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       //
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   public function populateEmployee($count)
   {
       return Employee::paginate($count);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {           
       $this->validate($request,[
           'first_name'=>'required|max:50',
           'last_name'=>'required|max:50',
           'nic'=>'required|max:15|unique:employee_details',
           'telephone_no'=>'required|max:15|unique:employee_details',
       ]);

       try {

           $employee = new Employee();
           $employee->first_name = $request->first_name;
           $employee->last_name = $request->last_name;
           $employee->nic = $request->nic;
           $employee->telephone_no = $request->telephone_no;
           $result = $employee->save();

           if($result)
           return 'Success'; 

       } catch (Exception $th) {
            return $th;
       }

   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Employee  $Employee
    * @return \Illuminate\Http\Response
    */
   public function show(Vehicle $vehicle)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Employee  $Employee
    * @return \Illuminate\Http\Response
    */
   public function edit(Vehicle $vehicle)
   {
       //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Employee  $Employee
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
       $this->validate($request,[
        'first_name'=>'required|max:50',
        'last_name'=>'required|max:50',
        'nic'=>'required|max:15|unique:employee_details',
        'telephone_no'=>'required|max:15|unique:employee_details',
       ]);
      try {
        $employee = Employee::find($request->id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->nic = $request->nic;
        $employee->telephone_no = $request->telephone_no;
        $result = $employee->save();

       if($result)
       return 'Success';

      } catch (Exception $th) {
          return $th;
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Employee  $Employee
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       try {
           $employee = Employee::findOrFail($id);
           $result = $employee->delete();
           if($result)
           return 'Success';
       } catch (Exception $th) {
            return $th;
       }

   }
}