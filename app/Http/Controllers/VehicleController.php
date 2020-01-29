<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleType;
use App\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rpp = $request->rpp;
        $search_str = $request->search_str;
        $year=[];
        for ($index = 30; $index > 0; $index--) { 
            array_push($year, Carbon::now()->year+1 - $index);
        }        
        $vehicle_list =  DB::table('vehicles')
        ->join('statuses','statuses.id','vehicles.status_id')
        ->join('vehicle_types','vehicle_types.id','vehicles.vehicle_type_id')
        ->where('vehicles.name','like','%'.$search_str.'%')
        ->orWhere('vehicles.reg_no','like','%'.$search_str.'%')
        ->select('vehicles.*','statuses.status','vehicle_types.type_code')
        ->paginate($rpp);
        $vehicle_type =  VehicleType::select('id','type_code')->where('status_id',1)->get();
        $status = Status::select('id','status')->where('id',1)->orWhere('id',2)->get();
        
        $arr = array("vehicle_list"=>$vehicle_list,"vehicle_type"=>$vehicle_type,"years"=>$year,"status"=>$status);
        return $arr;
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

    public function populateVehicle($count)
    { 

        return DB::table('vehicles')
        ->join('statuses','statuses.id','vehicles.status_id')
        ->join('vehicle_types','vehicle_types.id','vehicles.vehicle_type_id')
        ->select('vehicles.*','statuses.status','vehicle_types.type_code')
        ->paginate($count);
        
    }

    public function vehicleData()
    {
        return DB::table('vehicles') 
        ->join('vehicle_types','vehicle_types.id','vehicles.vehicle_type_id')
        ->select('vehicles.id as vid','vehicles.name','vehicles.reg_no','vehicle_types.type_code')
        ->get();
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
            'name'=>'required|max:50|unique:vehicles',
            'reg_no'=>'required|max:50|unique:vehicles',
            'reg_year'=>'required',
            'vehicle_type_id'=>'required', 
        ]);

        try {

            $vehicle = new Vehicle();
            $vehicle->name = $request->name;
            $vehicle->reg_no = $request->reg_no;
            $vehicle->manf_year = $request->manf_year;
            $vehicle->reg_year = $request->reg_year;
            $vehicle->vehicle_type_id = $request->vehicle_type_id;
            $vehicle->status_id = $request->status_id;
            $result = $vehicle->save();

            if($result)
            return 'Success'; 

        } catch (Exception $th) {
             return $th;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
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
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50|unique:vehicles,name,'.$request->id,
            'reg_no'=>'required|max:50|unique:vehicles,reg_no,'.$request->id,
            'reg_year'=>'required',
            'vehicle_type_id'=>'required', 
        ]);
       try {
        $vehicle = Vehicle::find($request->id);
        $vehicle->name = $request->name;
        $vehicle->reg_no = $request->reg_no;
        $vehicle->manf_year = $request->manf_year;
        $vehicle->reg_year = $request->reg_year;
        $vehicle->vehicle_type_id = $request->vehicle_type_id;
        $vehicle->status_id = $request->status_id;
        $result = $vehicle->save();

        if($result)
        return 'Success';

       } catch (Exception $th) {
           return $th;
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $result = $vehicle->delete();
            if($result)
            return 'Success';
        } catch (Exception $th) {
             return $th;
        }

    }
}
