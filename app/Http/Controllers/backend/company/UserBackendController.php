<?php

namespace App\Http\Controllers\backend\company;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;





class UserBackendController extends Controller
{
    public function getCart(Request $request){
        $currentUser = $user = Auth::user();
        $userId =  $currentUser->id;
        $userCart = Cart::getCartInfo($userId);
        return response()->json([
            'status'=>200,
            'message'=>'current user cart',
            'data'=>$userCart
        ],200);
    }

    public function createOrder(Request $request){

    }
}


