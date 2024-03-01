<?php

namespace App\Http\Controllers\backend\company;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Validation\ValidationException;






class UserBackendController extends Controller
{


/*     public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('credentials: Content-Type, true');
   
   
} */

    public function getCart(Request $request){
        // Authenticate the user using Sanctum
       /*  $user = Auth::guard('sanctum')->user(); */
        // Check if the authenticated user matches the requested user ID
       /*  if ($user && $user->id == $request->id) { */
            $userCart = Cart::getCartInfo($request->id);

            if ($userCart !== false) {
                return response()->json([
                    'status' => 200,
                    'message' => 'current user cart',
                    'data' => $userCart,
                ], 200);
           /*  } */
        }

        // If authentication fails or cart retrieval fails, return an error response
        return response()->json([
            'status' => 401, // Unauthorized
            'message' => 'Unauthorized or cart not found',
        ], 401);
    }

    // Other routes and methods...



    public function createCart(Request $request)
    {
        
        try {
            // Validate incoming JSON data
            $validatedData = $request->validate([
                'products_details' => 'required',
                'user_id' => 'required|integer',
                'price' => 'required|numeric',
                'product_count' => 'required|integer',
                'status' => 'required|in:new,progress,delivered,cancel',
                'ord_expected_date' => 'nullable',
                'order_note' => 'nullable|string',
                'address' => 'nullable|array',
                'quantity' => 'required|integer',
                'amount' => 'required|numeric',
                'cart_completed' => 'required|boolean',
            ]);
            $Cart = Cart::where('cart_id', request('cart_id'))->first();
            if ($Cart !== null) {
                $cartUpdated = $Cart->update(['products_details' =>request('products_details'),
                'user_id' => request('user_id'),
                'product_count' => request('product_count'),
                'status' => request('status'),
                'ord_expected_date' => request('ord_expected_date'),
                'order_note' => request('order_note'),
                'address' =>json_encode(request('address')),
                'quantity' => request('quantity'),
                'amount' => request('amount'),
                'cart_completed' => request('cart_completed'),
             ]);
                return response()->json([
                    'status'=>201,
                    'messaage'=>"cart updated successfuly",
                    'data'=>$cartUpdated
                ],201);
            }else {
                $cartDetails = request('products_details');
                $Cart = Cart::create(['products_details' => json_encode($cartDetails),
                'cart_id'=>Auth::id().strtotime(date('Y-m-d H:i:s')),
                'user_id' =>request('user_id'),
                'price'=>request('price'),
                'product_count' =>request('product_count'),
                'status' =>request('status'), 
                'ord_expected_date' =>request('ord_expected_date'),
                'order_note' => request('order_note'),
                'address' =>json_encode(request('address')),
                'quantity' =>request('quantity'),
                'amount' =>request('amount'),
                'cart_completed' =>request('cart_completed'),
                ]);
                return response()->json([
                    'status'=>201,
                    'messaage'=>"cart created  successfuly",
                    'data'=>$Cart
                ],201);

            }
        } catch (ValidationException $exception) {
            // Return validation errors as part of the response
            return response()->json([
                "status"=>422,
                'message'=>"Something went wrong",
                'data'=>[
                    'errors' => $exception->errors()

            ]], 422);
        }
    }

    public function createCartAddress( Request $request){
       
      try{
         // Validate incoming JSON data
                $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'address' => 'required|array',
                'address.single_address' => 'required|string',
                'address.first_name' => 'required|string',
                'address.last_name' => 'required|string',
                'address.phone_number' => 'required|int',
                'address.email' => 'required|email',
                'address.address' => 'required|string',
                'address.appartment' => 'required|string',
                'address.street' => 'required|string',
                'address.city' => 'required|string',
                'address.state' => 'required|string',
                'address.postal_code' => 'required|string',
                'address.country' => 'required|string',
            ]);
            $cart = Cart::where('user_id', request('user_id'))
            ->where('cart_completed', "0")
            ->first();
            if($cart){
            $addressUpdated = $cart->update(['address' => json_encode(request('address'))]);
              if($addressUpdated){
                return response()->json([
                    "status"=>201,
                    'message'=>"Address updated successfully",
                    'data'=>$cart
                    ],201);

              }else{
                return response()->json([
                    "status"=>219,
                    'message'=>"something went wrong"
                    ],219);

              }

            }else{
                return response()->json([
                    "status"=>219,
                    'message'=>"No cart id found for the user  "
                    ],219);
            }

        }catch(ValidationException $exception) {
            // Return validation errors as part of the response
            return response()->json([
                "status"=>422,
                'message'=>"Something went wrong",
                'data'=>[
                    'errors' => $exception->errors()

            ]], 422);
        }
    }

    public function createOrder(Request $request){
    }

    public function getAddress(Request $request ){

    }

    public function createBulkestimate(Request $request){

        //$response->header('Access-Control-Allow-Origin', '*');
        //$response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
       // $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
          $re = $request->all();

          print_r($re);
     
    }

}



