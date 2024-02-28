<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config; // Use the correct case for Config

class TestingController extends Controller
{
    public $AIR_TABLE_KEY;
    public $AIR_TABLE_BASE;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');

        $this->AIR_TABLE_KEY = Config::get('myconfig.airtabel.airtabel_emoji');
    }

    public function gettestController(Request $request)
    {
        $name = test("satish");
        echo $this->AIR_TABLE_KEY; // Correct usage of $this->AIR_TABLE_KEY

        $data = DB::table('testallproducts')->get();
        return  $data ;

    }
}
