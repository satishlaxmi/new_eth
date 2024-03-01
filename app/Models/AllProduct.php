<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Colour;

use App\Models\Test;
use App\Models\Emoji;



use App\Models\Varaiant;
use App\Models\AllCollection;
use App\Models\Cart;

class AllProduct extends Model
{


    use HasFactory;

    protected $table = "allproducts";

    protected $fillable = [
        'id',
        'id_products_airtable',
        'createdTime',
        'column_5_letter',
        'shopify_variant_image_matching_status',
        'supplier_product_url_usa',
        'material_made',
        'product_status_on_shopify_store_us',
        'part_3_variants',
        'pricing_last_verified_on_date',
        'link_to_images_ca',
        'supplier',
        'shopify_id_us',
        'column_3_retail_price_cad',
        'column_3_qty',
        'does_supplier_decorate_in_house',
        'column_5_retail_price_usd',
        'samples',
        'available_in_usa',
        'freight_estimates',
        'option1_name',
        'moq_source',
        'supplier_product_url_cad',
        'create_sample_variants',
        'prompt_to_sync_data_to_shopify_us',
        'emoji_ratings',
        'product_title',
        'supplier_fees_not_visible',
        'colours',
        'link_to_images_us',
        'compliance_status',
        'column_3_retail_price_usd',
        'colors_option_1_variants',
        'espc',
        'final_count_part_3_variants',
        'column_2_qty',
        'ltm_available',
        'column_3_letter',
        'supplier_sku_ca',
        'images_ca',
        'decoration_options',
        'column_2_retail_price_usd',
        'shopify_images_status',
        'product_status_on_shopify_store_ca',
        'supplier_fees',
        'available_in_canada',
        'date_last_sync_initiated_ca',
        'column_4_qty',
        'option2_name',
        'entering_net_or_retail_prices',
        'shopify_id_ca',
        'body_html',
        'product_type_specific',
        'column_1_retail_price_cad',
        'supplier_sku_us',
        'product_details_for_bcorp_reporting',
        'paste_collection_tags_to_shopify_collections',
        'create_variants',
        'product_title_country',
        'is_decoration_method_considered_variant',
        'column_4_retail_price_usd',
        'taxable_cad',
        'column_5_retail_price_cad',
        'column_5_qty',
        'column_1_qty',
        'column_0_qty',
        'collection_tags_from_product_type_specific',
        'column_1_retail_price_usd',
        'public_or_internal_availability',
        'column_4_letter',
        'status_ca',
        'column_4_retail_price_cad',
        'column_2_retail_price_cad',
        'status_us',
        'column_1_letter',
        'requires_shipping',
        'column_2_letter',
        'images_us',
        'date_last_sync_initiated_us',
        'prompt_to_sync_data_to_shopify_ca',
        'es_base_product_title_without_gender_or_sample',
        'all_images_linked_in_images_ca_table',
    ];

    //this making has many realtionship with variants table 
    public function variants()
    {
        return $this->hasMany(Varaiant::class, 'product_id', 'id_products_airtable');

    }

    public function review(){
    return $this->hasMany(ProductReview::class,'product_id','id');
    }
    
    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    /* 
    this making has many realtionship with collection table  with collection_id(product table col) with id_allcollection_airtable(table collection)
     */
    public function collection()
    {
        return $this->belongsTo(AllCollection::class, 'collection_id', 'id_allcollection_airtable');
    }

    //This function take id of the product and returns the all the information corespond to that product 
    public static function singleproductModal($id,$countryName){
      // $product = AllProduct::find($id);
       $product = Test::find($id);
      
       $country = $countryName == "canada"?"canada":"us";
       $colourArrayOld = json_decode($product->colours);
       $colourArray = json_decode($colourArrayOld->$country);
       $emojiArray = json_decode($product->emoji_ratings);

        $coloursWithImage = [];
        $emojiWithImage = [];

        foreach ($colourArray as $col) {
            $image = Colour::where('colour_categories', $col)->value('image');
            // Check if $image is not null before assigning it to the array
            if ($image !== null) {
                $coloursWithImage[$col] = $image;
            } else {
                // Handle the case where no record is found for the color category
                $coloursWithImage[$col] = null;
            }
        };
         //Emoji::where('airtabel_id', 'rec66lsvJ6kksVBZF')->value('emoji_rating');
         foreach ($emojiArray as $col) {
            $emoji = Emoji::where('airtabel_id', $col)->value('emoji_rating');
            // Check if $image is not null before assigning it to the array
            if ($emoji !== null) {
                $emojiWithImage[$col] = $emoji;
            } else {
                // Handle the case where no record is found for the color category
                $emojiWithImage[$col] = null;
            }
        }; 
       $product->colours = $coloursWithImage;
       $product->emoji_ratings = $emoji;
        if ($product) {
            $reviews = $product->review;
           /*  $starCounts = $reviews->groupBy('rate')
                ->mapWithKeys(function ($reviews, $star) {
                    return [$star => $reviews->count()];
                });  */
            //returning all the fields for now
            return response()->json([
                'product_data' => $product,
                'Varaint' => $product->variants,
                'collection' => $product->collection,
                /* 'review' => [
                    'data' => $reviews,
                    'star' => $starCounts->toArray(),
                ] */
            ]);
            //if return particualr fields the below make sure u selct all the required fields
            /* $productName = $product->product_title;
             */
        } else {
            return false ;
        }
    }

    //this function get all the star product 
    public static function starProductModal(){
        $starProduct = AllProduct::where('starproduct',1)->get();
         if ($starProduct) {
             return $starProduct;
             //if return particualr fields the below make sure u selct all the required fields
             /* $productName = $product->product_title;
              */
         } else {
             return false ;
         }
    }
     //this function get product count
    public  static function ProductCount(){
        $productCout = AllProduct::Count();
        return $productCout;
    }
    //this function get recent added product
    public  static function RecentAddedProduct($pageSize ,$country){
        $recentProduct = Test::where($country,1)->orderBy('created_at', 'desc')->limit($pageSize)->get();
        return $recentProduct ;

    }

    //this function get product of the usa origin
    public static function usaProduct(){
        $recentProduct = Test::where('available_in_usa', '1')->paginate(10);
        return $recentProduct ;
    }
    //this function get product of the can origin
    public static function canProduct($pageNo){
        $recentProduct = Test::where('available_in_canada', '1')->paginate(10);
        return $recentProduct ;
    }

  

    
    

}
