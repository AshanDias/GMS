<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserType;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function createUser(Request $request)
    {
       // return $request;
       $this->validate($request,[
        'name'=> 'required|max:50',
        'email'=> 'required|max:225|unique:users',
        'user_type_id' => 'required',
        'password'=>'required|min:8'
       ]);
       try {
           
        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->user_type_id = $request->user_type_id;
        $User->password = Hash::make($request->password);
        $result = $User->save();

        if($result)
                return "Success";
        else
                return "Fail";

       } catch (Exception $th) {
            return $th;
       }
    }

    //User Register
    public function populateUsersData($count)
    {
       $userType = UserType::select('id','name')->where('id',1)->orWhere('id',2)->get();
       $user =  DB::table('users')
       ->join('user_types','user_types.id','users.user_type_id')
       ->select('users.*','user_types.name as type_name')
       ->paginate($count);
       

       return array("user_types"=>$userType,"users"=>$user);
    }

    //Employee
    public function populateUsers($count)
    {
        return $user =  DB::table('users')
        ->join('user_types','user_types.id','users.user_type_id')
        ->select('users.*','user_types.name as type_name')
        ->paginate($count);
    }

    public function updateUser(Request $request)
    {
       
        try {    
                if($request->password != null)
                {        
                    $this->validate($request,[
                        'name'=> 'required|max:50',
                        'email'=> 'required|max:225|unique:users,email,'.$request->id,
                        'user_type_id' => 'required',
                        'password'=>'required|min:8'
                       ]);
                      
                        $user = User::find($request->id);
                        $User->name = $request->name;
                        $User->email = $request->email;
                        $User->user_type_id = $request->user_type_id;
                        $User->password = Hash::make($request->password);
                        $result = $User->save();
                }
                else
                {
                    $this->validate($request,[
                        'name'=> 'required|max:50',
                        'email'=> 'required|max:225|unique:users,email,'.$request->id,
                        'user_type_id' => 'required'
                       ]);      
                                    
                       $User = User::find($request->id);
                       $User->name = $request->name;
                       $User->email = $request->email;
                       $User->user_type_id = $request->user_type_id; 
                       $result = $User->save();
                }
            
                    if($result)
                            return "Success";
                    else
                            return "Fail";
                
           } catch (Exception $th) {
                return $th;
           }
    }

    public function deleteUser($id)
    {
        try {            
                         
            $user = User::findOrFail($id); 
            $result = $user->delete();
    
            if($result)
                    return "Success";
            else
                    return "Fail";
    
           } catch (Exception $th) {
                return $th;
           }
    }

}
