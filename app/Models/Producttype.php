<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producttype extends Model
{
    protected $table = "collections";
    protected $fillable =[
            'airtabel_id',  
            'level_3_collection',
            'product_type',
            'catogery',
            'products',
            'good',
            'better',
            'best',
            'women_owned',
            'social_causes',
            'biopic_own',
            'indigenous_owned',
            'refugee_owned',
            'b_corp', // Remove extra double quote
            'environmental_causes',
            'organic',
            'biodegradable', // Remove extra double quote
            'vegan', // Remove extra double quote
            'made_can',
            'unionized',
            'made_usa',
            'recycled',
            'LGBTQ2+_owned',
            'parent_products',
            'product_type_2',
            
    ];
}
