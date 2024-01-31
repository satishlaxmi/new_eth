<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllProduct;
use Notification;
use App\Notifications\StatusNotification;
use App\User;
use App\Models\ProductReview;


class ProductReviewController extends Controller
{

   public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: *');



    
}
   public function getProductBasedReview(Request $request){
    

   } 
}
