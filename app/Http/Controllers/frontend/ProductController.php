<?php

namespace App\Http\Controllers\frontend;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AllProduct;
use DB;
use Config;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{

public $AIR_TABLE_KEY ;
public $AIR_TABLE_BASE ;

public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: *');
    $this->AIR_TABLE_KEY = Config::get('myconfig.airtabel.airtabel_key');
    $this->AIR_TABLE_BASE = Config::get('myconfig.airtabel.airtabel_base');
}
    //This api get the all the products stored in the our database Allproduct  
    public function getTestProduct(Request $request){
        // $data = AllProduct::limit(10)->get();
        $data = AllProduct::select('id', 'image', 'unit_price', 'product_title','colours')->paginate(10);
        
        if ($data->isEmpty()) {
            return response()->json([
                "status" => 204,
                "message" => "There is no product in the table"
            ], 204);
        } else {
            return response()->json([
                "status" => 200,
                "message" => "This is all products data with selected columns",
                "data" => $data
            ], 200);
        }
    }



    public function getProduct(Request $request)
    {
        $query = AllProduct::query();

        $searchParams = [
            'min_price' => '>=',
            'max_price' => '<=',
            'product_type' => '=',
            'colours' => '=',
            'material_made' => '=',
            'customization' => '=',
        ];
        foreach ($searchParams as $param => $operator) {
            if ($request->filled($param)) {
                $query->where($param, $operator, $request->input($param));
            }
        }

        // Paginate the results
        $data = $query->paginate(10);

        if ($data->isEmpty()) {
            return response()->json([
                "status" => 204,
                "message" => "There is no product matching the search criteria",
            ], 204);
        } else {
            return response()->json([
                "status" => 200,
                "message" => "Products matching the search criteria",
                "data" => $data,
            ], 200);
        }
    }


    /*   This Api get information of the single product allong with  the collection ,varaint and catogert attached to it .singleproductModal function here is from the modal Allproduct
  */
    public function getSingleProduct(Request $request,$id)
    {
        $data = AllProduct::singleproductModal($id);
       
       $dimension = $data->original["product_data"]->product_dimensions;
         preg_match_all('/\b(?:S|M|L|XL|2XL)\b/', $dimension, $matches);
         $sizes = $matches[0];
         if ($sizes) {
            $sizeArray = [
                "sizes" => $sizes,
                "other" => null
            ];
        
            $data->original["product_data"]->product_dimensions = $sizeArray;
        } else {
            $sizeArray = [
                "sizes" => null,
                "other" => $data->original["product_data"]->product_dimensions
            ];
        
            $data->original["product_data"]->product_dimensions = $sizeArray;
        }
        
        if($data){
            return response()->json([
                'status'=>200,
                'message'=>"This is the single product inforamtion",
                "data"=>$data->original["product_data"] 
            ],200);
        }else{
            return response()->json([
                'status'=>204,  
                'message'=>"No data for this id",
                "data"=>$data
            ],404);

        }
    }

    public static function  getStarProduct(Request $request)
    {
        $data = AllProduct::starProductModal();
        if($data){
            return response()->json([
                'status'=>200,
                'message'=>"These are  the star product inforamtion",
                "data"=>$data
            ],200);
        }else{
            return response()->json([
                'message'=>"No data for this id",
                "data"=>$data
            ],404);

        }
    }

    public static function  getUsaProduct(Request $request)
    {
        $data = AllProduct::usaProduct();
        if($data){
            return response()->json([
                'status'=>200,
                'message'=>"These are  usa product inforamtion",
                "data"=>$data
            ],200);
        }else{
            return response()->json([
                'message'=>"No data ",
                "data"=>$data
            ],404);

        }
    }
    public static function  getCanProduct(Request $request)
    {
        $data = AllProduct::canProduct();
        if($data){
            return response()->json([
                'status'=>200,
                'message'=>"These are  can product inforamtion",
                "data"=>$data
            ],200);
        }else{
            return response()->json([
                'message'=>"No data ",
                "data"=>$data
            ],404);

        }
    }
    
    public function getRecentProduct(Request $request){
        $productRecent = Allproduct::RecentAddedProduct();
        return response()->json([
            "status"=>"200",
            "message"=>"All recent Product",
            "Data"=>$productRecent
        ]);

    }

    public function filterData(Request $request){
    
    }

    

/**********************************************************************************************************************
                                        *************AIR TABLE API***************** 
*********************************************************************************************************************/
                         
public function getAllproductDataFromAirtable()
{
    $client = new Client([
        'verify'=>false
    ]);
    $headers = [
        'Authorization' => 'Bearer '.$this->AIR_TABLE_KEY,
        'Content-Type' => 'application/json', // Add this line if needed
    ];
    $response = $client->request('GET', 'https://api.airtable.com/v0/'.$this->AIR_TABLE_BASE.'/tblCRXMmn9gWaIban'
    , [
        'headers' => $headers,
    ]);
    $dataAll = json_decode($response->getBody()->getContents()); // Decode the JSON content
    $dataR = $dataAll->records;
    if($dataR){
        return response()->json([
            'message'=>"This is the data from the airtable all products",
            'data'=>$dataR
        ],200);

    }else{
        return response()->json([
            'message'=>"Something went wrong"
        ],500);
    }

}

public function saveAllproductfromAirTable(Request $request)
{
    $client = new Client();
    $headers = [
        'Authorization' => 'Bearer patpWQxZRSrleolVd.c5ee9f3cc1a11f09fe08d064eaa20852729de5c4e1128548c994239f7b761557',
        'Content-Type' => 'application/json', // Add this line if needed
    ];
    $response = $client->request('GET', 'https://api.airtable.com/v0/appBHen7nPeomNzbR/tbl7uEFkgGSy9vkLg', [
        'headers' => $headers,
    ]);
    $dataAll = json_decode($response->getBody()->getContents()); // Decode the JSON content
    $dataR = $dataAll->records;
    foreach($dataR as $data){
        $fields = $data->fields;
        $existingProduct = AllProduct::where('id_products_airtable', $data->id)->first();
        if(!$existingProduct){
            $product = new AllProduct([
                'id_products_airtable' => $data->id,
                'createdTime' => $data->createdTime,
                'column_5_letter' => isset($fields->{'Column 5 - Letter'}) ? $fields->{'Column 5 - Letter'} : null,
                'shopify_variant_image_matching_status' => isset($fields->{'Shopify Variant Image Matching Status'}) ? $fields->{'Shopify Variant Image Matching Status'} : null,
                'supplier_product_url_usa' => isset($fields->{'Supplier Product URL USA'}) ? $fields->{'Supplier Product URL USA'} : null,
                'material_made' => isset($fields->{'Material Made (for Shopify tagging)'}) ? $fields->{'Material Made (for Shopify tagging)'} : null,
                'product_status_on_shopify_store_us' => isset($fields->{'Product Status On Shopify Store US'}) ? $fields->{'Product Status On Shopify Store US'} : null,
                'part_3_variants' => isset($fields->{'Part 3: Variants'}) ? $fields->{'Part 3: Variants'} : null,
                'pricing_last_verified_on_date' => isset($fields->{'Pricing Last Verified On Date'}) ? $fields->{'Pricing Last Verified On Date'} : null,
                'link_to_images_ca' => isset($fields->{'Link To Images CA'}) ? $fields->{'Link To Images CA'} : null,
                'supplier' => isset($fields->{'Supplier'}) ? $fields->{'Supplier'} : null,
                'shopify_id_us' => isset($fields->{'∞ Shopify Id US'}) ? $fields->{'∞ Shopify Id US'} : null,
                'column_3_retail_price_cad' => isset($fields->{'Column 3 - Retail Price CAD (M)'}) ? $fields->{'Column 3 - Retail Price CAD (M)'} : null,
                'column_3_qty' => isset($fields->{'Column 3 - QTY'}) ? $fields->{'Column 3 - QTY'} : null,
                'does_supplier_decorate_in_house' => isset($fields->{'Does Supplier Decorate In House'}) ? $fields->{'Does Supplier Decorate In House'}[0] == 'Yes' : null,
                'column_5_retail_price_usd' => isset($fields->{'Column 5 - Retail Price USD (M)'}) ? $fields->{'Column 5 - Retail Price USD (M)'} : null,
                'samples' => isset($fields->{'Samples'}) ? $fields->{'Samples'} : null,
                'available_in_usa' => isset($fields->{'Available In USA'}) ? $fields->{'Available In USA'} == true : null,
                'freight_estimates' => isset($fields->{'Freight Estimates'}) ? $fields->{'Freight Estimates'} : null,
                'option1_name' => isset($fields->{'Option1 Name'}) ? $fields->{'Option1 Name'} : null,
                'moq_source' => isset($fields->{'MOQ Source'}) ? $fields->{'MOQ Source'} : null,
                'supplier_product_url_cad' => isset($fields->{'Supplier Product URL CAD'}) ? $fields->{'Supplier Product URL CAD'} : null,
                'create_sample_variants' => isset($fields->{'Create Sample Variants'}) ? $fields->{'Create Sample Variants'} : null,
                'prompt_to_sync_data_to_shopify_us' => isset($fields->{'Prompt To Sync Data To Shopify US'}) ? $fields->{'Prompt To Sync Data To Shopify US'} : null,
                'emoji_ratings' => isset($fields->{'Emoji Ratings'}) ? $fields->{'Emoji Ratings'} : null,
                'product_title' => isset($fields->{'Product Title'}) ? $fields->{'Product Title'} : null,
                'supplier_fees_not_visible' => isset($fields->{'Supplier Fees (Not Visible On Shopify Store & Not Included In Script)'}) ? $fields->{'Supplier Fees (Not Visible On Shopify Store & Not Included In Script)'} : null,
                'colours' => isset($fields->{'Colours'}) ? $fields->{'Colours'} : null,
                'link_to_images_us' => isset($fields->{'Link To Images US'}) ? $fields->{'Link To Images US'} : null,
                'compliance_status' => isset($fields->{'Compliance Status'}) ? $fields->{'Compliance Status'} : null,
                'column_3_retail_price_usd' => isset($fields->{'Column 3 - Retail Price USD (M)'}) ? $fields->{'Column 3 - Retail Price USD (M)'} : null,
                'colors_option_1_variants' => isset($fields->{'Colors (Option 1 Variants)'}) ? $fields->{'Colors (Option 1 Variants)'} : null,
                'espc' => isset($fields->{'ESPC (Ethical Swag Product Code) ES Item # - ES SKU- DO NOT CHANGE'}) ? $fields->{'ESPC (Ethical Swag Product Code) ES Item # - ES SKU- DO NOT CHANGE'} : null,
                'final_count_part_3_variants' => isset($fields->{'Final Count (Part 3: Variants)'}) ? $fields->{'Final Count (Part 3: Variants)'} : null,
                'column_2_qty' => isset($fields->{'Column 2 - QTY'}) ? $fields->{'Column 2 - QTY'} : null,
                'ltm_available' => isset($fields->{'LTM Available'}) ? $fields->{'LTM Available'} == true : null,
                'column_3_letter' => isset($fields->{'Column 3 - Letter'}) ? $fields->{'Column 3 - Letter'} : null,
                'supplier_sku_ca' => isset($fields->{'Supplier SKU CA'}) ? $fields->{'Supplier SKU CA'} : null,
                'images_ca' => isset($fields->{'Images CA'}) ? $fields->{'Images CA'} : null,
                'decoration_options' => isset($fields->{'Decoration Options'}) ? $fields->{'Decoration Options'} : null,
                'column_2_retail_price_usd' => isset($fields->{'Column 2 - Retail Price USD (M)'}) ? $fields->{'Column 2 - Retail Price USD (M)'} : null,
                'shopify_images_status' => isset($fields->{'Shopify Images Status'}) ? $fields->{'Shopify Images Status'} : null,
                'product_status_on_shopify_store_ca' => isset($fields->{'Product Status On Shopify Store CA'}) ? $fields->{'Product Status On Shopify Store CA'} : null,
                'supplier_fees' => isset($fields->{'Supplier Fees'}) ? $fields->{'Supplier Fees'} : null,
                'available_in_canada' => isset($fields->{'Available In Canada'}) ? $fields->{'Available In Canada'} == true : null,
                'date_last_sync_initiated_ca' => isset($fields->{'Date Last Sync Initiated - CA'}) ? $fields->{'Date Last Sync Initiated - CA'} : null,
                'column_4_qty' => isset($fields->{'Column 4 - QTY'}) ? $fields->{'Column 4 - QTY'} : null,
                'option2_name' => isset($fields->{'Option2 Name'}) ? $fields->{'Option2 Name'} : null,
                'entering_net_or_retail_prices' => isset($fields->{'Entering Net or Retail Prices?'}) ? $fields->{'Entering Net or Retail Prices?'} : null,
                'shopify_id_ca' => isset($fields->{'∞ Shopify Id CA'}) ? $fields->{'∞ Shopify Id CA'} : null,
                'body_html' => isset($fields->{'Body HTML'}) ? $fields->{'Body HTML'} : null,
                'product_type_specific' => isset($fields->{'Product Type (Specific)'}) ? $fields->{'Product Type (Specific)'} : null,
                'column_1_retail_price_cad' => isset($fields->{'Column 1 - Retail Price CAD (M)'}) ? $fields->{'Column 1 - Retail Price CAD (M)'} : null,
                'supplier_sku_us' => isset($fields->{'Supplier SKU US'}) ? $fields->{'Supplier SKU US'} : null,
                'product_details_for_bcorp_reporting' => isset($fields->{'Product Details For B Corp Reporting'}) ? $fields->{'Product Details For B Corp Reporting'} : null,
                'paste_collection_tags_to_shopify_collections' => isset($fields->{'Paste Collection Tags To Shopify Collections'}) ? $fields->{'Paste Collection Tags To Shopify Collections'} : null,
                'create_variants' => isset($fields->{'Create Variants'}) ? $fields->{'Create Variants'} : null,
                'product_title_country' => isset($fields->{'Product Title - Country'}) ? $fields->{'Product Title - Country'} : null,
                'is_decoration_method_considered_variant' => isset($fields->{'Is Decoration Method Considered A Variant?'}) ? $fields->{'Is Decoration Method Considered A Variant?'} == true : null,
                'column_4_retail_price_usd' => isset($fields->{'Column 4 - Retail Price USD (M)'}) ? $fields->{'Column 4 - Retail Price USD (M)'} : null,
                'taxable_cad' => isset($fields->{'Taxable CAD'}) ? $fields->{'Taxable CAD'} == true : null,
                'column_5_retail_price_cad' => isset($fields->{'Column 5 - Retail Price CAD (M)'}) ? $fields->{'Column 5 - Retail Price CAD (M)'} : null,
                'column_5_qty' => isset($fields->{'Column 5 - QTY'}) ? $fields->{'Column 5 - QTY'} : null,
                'column_1_qty' => isset($fields->{'Column 1 - QTY'}) ? $fields->{'Column 1 - QTY'} : null,
                'collection_tags_from_product_type_specific' => isset($fields->{'Collection Tags (from Product Type (Specific))'}) ? $fields->{'Collection Tags (from Product Type (Specific))'} : null,
                'column_1_retail_price_usd' => isset($fields->{'Column 1 - Retail Price USD (M)'}) ? $fields->{'Column 1 - Retail Price USD (M)'} : null,
                'public_or_internal_availability' => isset($fields->{'Public or Internal Availability?'}) ? $fields->{'Public or Internal Availability?'} : null,
                'column_4_letter' => isset($fields->{'Column 4 - Letter'}) ? $fields->{'Column 4 - Letter'} : null,
                'status_ca' => isset($fields->{'Status CA'}) ? $fields->{'Status CA'} : null,
                'column_4_retail_price_cad' => isset($fields->{'Column 4 - Retail Price CAD (M)'}) ? $fields->{'Column 4 - Retail Price CAD (M)'} : null,
                'column_2_retail_price_cad' => isset($fields->{'Column 2 - Retail Price CAD (M)'}) ? $fields->{'Column 2 - Retail Price CAD (M)'} : null,
                'status_us' => isset($fields->{'Status US'}) ? $fields->{'Status US'} : null,
                'column_1_letter' => isset($fields->{'Column 1 - Letter'}) ? $fields->{'Column 1 - Letter'} : null,
                'requires_shipping' => isset($fields->{'Requires Shipping'}) ? $fields->{'Requires Shipping'} == true : null,
                'column_2_letter' => isset($fields->{'Column 2 - Letter'}) ? $fields->{'Column 2 - Letter'} : null,
                'images_us' => isset($fields->{'Images US'}) ? $fields->{'Images US'} : null,
                'date_last_sync_initiated_us' => isset($fields->{'Date Last Sync Initiated - US'}) ? $fields->{'Date Last Sync Initiated - US'} : null,
                'prompt_to_sync_data_to_shopify_ca' => isset($fields->{'Prompt To Sync Data To Shopify CA'}) ? $fields->{'Prompt To Sync Data To Shopify CA'} : null,
                'es_base_product_title_without_gender_or_sample' => isset($fields->{'ES Base Product Title (Without Gender Or Sample)'}) ? $fields->{'ES Base Product Title (Without Gender Or Sample)'} : null,
                'all_images_linked_in_images_ca_table' => isset($fields->{'All Images Linked In Images CA Table'}) ? $fields->{'All Images Linked In Images CA Table'} : null,
            ]);

            $product->save();
        }else{
            continue;

        }
       
    }
}

public function showAllCollectionAirTabel(Request $request){
    return $this->getAllproductDataFromAirtable();
}



}
