<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CouponCodeProduct extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'fc_coupon_code_products';
    public $timestamps = false;
    protected $fillable = [
        'coupon_code_id','product_id'
    ];
}
