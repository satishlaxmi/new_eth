<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Emoji;

class EmojiController extends Controller
{
    public function saveAllEmoji(Request $request){
        $data = $this->getAllEmojiAir();
        if($data){
            foreach($data as $da){
                $fields = $da->fields;
                if(!$da->id){
                    echo $da->id ;
                    continue;
                }
                $existingProduct = Emoji::where('id-emoji-air', $da->id)->first();
                 if(!$existingProduct){
                        $catogeryAll = new Emoji([
                            'id-emoji-air' => $da->id,
                            'Emoji_Rating' => isset($fields->{'Emoji Rating'}) ? $fields->{'Emoji Rating'} : NULL,
                            'Caption' => isset($fields->Caption) ? $fields->Caption : NULL,
                            'Collection' => isset($fields->Collection) ? $fields->Collection : NULL,
                            'Notes' => isset($fields->Notes) ? $fields->Notes : NULL,
                            'SDGs' => isset($fields->SDGs) ? $fields->SDGs : NULL,
                            'SDG_from_SDGs' => isset($fields->{'SDG (from SDGs)'}) ? $fields->{'SDG (from SDGs)'} : NULL,
                            'ESG' => isset($fields->ESG) ? $fields->ESG : NULL,
                            'ESG_Impact' => isset($fields->{'ESG Impact'}) ? $fields->{'ESG Impact'} : NULL,
                            'Products' => isset($fields->Products) ? $fields->Products : NULL,
                            'Count_Active_Products_CA_US' => isset($fields->{'Count Active Products (CA & US)'}) ? $fields->{'Count Active Products (CA & US)'} : NULL,
                            'Count_Active_Products_CA' => isset($fields->{'Count Active Products (CA)'}) ? $fields->{'Count Active Products (CA)'} : NULL,
                            'Goal_Count_Active_Products_On_CA_Website' => NULL,  // Fill in the appropriate value if available
                            'Count_Active_Products_US' => isset($fields->{'Count Active Products (US)'}) ? $fields->{'Count Active Products (US)'} : NULL,
                            'Goal_Count_Active_Products_On_US_Website' => NULL,  // Fill in the appropriate value if available
                            'Count_Deficit_Active_Products_CA' => isset($fields->{'Count Deficit Active Products (CA)'}) ? $fields->{'Count Deficit Active Products (CA)'} : NULL,
                            'Count_Deficit_Active_Products_US' => isset($fields->{'Count Deficit Active Products (US)'}) ? $fields->{'Count Deficit Active Products (US)'} : NULL,
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
            'Authorization' => 'Bearer patpWQxZRSrleolVd.c5ee9f3cc1a11f09fe08d064eaa20852729de5c4e1128548c994239f7b761557',
            'Content-Type' => 'application/json', // Add this line if needed
        ];
        $response = $client->request('GET', 'https://api.airtable.com/v0/appBHen7nPeomNzbR/tblWVuIJLhKwjn8Y6', [
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
