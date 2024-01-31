<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    use HasFactory;
    protected $table = "emojirating";
    protected $fillable = [
        'id-emoji-air',
        'Emoji_Rating',
        'Caption',
        'Collection',
        'Notes',
        'SDGs',
        'SDG_from_SDGs',
        'ESG',
        'ESG_Impact',
        'Products',
        'Count_Active_Products_CA_US',
        'Count_Active_Products_CA',
        'Goal_Count_Active_Products_On_CA_Website',
        'Count_Active_Products_US',
        'Goal_Count_Active_Products_On_US_Website',
        'Count_Deficit_Active_Products_CA',
        'Count_Deficit_Active_Products_US',
    ];
}
