<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_products';

    protected $fillable = [
        'title', 'creater_id', 'category_id', 'price', 'amount', 'product_image', 'short_description', 'long_description', 'feature_product', 'status'
    ];

    public function slug()
    {
        return $this->hasOne(Slug::class, 'parent_id');
    }

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // public function scopeFilter($q)
    // {
    //     if (request('min_price')) {
    //         $q->where('price', '>', request('min_price'));
    //     }
    //     if (request('max_price')) {
    //         $q->where('price', '<', request('max_price'));
    //     }
    //     if (request('category')) {
    //         $q->whereIn('category_id',  request('category'));
    //     }

    //     return $q;
    // }
}
