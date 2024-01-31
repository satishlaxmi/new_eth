<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\MOdels\AllProduct;

/* class AdminproductController extends Controller
{
    public function getProductCount(Request $request ){
        $productCout = AllProduct::Count();
        return $productCout
    }

    public function getRecentAddedProduct(Request $request ){
        $productCout = AllProduct::orderBy('created_at', 'desc')->page(10);
    }
} */
