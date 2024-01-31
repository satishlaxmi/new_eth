<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\AllCatogery;

class AllCatogeryController extends Controller
{
   

   

   

    public function showallCatogery(Request $request){
        $data = AllCatogery::paginate(10);
        if($data){
            return response()->json([
                "messgae"=>"All data of catogery",
                'data'=>$data
            ],200);
        }else{
            return response()->json([
                "error"=>"No data found "
            ],404);
        }
    }

/**********************************************************************************************************************
                                        *************AIR TABLE API***************** 
*********************************************************************************************************************/
      
public  function getAllcatogeryAir(){
    $client = new Client([
        'verify' => false
    ]);
    $headers = [
        'Authorization' => 'Bearer patpWQxZRSrleolVd.c5ee9f3cc1a11f09fe08d064eaa20852729de5c4e1128548c994239f7b761557',
        'Content-Type' => 'application/json',
         // Add this line if needed
    ];
    $response = $client->request('GET', 'https://api.airtable.com/v0/appBHen7nPeomNzbR/tbl5MJ7nJ3fmUVCYB', [
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

public function showAllCatogeryAirTabel(Request $request){
    return $this->getAllcatogeryAir();
}
public function saveAllCatogeryModel(Request $request){
    $data = $this->getAllcatogeryAir    ();
    //return $data;
    if($data){
        foreach($data as $da){
            $fields = $da->fields;

            if(!$da->id){
                echo $da->id ;
                continue;
            }
            $existingProduct = AllCatogery::where('catogery_id_air1', $da->id)->first();
             if(!$existingProduct){
                $catogeryAll = new AllCatogery([
                    'catogery_id_air1'=> $da->id,
                    'Level_2_Collection'=>isset($fields->{'Level 2 Collection'}) ? $fields->{'Level 2 Collection'} : NULL,
                    'Level_3_Collection'=>isset($fields->{'Level 3 Collection'}) ? $fields->{'Level 3 Collection'} : NULL,
                ]);
                $catogeryAll->save();
            }
          
        }
        return response()->json([
            "message"=>"data saved"
        ]);
    }else{
        return "no Data found";
    }
     
}


}
