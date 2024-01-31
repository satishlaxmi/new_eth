<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable=['title','slug','page_id','description','photo','status'];

    public function PageDetails(): HasOne
    {
        return $this->hasOne(PageDetails::class);
    }
}


