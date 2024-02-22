<?php

namespace App\Http\Controllers\airtabel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Test;
use GuzzleHttp\Client;

use Config; 

class ProductairtabelController extends Controller
{
    public $AIR_TABLE_KEY;
    public $AIR_TABLE_BASE;
    public $AIRTABLE_BASE_PRODUCT;

    public function __construct()
    {
        $this->AIR_TABLE_KEY = Config::get('myconfig.airtabel.airtabel_key');
        $this->AIR_TABLE_BASE = Config::get('myconfig.airtabel.airtabel_base');
        $this->AIRTABLE_BASE_PRODUCT = Config::get('myconfig.airtabel.airtabel_product');
    }

    public function saveProduct(Request $request)
    {
        $dataOffset = null;
        do {
            $data = $this->getAllproductDataFromAirtable($dataOffset);
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
                    $existingProduct = Test::where('id_products_airtable', $data->id)->first();
                    if (!$existingProduct) {
                        $product = new Test([
                            'id_products_airtable' => $data->id,
                            'link_to_images_ca' => isset($fields->{'Link To Images CA'}) ? $fields->{'Link To Images CA'} : null,
                        'minium_qunatity'=>isset($fields->{'☁️⚙️ QTY Client Ordered (Only Confirmed Line Items)'}) ? $fields->{'☁️⚙️ QTY Client Ordered (Only Confirmed Line Items)'} : null,
                         'available_in_canada' => isset($fields->{'Available In Canada'}) ? $fields->{'Available In Canada'} == true : null,
                         'available_in_usa' => isset($fields->{'Available In USA'}) ? $fields->{'Available In USA'} == true : null,
                            'certBy'=>isset($fields->{'T - Product Tags For B Corp Reporting'}) ? json_encode($fields->{'T - Product Tags For B Corp Reporting'}) : null, 
                            'freight_estimates' => isset($fields->{'Freight Estimates'}) ? $fields->{'Freight Estimates'} : null,
                            'option1_name' => isset($fields->{'Option1 Name'}) ? $fields->{'Option1 Name'} : null,
                            'moq_source' => isset($fields->{'MOQ Source'}) ? $fields->{'MOQ Source'} : null,
                            'supplier_product_url_cad' => isset($fields->{'Supplier Product URL CAD'}) ? $fields->{'Supplier Product URL CAD'} : null,
                            'create_sample_variants' => isset($fields->{'Create Sample Variants'}) ? $fields->{'Create Sample Variants'} : null,
                            'prompt_to_sync_data_to_shopify_us' => isset($fields->{'Prompt To Sync Data To Shopify US'}) ? $fields->{'Prompt To Sync Data To Shopify US'} : null,
                            'emoji_ratings' => isset($fields->{'Emoji Ratings'}) ? json_encode($fields->{'Emoji Ratings'}) : null,
                            'product_title' => isset($fields->{'Product Title'}) ? $fields->{'Product Title'} : null,
                             'colours' => isset($fields->{'T - Colours For Website'}) ? json_encode($fields->{'T - Colours For Website'}): null,
                            'link_to_images_us' => isset($fields->{'Link To Images US'}) ? $fields->{'Link To Images US'} : null,
                            'compliance_status' => isset($fields->{'Compliance Status'}) ? $fields->{'Compliance Status'} : null,
                            'column_3_retail_price_usd' => isset($fields->{'Column 3 - Retail Price USD (M)'}) ? $fields->{'Column 3 - Retail Price USD (M)'} : null,
                            'colors_option_1_variants' => isset($fields->{'Colors (Option 1 Variants)'}) ? $fields->{'Colors (Option 1 Variants)'} : null,
                            'espc' => isset($fields->{'ESPC (Ethical Swag Product Code) ES Item # - ES SKU- DO NOT CHANGE'}) ? $fields->{'ESPC (Ethical Swag Product Code) ES Item # - ES SKU- DO NOT CHANGE'} : null,
                            'final_count_part_3_variants' => isset($fields->{'Final Count (Part 3: Variants)'}) ? $fields->{'Final Count (Part 3: Variants)'} : null,
                            'ltm_available' => isset($fields->{'LTM Available'}) ? $fields->{'LTM Available'} == true : null,
                            'column_3_letter' => isset($fields->{'Column 3 - Letter'}) ? $fields->{'Column 3 - Letter'} : null,
                            'supplier_sku_ca' => isset($fields->{'Supplier SKU CA'}) ? $fields->{'Supplier SKU CA'} : null,
                            'images_ca' => isset($fields->{'Images CA'}) ? json_encode($fields->{'Images CA'}): null,
                            'images_us' => isset($fields->{'Images US'}) ? json_encode($fields->{'Images US'}) : null,
                            'collection'=isset($fields->{'Collections (LookUp)'}) ? json_encode($fields->{'Collections (LookUp)'}) : null,
                            'decoration_options' => isset($fields->{'Decoration Options'}) ? $fields->{'Decoration Options'} : null,
                            'column_2_retail_price_usd' => isset($fields->{'Column 2 - Retail Price USD (M)'}) ? $fields->{'Column 2 - Retail Price USD (M)'} : null,
                            'shopify_images_status' => isset($fields->{'Shopify Images Status'}) ? $fields->{'Shopify Images Status'} : null,
                            'product_status_on_shopify_store_ca' => isset($fields->{'Product Status On Shopify Store CA'}) ? $fields->{'Product Status On Shopify Store CA'} : null,
                            'supplier_fees' => isset($fields->{'Supplier Fees'}) ? $fields->{'Supplier Fees'} : null,
                            'date_last_sync_initiated_ca' => isset($fields->{'Date Last Sync Initiated - CA'}) ? $fields->{'Date Last Sync Initiated - CA'} : null,
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
                             'product_description' => isset($fields->{'Product Description (Body HTML)'}) ? $fields->{'Product Description (Body HTML)'} : null,
                             'product_dimensions' => isset($fields->{'Product Dimensions (Body HTML)'}) ? $fields->{'Product Dimensions (Body HTML)'} : null,
                            'material_made' => isset($fields->{'Materials (Body HTML)'}) ? $fields->{'Materials (Body HTML)'} : null,
                            'is_decoration_method_considered_variant' => isset($fields->{'Is Decoration Method Considered A Variant?'}) ? $fields->{'Is Decoration Method Considered A Variant?'} == true : null,
                            'column_4_retail_price_usd' => isset($fields->{'Column 4 - Retail Price USD (M)'}) ? $fields->{'Column 4 - Retail Price USD (M)'} : null,
                            'taxable_cad' => isset($fields->{'Taxable CAD'}) ? $fields->{'Taxable CAD'} == true : null,
                            'column_5_retail_price_cad' => isset($fields->{'Column 5 - Retail Price CAD (M)'}) ? $fields->{'Column 5 - Retail Price CAD (M)'} : null,
                             'column_1_qty' => isset($fields->{'Column 1 - QTY'}) ? $fields->{'Column 1 - QTY'} : null,
                            'column_2_qty' => isset($fields->{'Column 2 - QTY'}) ? $fields->{'Column 2 - QTY'} : null,
                            'column_3_qty' => isset($fields->{'Column 3 - QTY'}) ? $fields->{'Column 3 - QTY'} : null,
                             'column_4_qty' => isset($fields->{'Column 4 - QTY'}) ? $fields->{'Column 4 - QTY'} : null,
                            'column_5_qty' => isset($fields->{'Column 5 - QTY'}) ? $fields->{'Column 5 - QTY'} : null,
                            'collection_tags_from_product_type_specific' => isset($fields->{'Collection Tags (from Product Type (Specific))'}) ? $fields->{'Collection Tags (from Product Type (Specific))'} : null,
                            'column_1_retail_price_usd' => isset($fields->{'Column 1 - Retail Price USD (M)'}) ? $fields->{'Column 1 - Retail Price USD (M)'} : null,
                            'public_or_internal_availability' => isset($fields->{'Public or Internal Availability?'}) ? $fields->{'Public or Internal Availability?'} : null,
                            'column_4_letter' => isset($fields->{'Column 4 - Letter'}) ? $fields->{'Column 4 - Letter'} : null,
                            'status_ca' => isset($fields->{'Status CA'}) ? $fields->{'Status CA'} : null,
                            'brand' => isset($fields->{'T - Swift Swag Tag'}) ? 1 : 0,
                            'status_ca' => isset($fields->{'Status CA'}) ? $fields->{'Status CA'} : null,
                            'brand' => isset($fields->{'T - Brand'}) ? json_encode($fields->{'T - Brand'}) : null,
                             'gender' => isset($fields->{'T - Apparel Gender'}) ? $fields->{'T - Apparel Gender'} : null,
                            'country_origin' => isset($fields->{'Country of Product Origin (Manufactured In)'}) ? json_encode($fields->{'Country of Product Origin (Manufactured In)'}) : null,
                            'column_4_retail_price_cad' => isset($fields->{'Column 4 - Retail Price CAD (M)'}) ? $fields->{'Column 4 - Retail Price CAD (M)'} : null,
                            'column_2_retail_price_cad' => isset($fields->{'Column 2 - Retail Price CAD (M)'}) ? $fields->{'Column 2 - Retail Price CAD (M)'} : null,
                             'status_us' => isset($fields->{'Status US'}) ? $fields->{'Status US'} : null,
                           ]);

                        $product->save();
                        
                    }

                } 

            }else {
                return response()->json([
                    "message" => "No data found",
                ]);
            } 
        } while ($dataOffset);
        return response()->json([
            "message" => "All data saved",
        ]);

    }

    public function getAllproductDataFromAirtable($dataOffset)
    {

        if ($dataOffset == false) {
            $url = "https://api.airtable.com/v0/{$this->AIR_TABLE_BASE}/{$this->AIRTABLE_BASE_PRODUCT}";
        } else {
            $offset = str_replace('/', '%', $dataOffset);
            $url = "https://api.airtable.com/v0/{$this->AIR_TABLE_BASE}/{$this->AIRTABLE_BASE_PRODUCT}?offset={$offset}";
        }
        $client = new Client([
            'verify' => false,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $this->AIR_TABLE_KEY,
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
                'dataOffset' => $dataOffset,
            ];
        } else {
            return response()->json([
                'message' => "Something went wrong",
            ], 500);
        }

    }
}
