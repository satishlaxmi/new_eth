<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    protected $fillable=['user_id','product_id','order_id','quantity','products_details','amount','price','status','ord_expected_date','order_note','additional_services','cart_id','address'	];
    
    // public function product(){
    //     return $this->hasOne('App\Models\Product','id','product_id');
    // }
    public static function getAllProductFromCart(){
        return Cart::with('allproducts')->where('user_id',auth()->user()->id)->get();
    }




    public static function product($product_id)
    {
        $data = DB::table('allproducts')->where('id', $product_id)->first();
        return $data;
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
    public static function getCartInfo($userId)
    {
        $userCart = Cart::where('user_id', $userId)->where('cart_completed', '0')->get();
         if(!empty($userCart)){
            return  $userCart; 
        }else{
             return  $userCart; 
        }
        
    }

    public static function saveCartData($car_data){
        $shipment = new Cart();
        
        
    } 
    
    
    
}
