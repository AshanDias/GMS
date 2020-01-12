<?php

namespace App\Http\Controllers;

use App\EmployeeGroup;
use App\Employee;
use App\Vehicle;
use Illuminate\Http\Request;

class EmployeeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($count)
    {
         $drivers = Employee::select('*')->where('employee_type_id',4)->get();
         $workers = Employee::select('first_name as name','id as code')->where('employee_type_id',5)->get();
         $vehicles = Vehicle::select('id','name','reg_no')->get();
         $collector_group = EmployeeGroup::paginate($count);

         return array("groups"=>$collector_group,"drivers"=>$drivers,"workers"=>$workers,"vehicles"=>$vehicles);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeGroup  $employeeGroup
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeGroup $employeeGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeGroup  $employeeGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeGroup $employeeGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeGroup  $employeeGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeGroup $employeeGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeGroup  $employeeGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeGroup $employeeGroup)
    {
        //
    }
}
