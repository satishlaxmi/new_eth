<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllCatogery extends Model
{
    use HasFactory;

    protected $table = "allcategory";

    protected $fillable = [
        'catogery_id_air1',
        'Level_2_Collection',
        'Level_3_Collection',
        'product_linked'
    ];


   

   


}
