<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class TestingController extends Controller
{
    public function gettestController(Request $request){
        $name = test("satish");
        echo $name;
        
    }
}
