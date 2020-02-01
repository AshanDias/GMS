<?php

namespace App\Http\Controllers;

use App\VehiclePayment;
use Illuminate\Http\Request;
use DB;

class VehiclePaymentController extends Controller
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

    
    public function populateInitialData(Request $request)
    { 

        $rpp = $request->rpp;
        $search_str = $request->search_str;

        $vehicleTypeData = DB::table('vehicle_types')  
        ->select( 'vehicle_types.id','vehicle_types.type_code')
        ->get();

        $VehiclePayment = VehiclePayment::join('vehicle_types','vehicle_types.id','vehicle_payments.vehicle_type_id')
        ->select('vehicle_payments.*','vehicle_types.type_code')
        ->where('vehicle_types.type_code','like','%'.$search_str.'%')
        ->paginate($rpp);
        return array('vehicle_type_data'=>$vehicleTypeData,'payments'=>$VehiclePayment);
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
        $customMessages = [
            'id.required' => 'The vehicle field is required.',
            'price.required' => 'The price field is required.',
            'id.unique' => "This vehicle type alredy added, please update it!"
        ];
        $this->validate($request,[
           'id'=>'required|unique:vehicle_payments,vehicle_type_id,',
           'price'=>'required'
        ],$customMessages);

       try {
        $vehiclePayment = new VehiclePayment();
        $vehiclePayment->vehicle_type_id = $request->id;
        $vehiclePayment->price = $request->price;
        $result = $vehiclePayment->save();

        if($result)
            return 'Success';
        else
            return 'Fail';
       } catch (Exception $th) {
           $th->getMessage();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehiclePayment  $vehiclePayment
     * @return \Illuminate\Http\Response
     */
    public function show(VehiclePayment $vehiclePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehiclePayment  $vehiclePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiclePayment $vehiclePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehiclePayment  $vehiclePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       try {
        $vehiclePayment = VehiclePayment::find($request->id);
        $vehiclePayment->price = $request->price;
        $result = $vehiclePayment->save();

        if($result)
        return 'Success';
        else
        return 'Fail';
       } catch (Exception $th) {
          return $th->getMessage();
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehiclePayment  $vehiclePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try {           
            $vehiclePayment = VehiclePayment::find($id);
            $result=$vehiclePayment->delete();
            if($result)
            return 'Success';
            else
            return 'Fail';
       } catch (Exception $th) {
            $th->getMessage();
       }
    }
}
