<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\AllProduct;
use App\Models\AllCollection;
use DB;


class AllCollectionController extends Controller
{

    public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: *');



    
}

public function getCollection(Request $request){
    $catogeryNmae = isset($request->cat)?$request->cat:null;
    if(!$catogeryNmae){
        return response()->json([
            "status"=>400,
            "message"=>"send catogery name ",
       ],400);

    }
    $data = AllCollection::getAllCollection($catogeryNmae);
    
        if($data){
            return response()->json([
                "message"=>"This is all products data with all the cooumn",
                "data"=>$data

            ],200);

        }else{
            return response()->json([
                 "message"=>"This is no product in this"
            ],200);

        }

}    

public function showAllCollection(Request $request){
    $data = $this->getAllCollection();
    return $data;
}

public function getCollectionProducts(Request $request,$collection_name){ 
   return  AllCollection::getcollectionproducts($collection_name);

}

/**********************************************************************************************************************
                                        *************AIR TABLE API***************** 
*********************************************************************************************************************/
                         
    
public function saveAllCollectionFromAirTabel(Request $request){
    $dataR = $this->getAllCollectionAirTabel();
    foreach ($dataR as $data) {
        $fields = $data->fields;
       $productType = $fields->{'Product Types'};
        $existingProduct = AllCollection::where('id_allcollection_airtable', $data->id)->first();
        if (!$existingProduct) {
            // If the record does not exist, create a new one
            $insertData = [
                'id_allcollection_airtable' => $data->id,
                'createdTime' => $data->createdTime,
                'Product Types' => isset($fields->{'Product Types'}) ? $fields->{'Product Types'} : null,
                'Created' => isset($fields->{'Created'}) ? $fields->{'Created'} : null,
                'Level 3 Collection' => isset($fields->{'Level 3 Collection'}) ? $fields->{'Level 3 Collection'} : null,
                'Level 2 Collection' => isset($fields->{'Level 2 Collection'}) ? $fields->{'Level 2 Collection'} : null,
                'All Collection Tags' => isset($fields->{'All Collection Tags'}) ? $fields->{'All Collection Tags'} : null,
                'Part 1: Parent Products' => isset($fields->{'Part 1: Parent Products'}) ? $fields->{'Part 1: Parent Products'} : null,
                'Count (ALL Active Products)' => isset($fields->{'Count (ALL Active Products)'}) ? $fields->{'Count (ALL Active Products)'} : null,
                'Count (Active Products in CA)' => isset($fields->{'Count (Active Products in CA)'}) ? $fields->{'Count (Active Products in CA)'} : null,
                'Goal Count Active Products On CA Website' => isset($fields->{'Goal Count Active Products On CA Website'}) ? $fields->{'Goal Count Active Products On CA Website'} : null,
                'Active Product Deficit CA' => isset($fields->{'Active Product Deficit CA'}) ? $fields->{'Active Product Deficit CA'} : null,
                'Active Product Surplus CA' => isset($fields->{'Active Product Surplus CA'}) ? $fields->{'Active Product Surplus CA'} : null,
                'Active Product Surplus US' => isset($fields->{'Active Product Surplus US'}) ? $fields->{'Active Product Surplus US'} : null,
                'Count (Active Products in US)' => isset($fields->{'Count (Active Products in US)'}) ? $fields->{'Count (Active Products in US)'} : null,
                'Goal Count Active Products On US Website' => isset($fields->{'Goal Count Active Products On US Website'}) ? $fields->{'Goal Count Active Products On US Website'} : null,
                'Active Product Deficit US' => isset($fields->{'Active Product Deficit US'}) ? $fields->{'Active Product Deficit US'} : null,
                '# Women Owned' => isset($fields->{'# Women Owned'}) ? $fields->{'# Women Owned'} : null,
                '# Unionized' => isset($fields->{'# Unionized'}) ? $fields->{'# Unionized'} : null,
                '# Social Causes' => isset($fields->{'# Social Causes'}) ? $fields->{'# Social Causes'} : null,
                '# BIPOC Owned' => isset($fields->{'# BIPOC Owned'}) ? $fields->{'# BIPOC Owned'} : null,
                '# Indigenous Owned' => isset($fields->{'# Indigenous Owned'}) ? $fields->{'# Indigenous Owned'} : null,
                '# Refugee Owned' => isset($fields->{'# Refugee Owned'}) ? $fields->{'# Refugee Owned'} : null,
                '# B Corp' => isset($fields->{'# B Corp'}) ? $fields->{'# B Corp'} : null,
                '# Environmental Causes' => isset($fields->{'# Environmental Causes'}) ? $fields->{'# Environmental Causes'} : null,
                '# Organic' => isset($fields->{'# Organic'}) ? $fields->{'# Organic'} : null,
                '# Biodegradable' => isset($fields->{'# Biodegradable'}) ? $fields->{'# Biodegradable'} : null,
                '# Vegan' => isset($fields->{'# Vegan'}) ? $fields->{'# Vegan'} : null,
                '# Made In Canada' => isset($fields->{'# Made In Canada'}) ? $fields->{'# Made In Canada'} : null,
                '# Made In USA' => isset($fields->{'# Made In USA'}) ? $fields->{'# Made In USA'} : null,
                '# Recycled' => isset($fields->{'# Recycled'}) ? $fields->{'# Recycled'} : null,
                '# LGBTQ2+ Owned' => isset($fields->{'# LGBTQ2+ Owned'}) ? $fields->{'# LGBTQ2+ Owned'} : null,
                '# Good' => isset($fields->{'# Good'}) ? $fields->{'# Good'} : null,
                '# Better' => isset($fields->{'# Better'}) ? $fields->{'# Better'} : null,
                '# Best' => isset($fields->{'# Best'}) ? $fields->{'# Best'} : null,
            ];
            $dataSaved = AllCollection::create($insertData);
          
        }else{
            return response()->json([
                'message'=>"NO data found"
            ]);
        }
        
    }

    return 'Data saved successfully.';
}

public function getAllCollectionAirTabel(){
    $client = new Client([
        'verify'=>false
    ]);
    $headers = [
        'Authorization' => 'Bearer patpWQxZRSrleolVd.c5ee9f3cc1a11f09fe08d064eaa20852729de5c4e1128548c994239f7b761557',
        'Content-Type' => 'application/json', // Add this line if needed
    ];
    $response = $client->request('GET', 'https://api.airtable.com/v0/appBHen7nPeomNzbR/tblmvVFNcljh8eaVU', [
        'headers' => $headers,
    ]);
    $dataAll = json_decode($response->getBody()->getContents()); // Decode the JSON content
    $dataR = $dataAll->records;
    if($dataR){
        return $dataR;
    }else{
        return response()->json([
            'message'=>"Something went wrong"
        ],500);
    }

}

public function showAllCollectionAirTabel(Request $request){
    return $this->getAllCollectionAirTabel();
    
}

}





