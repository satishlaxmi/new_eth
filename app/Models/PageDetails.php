<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PageDetails extends Model
{
    use HasFactory;

    protected $fillable=['page_name','url'];


    public function Banner(): HasOne
    {
        return $this->hasOne(Banner::class);
    }
}
