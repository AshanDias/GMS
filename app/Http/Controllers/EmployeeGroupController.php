<?php

namespace App\Http\Controllers;

use App\EmployeeGroup;
use App\EmployeeGroupDetail;
use App\Employee;
use App\Vehicle;
use Illuminate\Http\Request;
use DB;

class EmployeeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($count)
    {
         $drivers = Employee::select(DB::raw("CONCAT(first_name,' ',last_name ) as name"),'id')->where('employee_type_id',4)->where('have_group',0)->get();
         $workers = Employee::select(DB::raw("CONCAT(first_name,' ',last_name ) as name"),'id','employee_type_id')->where('employee_type_id',5)->where('have_group',0)->get();
         $vehicles = Vehicle::select('id','name','reg_no')->where('status_id',1)->where('have_group',0)->get();
         $collector_group = EmployeeGroup::where('employee_groups.status_id',1)         
         ->join('employees','employees.id','employee_groups.driver_id')
         ->join('vehicles','vehicles.id','employee_groups.vehicle_id')
         ->select('employee_groups.*',DB::raw("CONCAT(employees.first_name,' ',employees.last_name ) as name"),'vehicles.reg_no')
         ->get();
         
         $group_members=[];
         $collector_group_with_members=[];
         foreach ($collector_group as $group) {

            $group_members = EmployeeGroupDetail::where('employee_group_id',$group['id'])
            ->join('employees','employees.id','employee_group_details.worker_id')
            ->select('employee_group_details.*',DB::raw("CONCAT(employees.first_name,' ',employees.last_name ) as name"))
            ->get();
            array_push($collector_group_with_members,array("collector_group"=>$collector_group,"group_member"=>$group_members)); 
         }

         return array("groups"=>$collector_group,"drivers"=>$drivers,"workers"=>$workers,"vehicles"=>$vehicles,"collector_group_with_members"=>$collector_group_with_members);
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
       // return $request;
        $request->validate([
            "group_code"=>"required",
            "driver_id"=>"required",
            "vehicle_id"=>"required",
            "selectedWorkers"=>"required"

        ]);
            
        try {
            $result = false;
            $result1 = false;
            $result2 = false;
            DB::beginTransaction();
            
            $EmployeeGroup = new EmployeeGroup();
            $EmployeeGroup->group_code = $request->group_code;
            $EmployeeGroup->driver_id = $request->driver_id;
            $EmployeeGroup->vehicle_id = $request->vehicle_id;
            $EmployeeGroup->status_id = 1;
            $result=$EmployeeGroup->save();

            $employee = Employee::find($request->driver_id);
            $employee->have_group = 1;
            $employee->save();

            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle->have_group = 1;
            $vehicle->save();
                        
            foreach($request->selectedWorkers as $worker)
            { 
                $EmployeeGroupDetail = new EmployeeGroupDetail();
                $EmployeeGroupDetail->employee_group_id = $EmployeeGroup->id;
                $EmployeeGroupDetail->worker_id = $worker['id'];
                $result1 = $EmployeeGroupDetail->save();

                $employee = Employee::find($worker['id']);
                $employee->have_group = 1;
                $result2 = $employee->save();
            }
            
             DB::commit();
           
        } catch (\Throwable $th) {
             
             DB::rollback();

            return array("exception"=>$th->getMessage());
        }
         
        if($result1 && $result && $result2)        
        return "Success";
        else {
            return 0;
        }
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
