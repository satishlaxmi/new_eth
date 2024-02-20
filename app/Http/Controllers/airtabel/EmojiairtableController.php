<?php

namespace App\Http\Controllers\airtable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

use App\Models\Emoji;

use Config; 

class EmojiairtableController extends Controller
{
    public $AIR_TABLE_KEY;
    public $AIR_TABLE_BASE;
    public $AIR_TABLE_EMOJI;

    public function __construct()
    {
        $this->AIR_TABLE_KEY = Config::get('myconfig.airtabel.airtabel_key');
        $this->AIR_TABLE_BASE = Config::get('myconfig.airtabel.airtabel_base');
        $this->AIR_TABLE_EMOJI = Config::get('myconfig.airtabel.airtabel_emoji');
    }
    
    public function saveEmoji(Request $request){
        $data = $this->getAllEmojiAir();
        if($data){
            foreach($data as $da){
                $fields = $da->fields;
                if(!$da->id){
                    echo $da->id ;
                    continue;
                }
                $existingProduct = Emoji::where('airtabel_id', $da->id)->first();
                 if(!$existingProduct){
                    $catogeryAll = new Emoji([
                        'airtabel_id' => $da->id,
                        'emoji_rating' => isset($fields->{'Emoji Rating'}) ? $fields->{'Emoji Rating'} : NULL,
                        'caption' => isset($fields->Caption) ? $fields->Caption : NULL,
                        'collection' => isset($fields->Collection) ? $fields->Collection : NULL,
                        'notes' => isset($fields->Notes) ? $fields->Notes : NULL,
                        'sdgs' => isset($fields->SDGs) ? json_encode($fields->SDGs) : NULL,
                        'sdg_from_sdgs' => isset($fields->{'SDG (from SDGs)'}) ? json_encode($fields->{'SDG (from SDGs)'}) : NULL,
                        'esg' => isset($fields->ESG) ? json_encode($fields->ESG) : NULL,
                        'esg_impact' => isset($fields->{'ESG Impact'}) ? json_encode($fields->{'ESG Impact'}) : NULL,
                        'roducts' => isset($fields->Products) ? $fields->Products : NULL,
                        'count_Active_Products_CA_US' => isset($fields->{'Count Active Products (CA & US)'}) ? $fields->{'Count Active Products (CA & US)'} : NULL,
                        'count_Active_Products_CA' => isset($fields->{'Count Active Products (CA)'}) ? $fields->{'Count Active Products (CA)'} : NULL,
                        'count_Active_Products_US' => isset($fields->{'Count Active Products (US)'}) ? $fields->{'Count Active Products (US)'} : NULL,
                        'parent_products' => isset($fields->{'Parent Products'}) ? json_encode($fields->{'Parent Products'}) : NULL,
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

    public  function getAllEmojiAir(){
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer '.$this->AIR_TABLE_KEY,
            'Content-Type' => 'application/json',
        ];
        $response = $client->request('GET', 'https://api.airtable.com/v0/'.$this->AIR_TABLE_BASE.'/'.$this->AIR_TABLE_EMOJI, [
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


}
