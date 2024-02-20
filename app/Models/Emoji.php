<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    use HasFactory;
    protected $table = "emoji";
    protected $fillable = [
        'airtabel_id',
        'emoji_rating',
        'caption',
        'collection',
        'notes',
        'sdgs',
        'sdg_from_sdgs',
        'esg',
        'esg_impact',
        'products',
        'count_Active_Products_CA_US',
        'count_Active_Products_CA',
        'count_Active_Products_US',
        'parent_products',
    ];
}
