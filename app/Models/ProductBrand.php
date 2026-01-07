<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $fillable = [
        'product_id','brand_name','brand_detail',
        'brand_image','brand_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
