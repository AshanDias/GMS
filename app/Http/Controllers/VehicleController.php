<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
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

    public function populateVehicle($count)
    {
        return Vehicle::paginate($count);
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
            'reg_no'=>'required|max:50|unique:vehicles'
        ]);

        try {

            $vehicle = new Vehicle();
            $vehicle->name = $request->name;
            $vehicle->reg_no = $request->reg_no;
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
            'name'=>'required|max:50|unique:vehicles',
            'reg_no'=>'required|max:50|unique:vehicles'
        ]);
       try {
        $vehicle = Vehicle::find($request->id);
        $vehicle->name = $request->name;
        $vehicle->reg_no = $request->reg_no;
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
