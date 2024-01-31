<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Validator;

class RolPerUsersController extends Controller
{
    public function addRole(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'rol' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
        $user= User::find($request->id);
        if(!$user){
            return response()->json([
                'error'=>"No user found with this id"
            ],404);
        }else{
            $user->assignRole($request->rol);
            return   response()->json([
                'message'=>"Added the role"
            ],201);
        }
       
        
    } 
    
     public function addPermession(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'per' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
        $user= User::find($request->id);
        if(!$user){
            return response()->json([
                'error'=>"No user found with this id"
            ],404);
        }else{
            $user->assignRole($request->rol);
            return   response()->json([
                'message'=>"Added the role"
            ],201);
        }
        

    }

   
   

}

