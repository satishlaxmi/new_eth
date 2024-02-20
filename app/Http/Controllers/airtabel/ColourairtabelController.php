<?php

namespace App\Http\Controllers\airtabel;

use App\Http\Controllers\Controller;
use App\Models\Colour;
use Config;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ColourairtabelController extends Controller
{
    public $AIR_TABLE_KEY;
    public $AIR_TABLE_BASE;
    public $AIR_TABLE_COLOUR;

    public function __construct()
    {
        $this->AIR_TABLE_KEY = Config::get('myconfig.airtabel.airtabel_key');
        $this->AIR_TABLE_BASE = Config::get('myconfig.airtabel.airtabel_base');
        $this->AIR_TABLE_COLOUR = Config::get('myconfig.airtabel.airtabel_color');
    }

    public function saveColours(Request $request)
    {
        $dataOffset = null;
        $data = $this->getColoursAir( $dataOffset);
        $dataOffset = $data['dataOffset'];
        while ($dataOffset) {
            // Access the data directly without wrapping it in a response
            $dataR = $data['dataR'];
            $url = str_replace('/', '%', $dataOffset);
            if ($dataR) {
                foreach ($dataR as $da) {
                    if (!$da->id) {
                        echo $da->id;
                        continue;
                    }
                    $fields = $da->fields;
                    $existingProduct = Colour::where('airtabel_id', $da->id)->first();
                    if (!$existingProduct) {
                        $catogeryAll = new Colour([
                            'airtabel_id' => $da->id,
                            'colour_categories' => isset($fields->{'Colour Categories (Remove Duplicates From This Column)'}) ? $fields->{'Colour Categories (Remove Duplicates From This Column)'} : null,
                            'color_swatch' => isset($fields->{'Color Swatch'}) ? json_encode($fields->{'Color Swatch'}) : null,
                            'color_swatch_id' => isset($fields->{'Color Swatch'}[0]->id) ? $fields->{'Color Swatch'}[0]->id : null,
                            'image' => isset($fields->{'Color Swatch'}[0]->url) ? $fields->{'Color Swatch'}[0]->url : null,
                            'parent_products' => isset($fields->{'Parent Products'}) ? json_encode($fields->{'Parent Products'}) : null,
                        ]);
                        $catogeryAll->save();
                    }
                }
    
                // Fetch the next set of data
                $data = $this->getColoursAir($dataOffset);
                $dataOffset = $data['dataOffset'];
            } else {
                return response()->json([
                    "message" => "No data found",
                ]);
            }
        }
    
        return response()->json([
            "message" => "All data saved",
        ]);
    }
    

    public function getColoursAir($dataOffset)
    {
         if ($dataOffset == false) {
             $url = "https://api.airtable.com/v0/{$this->AIR_TABLE_BASE}/{$this->AIR_TABLE_COLOUR}";
         } else {
             $offset = str_replace('/', '%', $dataOffset);
             $url = "https://api.airtable.com/v0/{$this->AIR_TABLE_BASE}/{$this->AIR_TABLE_COLOUR}?offset={$offset}";
         }
    
         $client = new Client();
         $headers = [
             'Authorization' => 'Bearer ' . $this->AIR_TABLE_KEY,
            'Content-Type' => 'application/json',
        ];
        $response = $client->request('GET', $url, [
             'headers' => $headers,
        ]);
        $dataAll = json_decode($response->getBody()->getContents()); // Decode the JSON content
         $dataR = $dataAll->records;
         $dataOffset = !empty($dataAll->offset) ? $dataAll->offset : null;
         if ($dataR) {
             return [
                 'dataR' => $dataR,
                 'dataOffset' => $dataOffset,
             ];
         } else {
             return response()->json([
                 'message' => "Something went wrong",
            ], 500);
        }

    } 

}
