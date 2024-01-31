<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\AllProduct;

class Varaiant extends Model
{   
    use HasApiTokens ;
    protected $table = 'varaiant';
    protected $fillable = [
        'air_id_varaint',
        'variant_label',
        'product_id',
        'parent_product',
        'decoration_type',
        'color',
        'supp_inv_status',
        'back_until',
        'im_ca',
        'im_us',
        'link_im_ca',
        'link_im_us',
    ];

    public function product()
    {
        return $this->belongsTo(AllProduct::class, 'id_products_airtable', 'product_id');
    }
}
