<?php

namespace App\Http\Controllers;

use App\CustomerRequest;
use App\Vehicle;
use App\Payment;
use App\Customer;
use App\EmployeeGroup;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class CustomerRequestController extends Controller
{
    //DashBoard data
    public function dashboardData()
    {
        //This Week
        $weekStartDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = Carbon::now()->endOfWeek()->format('Y-m-d');

        //This Month
        $monthStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $monthEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        //This Year
        $yearStartData = Carbon::now()->startOfYear()->format('Y-m-d');
        $yearEndData = Carbon::now()->endOfYear()->format('Y-m-d');
        
        $todayRequest = CustomerRequest::join('categories','categories.id','customer_requests.category_id')
        ->join('vehicle_types','vehicle_types.id','customer_requests.vehicle_type_id')
        ->where('request_date',Carbon::now()->toDateString()) 
        ->orderBy('customer_requests.id','DESC') 
        ->get();

        $events = CustomerRequest::join('categories','categories.id','customer_requests.category_id')
        ->join('vehicle_types','vehicle_types.id','customer_requests.vehicle_type_id')
        ->whereBetween('request_date',[$monthStartDate,$monthEndDate]) 
        ->orderBy('customer_requests.id','DESC') 
        ->select(DB::raw('concat(customer_requests.address_1,customer_requests.address_2) as title'),'customer_requests.request_date as date' )
        ->get();
        $today = CustomerRequest::where('request_date',Carbon::now()->toDateString())->count();
        $thisWeek = CustomerRequest::whereBetween('request_date',array($weekStartDate,$weekEndDate))->count();
        $thisMonth = CustomerRequest::whereBetween('request_date',array($monthStartDate,$monthEndDate))->count();
        $thisYear = CustomerRequest::whereBetween('request_date',array($yearStartData,$yearEndData))->count();
        $CustomerRequest = array('todayRequest'=>$todayRequest ,'events'=>$events,'today'=>$today,'thisWeek'=>$thisWeek,'thisMonth'=>$thisMonth,'thisYear'=>$thisYear);
        return $CustomerRequest;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $count = $request->rpp;
        $search_str = $request->search_str;

        $customerRequest = CustomerRequest::join('areas','areas.id','customer_requests.area_id')
        ->join('categories','categories.id','customer_requests.category_id')
        ->join('statuses','statuses.id','customer_requests.status_id')
        ->join('vehicle_types','vehicle_types.id','customer_requests.vehicle_type_id') 
        ->with(['employeegroup' => function($query)
        {
            $query->select('id as grp_id','group_code');
        }]) 
        ->where('customer_requests.customer_name','LIKE','%'.$search_str.'%')
        ->orWhere('customer_requests.tele_no','LIKE','%'.$search_str.'%')
        ->orWhere('areas.name','LIKE','%'.$search_str.'%')
        ->select('customer_requests.*','areas.name as area_name','categories.name as category_name','statuses.status','statuses.id as status_id','vehicle_types.type_code as vehicle_type')        
        ->orderBy('id','DESC')
        ->paginate($count);

        $vehicles = Vehicle::select('id','name')->where('status_id',1)->get();
        $employeeGroup = EmployeeGroup::select('id','group_code')->where('status_id',1)->get();
        //return $customerRequest;
        return array('group_data'=>$employeeGroup,'vehicles'=>$vehicles,'customerRequest'=>$customerRequest);
 
    }

    public function userViceData($email)
    {
        $customerRequest = CustomerRequest::join('areas','areas.id','customer_requests.area_id')
            ->join('categories','categories.id','customer_requests.category_id')
            ->join('statuses','statuses.id','customer_requests.status_id')
            ->join('vehicle_types','vehicle_types.id','customer_requests.vehicle_type_id') 
            ->where('customer_requests.email',$email)
            ->with(['vehicle' => function($quary){
                $quary->select('id','name');
            }])
            ->select('customer_requests.*','areas.name as area_name','categories.name as category_name','statuses.status','statuses.id as status_id')
            ->orderBy('id','DESC')
            ->get();

        return response($customerRequest,200);
    }

    public function populateData()
    {
        return CustomerRequest::join('areas','areas.id','customer_requests.area_id')
        ->join('categories','categories.id','customer_requests.category_id')
        ->join('statuses','statuses.id','customer_requests.status_id')
        ->join('vehicle_types','vehicle_types.id','customer_requests.vehicle_type_id') 
        ->with(['vehicle' => function($quary){
            $quary->select('id','name');
        }])
        ->select('customer_requests.*','areas.name as area_name','categories.name as category_name','statuses.status','statuses.id as status_id','vehicle_types.type_code as vehicle_type')
        ->orderBy('id','DESC')
        ->paginate($count);
    }

    public function driverRequestData()
    {
         
        $customerRequest = CustomerRequest::select('customer_name','address_1','address_2','address_3','longitude'
        ,'latitude')
            ->get();

        return $customerRequest;
     
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
        
        // $this->validate($request,[
        //     'user_id'=>'required|max:50',
        //     'longitude'=>'required',
        //     'latitude'=>'required',
        //     'address'=>'required',
        //     'category_id'=>'required'
        //   ]);
        $customer_id = Customer::where('email',$request->email)->select('id')->first();
        if($customer_id == null)
        {
            return response("Please register first!",404);
        }
        else
        {
            try {
                $customerRequest = new CustomerRequest();
                $customerRequest->user_id =  $customer_id->id;
                $customerRequest->customer_name = $request->customer_name;
                $customerRequest->email = $request->email;
                $customerRequest->area_id = $request->area_id;
                $customerRequest->vehicle_type_id = $request->vehicle_type_id;           
                $customerRequest->description =  $request->description;
                $customerRequest->tele_no =  $request->tele_no;
                $customerRequest->longitude = $request->longitude;
                $customerRequest->latitude =  $request->latitude;
                $customerRequest->address_1 =  $request->address_1;
                $customerRequest->address_2 =  $request->address_2;
                $customerRequest->address_3 =  $request->address_3;
                $customerRequest->category_id =  $request->category_id;
                $customerRequest->status_id =3;
                $customerRequest->request_date = Carbon::now()->toDateString();
                $customerRequest->request_time = Carbon::now()->toTimeString();
                $result = $customerRequest->save();

                if($result)
                return response($customerRequest, 200);
                else
                return response('0', 422);  
    
            } catch (Exception $th) {
                return $th;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerRequest $customerRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerRequest $customerRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        //return $request;
        //calculate amount
       
       try {
        
        DB::beginTransaction(); 
        
        $result = false;
        $result2 = false;       

        $CustomerRequest = CustomerRequest::find($request->id);
        $CustomerRequest->employee_group_id = $request->group_id;
        $CustomerRequest->status_id = 8;
        $result = $CustomerRequest->save();

        $amount_details = DB::table('customer_requests')
        ->join('employee_groups','employee_groups.id','customer_requests.employee_group_id')
        ->join('vehicles','vehicles.id','employee_groups.vehicle_id') 
        ->join('vehicle_payments','vehicle_payments.vehicle_type_id','vehicles.vehicle_type_id')
        ->join('area_payments','area_payments.area_id','customer_requests.area_id') 
        ->where('customer_requests.id',$request->id)        
        ->select('vehicle_payments.price as v_type_price','area_payments.price as area_price','customer_requests.user_id','customer_requests.customer_name')
        ->first();
 
        $request_id = $request->id;
        $customer_id = $amount_details->user_id;
        $customer_name = $amount_details->customer_name;
        $v_type_price = $amount_details->v_type_price;
        $area_price = $amount_details->area_price;
        $total_amount = $v_type_price + $area_price;
        

        $Payment = new Payment();
        $Payment->customers_id = $customer_id;
        $Payment->name = $customer_name;
        $Payment->customers_request_id = $request_id;
        $Payment->total_payment = $total_amount;
        $Payment->date = Carbon::now()->toDateString();
        $Payment->time = Carbon::now()->toTimeString();
        $Payment->status_id = 8;
        $result2 = $Payment->save();

        DB::commit();
        
        if($result && $result2)
            return 'Success';
        else
            return '0';

       } catch (Exception $th) {           
           DB::rollback();           
           return $th->getException();
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerRequest $customerRequest)
    {
        //
    }
}
