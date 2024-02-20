<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    use HasFactory;
    protected $table = "colour";
    protected $fillable = [
        'airtabel_id','colour_categories','color_swatch','color_swatch_id',
        'image','colour_catogery','parent_products'
    ];
}
