<?php

namespace App\Http\Controllers\airtabel;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CollectionairtabelController extends Controller
{
    public function saveCollection(Request $request)
    {
        $dataOffset = null;
    
        do {
            $data = $this->getAllCollectionAirTabel($dataOffset);

                $dataR = $data['dataR'];
                $dataOffset = $data['dataOffset'];
                //$dataR = $data['dataOffset'];
                $url = str_replace('/', '%', $dataOffset);
                if ($dataR) {
                    foreach ($dataR as $data) {
                        if (!$data->id) {
                            continue;
                        }
                        $fields = $data->fields;
                        $existingProduct = Collection::where('airtabel_id', $data->id)->first();
                        if (!$existingProduct) {
                            $colour = new Collection([
                                'airtabel_id' => $data->id,
                                'product_type' => isset($fields->{'Product Types'}) ? json_encode($fields->{'Product Types'}) : null,
                                'parent_products' => isset($fields->{'Parent Products'}) ? json_encode($fields->{'Parent Products'}) : null,
                                'catogery' => isset($fields->{'Category'}) ? json_encode($fields->{'Category'}) : null,
                                'level_3_collection' => isset($fields->{'Level 3 Collections'}) ?  json_encode($fields->{'Level 3 Collections'}) : null,
                                'product_type_2' => isset($fields->{'Product Types 2'}) ? json_encode($fields->{'Product Types 2'}) : null,
                                'products' => isset($fields->{'Products'}) ? json_encode($fields->{'Products'}) : null,
                                'women_owned' => isset($fields->{'# Women Owned'}) ? $fields->{'# Women Owned'} : null,
                                'unionized' => isset($fields->{'# Unionized'}) ? $fields->{'# Unionized'} : null,
                                'social_causes' => isset($fields->{'# Social Causes'}) ? $fields->{'# Social Causes'} : null,
                                'biopic_own' => isset($fields->{'# BIPOC Owned'}) ? $fields->{'# BIPOC Owned'} : null,
                                'indigenous_owned' => isset($fields->{'# Indigenous Owned'}) ? $fields->{'# Indigenous Owned'} : null,
                                'refugee_owned' => isset($fields->{'# Refugee Owned'}) ? $fields->{'# Refugee Owned'} : null,
                                'b_corp' => isset($fields->{'# B Corp'}) ? $fields->{'# B Corp'} : null,
                                'environmental_causes' => isset($fields->{'# Environmental Causes'}) ? $fields->{'# Environmental Causes'} : null,
                                'organic' => isset($fields->{'# Organic'}) ? $fields->{'# Organic'} : null,
                                'biodegradable' => isset($fields->{'# Biodegradable'}) ? $fields->{'# Biodegradable'} : null,
                                'vegan' => isset($fields->{'# Vegan'}) ? $fields->{'# Vegan'} : null,
                                'made_can' => isset($fields->{'# Made In Canada'}) ? $fields->{'# Made In Canada'} : null,
                                'made_usa' => isset($fields->{'# Made In USA'}) ? $fields->{'# Made In USA'} : null,
                                'recycled' => isset($fields->{'# Recycled'}) ? $fields->{'# Recycled'} : null,
                                'LGBTQ2+_owned' => isset($fields->{'# LGBTQ2+ Owned'}) ? $fields->{'# LGBTQ2+ Owned'} : null,
                                'good' => isset($fields->{'# Good'}) ? $fields->{'# Good'} : null,
                                'better' => isset($fields->{'# Better'}) ? $fields->{'# Better'} : null,
                                'best' => isset($fields->{'# Best'}) ? $fields->{'# Best'} : null,
                            ]);
                            $colour->save();
                        }
                    }
                    // Fetch the next set of data
                    
                } else {
                    return response()->json([
                        "message" => "No data found",
                    ]);
                } 
            
        } while ($dataOffset);
    
        return response()->json([
            "message" => "All data saved",
        ]);
    }
    

    public function getAllCollectionAirTabel($dataOffset)
    {

        if ($dataOffset == false) {
            $url = "https://api.airtable.com/v0/appaJeb7oGFi77qdJ/tblG9SrSBihP3NJv7";
        } else {
            $offset = str_replace('/', '%', $dataOffset);
            $url = "https://api.airtable.com/v0/appaJeb7oGFi77qdJ/tblG9SrSBihP3NJv7?offset={$offset}";
        }
        $client = new Client([
            'verify' => false,
        ]);
        $headers = [
            'Authorization' => 'Bearer pata6PNKEZtq6KsTy.fc9a71653241f9f01e149238b32243ccf7025f2f88331573c113773181a7cc94',
            'Content-Type' => 'application/json', // Add this line if needed
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
                'dataOffset' => $dataOffse
            ];
        } else {
            return response()->json([
                'message' => "Something went wrong",
            ], 500);
        }

    }

}
