<?php

namespace App\Http\Controllers;

use App\PaymentDetails;
use App\Payment;
use Illuminate\Http\Request;
use DB;

class PaymentDetailController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return 'success';
        //return $request;
        $result= false;
        $result2 = false;

        try {
        
        DB::beginTransaction();
            
        // $Payment = Payment::where('customers_request_id',$request->req_id)->get();         
        // $Payment->status_id = 7;
        // $result =  $Payment->update();

        
        $result = DB::update('update payments set status_id = 7 where customers_request_id = '.$request->req_id.' ');
        
        $PaymentDetails = new PaymentDetails();
        $PaymentDetails->payment_id = 1;
        $PaymentDetails->acc_no = $request->acc_no;
        $PaymentDetails->cvv = $request->cvv;
        $PaymentDetails->exp_date = $request->exp_date;
        $result2 = $PaymentDetails->save();
    
        if($result2 && $result)
        return response('success',200);
        else
        return response('fail',401);

        DB::commit();
        
        } catch (Exception $th) {
            
            DB::rollback();
            
           return $th->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentDetails $paymentDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentDetails $paymentDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentDetails $paymentDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentDetails $paymentDetails)
    {
        //
    }
}
