<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendCodeResetPassword;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App\Models\User;
use Validator;
use Carbon\Carbon; 
use Mail; 
use Hash;
use DB;

class AuthController extends Controller
{
    /**
    * Create user
    *
    * @param  [string] name
    * @param  [string] email
    * @param  [string] password
    * @param  [string] password_confirmation
    * @return [string] message
    */
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');  
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>422,
                'messgae'=>"something went wrong",
                'error' => $validator->errors()], 422); 
        }
        $user = User::create(request(['name', 'email', 'password']));
        if($user){
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            $rol = $user->assignRole('company');
            return response()->json([
            'status'=>201,
            'message' => 'Successfully created user!',
              'data'=>[
                'accessToken'=> $token,
                'role'=> [
                    "company"
                ],
              ] 
            
            ],201);
        }
        else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            /* 'remember_me' => 'boolean', */   
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
        return response()->json([
            'status'=>401,
            'message' => 'Either email or password not matched',
            'status'=>401
        ],401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        $roles = $user->getRoleNames();

        return response()->json([
            'status'=>200,
            'data'=>[ 'accessToken' =>'Bearer'." ".$token,
            'role'=>$roles,
            'id'=>$user->id
            
            ]
        ]);
    }

    public function user(Request $request){
      return response()->json($request->user());
    }

    public function logout(Request $request)
    {
    
        $request->user()->tokens()->delete();
        return response()->json([
        'status'=> 200,
        'message' => 'Successfully logged out'
        ],200);
    
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'  
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

       // $token = Str::random(64);
        $token = mt_rand(100000, 999999);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

          Mail::to($request->email)->send(new SendCodeResetPassword($token));
          return response(['message' => trans('passwords.sent')], 200);

    }

    public function emailPasswordCheck(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|exists:password_reset_tokens' 
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validator->errors()], 422); 
            
        }
        // find the code
        $passwordReset =  DB::table('password_reset_tokens')->firstWhere('code', $request->token);
        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 422);
        }
        return response([
            'token' => $passwordReset->token,
            'message' => trans('passwords.code_is_valid')
        ], 200);
    }
    public function eamilResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:password_reset_tokens',
            'password' => 'required|string|min:6|confirmed',
            
        ]);    
       if( $validator->fails()){
        return response()->json(['error' => $validator->errors()], 422); 
       }
        // find the code
        $passwordReset = DB::table('password_reset_tokens')->where('token', $request->token)->first();
       
        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 422);
        }
        // find user's email 
        $user = User::firstWhere('email', $passwordReset->email);
        // update user password
        $user->update($request->only('password'));
        $deletedRows = DB::table('password_reset_tokens')->where('token', $request->token)->delete();
        if ($deletedRows > 0) {
            return response(['message' =>'password has been successfully reset'], 200);
         
        } else {
            // No matching records found
        }        return response(['message' =>'password no has been successfully reset'], 200);
    }

    public function unauthorized(){
        return response()->json([
            "message"=>"Unauthorized"
        ]);
    }
  
}
