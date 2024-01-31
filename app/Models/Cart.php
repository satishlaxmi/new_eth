<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    protected $fillable=['user_id','product_id','order_id','quantity','amount','price','status','ord_expected_date','order_note','additional_services'	];
    
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
        $cartInfo = [];
        $productData=[];
        foreach ($userCart as $cartItem) {
            $product_id = $cartItem->product_id;
            $productData[] = self::product($product_id); // Use self:: to refer to the static metho  
        }
        return  $cartInfo = [
            'cartId'=>$cartItem->card_id,
            'items'=>$productData
        ];
    }
    
    
    
}
