<?php

namespace App\Http\Controllers;

use App\AreaPayment;
use App\Area;
use Illuminate\Http\Request;

class AreaPaymentController extends Controller
{  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       //
   }

   
   public function populateInitialData($count)
   { 
       $areaData = Area::select('id','name')->get(); 
       
       $areaPayment = AreaPayment::join('areas','areas.id','area_payments.area_id')
       ->select('area_payments.id as pid','area_payments.price','areas.id','areas.name')->paginate($count);
       return array('areadata'=>$areaData,'payments'=>$areaPayment);
   }

 
   public function create()
   {
       //
   }
 
   public function store(Request $request)
   {
       
       $customMessages = [
           'id.required' => 'The area field is required.',
           'price.required' => 'The price field is required.',
           'id.unique' => "This area alredy added, please update it!"
       ];
       $this->validate($request,[
          'id'=>'required|unique:area_payments,area_id,',
          'price'=>'required'
       ],$customMessages);

      try {
       $AreaPayment = new AreaPayment();
       $AreaPayment->area_id = $request->id;
       $AreaPayment->price = $request->price;
       $result = $AreaPayment->save();

       if($result)
           return 'Success';
       else
           return 'Fail';
      } catch (Exception $th) {
          $th->getMessage();
      }
   }
 
   public function show(VehiclePayment $vehiclePayment)
   {
       //
   }
 
   public function edit(VehiclePayment $vehiclePayment)
   {
       //
   }
 
   public function update(Request $request)
   {
      try {
       $AreaPayment = AreaPayment::find($request->id);
       $AreaPayment->price = $request->price;
       $result = $AreaPayment->save();

       if($result)
       return 'Success';
       else
       return 'Fail';
      } catch (Exception $th) {
         return $th->getMessage();
      }
   }
 
   public function destroy($id)
   {
      try {           
           $AreaPayment = AreaPayment::find($id);
           $result=$AreaPayment->delete();
           if($result)
           return 'Success';
           else
           return 'Fail';
      } catch (Exception $th) {
           $th->getMessage();
      }
   }
}
