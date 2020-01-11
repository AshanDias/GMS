<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use DB;

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
       return DB::table('employees')
       ->join('statuses','statuses.id','employees.status_id')
       ->select('employees.*','statuses.status')->paginate();
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
           'nic'=>'required|max:11|unique:employees',
           'employee_type_id'=>'required',
           'telephone_no'=>'required',
       ]);

       try {

           $employee = new Employee();
           $employee->first_name = $request->first_name;
           $employee->last_name = $request->last_name;
           $employee->nic = $request->nic;
           $employee->telephone_no = $request->telephone_no;
           $employee->employee_type_id = $request->employee_type_id;
           $employee->status_id = $request->status_id;
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
        'nic'=>'required|max:11|unique:employees,nic,'.$request->id,
        'employee_type_id'=>'required',
        'telephone_no'=>'required',
       ]);
      try {
        $employee = Employee::findOrFail($request->id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->nic = $request->nic;
        $employee->telephone_no = $request->telephone_no;
        $employee->employee_type_id = $request->employee_type_id;
        $employee->status_id = $request->status_id;
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