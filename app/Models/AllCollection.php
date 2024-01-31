<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AllProduct;

class AllCollection extends Model
{
    use HasFactory;

    protected $table = "allcolection";

    protected $fillable =[
    'id_allcollection_airtable',
    'Product Types' ,
    'Created' ,
    'Level 3 Collection' ,
    'Level 2 Collection' ,
    'All Collection Tags' ,
    'Part 1: Parent Products' ,
    'Count (ALL Active Products)' ,
    'Count (Active Products in CA)' ,
    'Goal Count Active Products On CA Website' ,
    'Active Product Deficit CA' ,
    'Active Product Surplus CA' ,
    'Active Product Surplus US' ,
    'Count (Active Products in US)' ,
    'Goal Count Active Products On US Website' ,
    'Active Product Deficit US' ,
    '# Women Owned' ,
    '# Unionized' ,
    '# Social Causes' ,
    '# BIPOC Owned' ,
    '# Indigenous Owned' ,
    '# Refugee Owned' ,
    '# B Corp' ,
    '# Environmental Causes' ,
    '# Organic' ,
    '# Biodegradable' ,
    '# Vegan' ,
    '# Made In Canada' ,
    '# Made In USA' ,
    '# Recycled' ,
    '# LGBTQ2+ Owned' ,
    '# Good' ,
    '# Better' ,
    '# Best' 

    ];

    public function product()
    {
        return $this->hasMany(AllProduct::class, 'collection_id', 'id_allcollection_airtable');
    }

    public static function getcollectionproducts($collectionName){
        $collection = AllCollection::find($collectionName);
        return [
            'data'=>$collection->product,
            'productCount'=>$collection->product->count()
        ];

    }
    public static function getAllCollection(){
        $collection = AllCollection::paginate(5);
        return  $collection;


    }
}
