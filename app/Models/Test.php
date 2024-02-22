<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Product;
use App\Models\Varaiant;
use App\Models\AllCollection;
use App\Models\Cart;


class Test extends Model
{
    use HasFactory;

    protected $table = "testallproducts";

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
}
