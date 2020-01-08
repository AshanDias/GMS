<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
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
        
       $this->validate($request,[
        'name'=> 'required|max:50',
        'email'=> 'required|max:225|unique:users',
        'user_type'=>'required',
        'password'=>'required|min:8'
       ]);
       try {
           
        $result = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type'=>$request->user_type,
            'password' => Hash::make($request->password),
        ]);

        if($result)
                return "Success";
        else
                return "Fail";

       } catch (Exception $th) {
            return $th;
       }
    }

    public function populateUsers($count)
    {
        return User::paginate($count);
    }

    public function updateUser(Request $request)
    {
        try {    
                if($request->password != '')
                {
                    $this->validate($request,[
                        'name'=> 'required|max:50',
                        'user_type'=>'required',
                        'password'=>'required|min:8'
                    ]);
                            
                                    
                        $user = User::find($request->id);
                        $user->name =  $request->name;
                        $user->user_type = $request->user_type;
                        $user->password = Hash::make($request->password);
                        $result = $user->save();
                }
                else
                {
                    $this->validate($request,[
                        'name'=> 'required|max:50',
                        'user_type'=>'required', 
                    ]);       
                                    
                        $user = User::find($request->id);
                        $user->name =  $request->name;
                        $user->user_type = $request->user_type;                        
                        $result = $user->save();
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
