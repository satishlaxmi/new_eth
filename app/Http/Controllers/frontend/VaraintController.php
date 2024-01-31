<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\AllCatogery;
use App\Models\Varaiant;


class VaraintController extends Controller
{


        
/**********************************************************************************************************************
                                        *************AIR TABLE API***************** 
***************************************************************/
    public function getAllVaraintFromAirTabel(){
        $client = new Client([
            'base_uri' => 'https://api.airtable.com/',
            'timeout' => 10,
            'verify' => false, // Disable SSL verification (not recommended in production)
        ]);
        
        $headers = [
            'Authorization' => 'Bearer patpWQxZRSrleolVd.c5ee9f3cc1a11f09fe08d064eaa20852729de5c4e1128548c994239f7b761557',
            'Content-Type' => 'application/json', // Add this line if needed
            'verify' => false,
        ];
        $response = $client->request('GET', 'https://api.airtable.com/v0/appBHen7nPeomNzbR/tbl1F73NpfSG8H4Tn', [
            'headers' => $headers,
        ]);
        /*     ?offset=itr6BXMZ5VdqlktbL/rec0IvreJTTDdI0rA */
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

    public function saveAllVaraintFromAirTabel(Request $request){
        $data = $this->getAllVaraintFromAirTabel();
        if($data){
            $i =0;
            foreach($data as $da){
                $fields = $da->fields;
                $i++;
                if($i==10){
                    break;
                }
                if(!$da->id){
                    echo $da->id ;
                    continue;
                }
               
                  $existingProduct = Varaiant::where('air_id_varaint', $da->id)->first();
                    if(!$existingProduct){
                        $catogeryAll = new Varaiant([
                            'air_id_varaint'=> $da->id,
                            'product_id'=>isset($fields->{'product_id'}) ? $fields->{'product_id'} : NULL,
                            'variant_label'=>isset($fields->{'variant_label'}) ? $fields->{'variant_label'} : NULL,
                            'parent_product'=>isset($fields->{'parent_product'}) ? $fields->{'parent_product'} : NULL,
                            'decoration_type'=>isset($fields->{'decoration_type'}) ? $fields->{'decoration_type'} : NULL,
                            'color'=>isset($fields->{'color'}) ? $fields->{'color'} : NULL,
                            'supp_inv_status'=>isset($fields->{'supp_inv_status'}) ? $fields->{'supp_inv_status'} : NULL,
                            'back_until'=>isset($fields->{'back_until'}) ? $fields->{'back_until'} : NULL,
                            'im_ca'=>isset($fields->{'im_ca'}) ? $fields->{'im_ca'} : NULL,
                            'link_im_ca'=>isset($fields->{'link_im_ca'}) ? $fields->{'link_im_ca'} : NULL,
                            'im_us'=>isset($fields->{'im_us'}) ? $fields->{'im_us'} : NULL,
                            'link_im_us'=>isset($fields->{'link_im_us'}) ? $fields->{'link_im_us'} : NULL,
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
    public function showAllVaraintFromAirTabel(Request $request){
        return $this->getAllVaraintFromAirTabel(    );
    }
}
