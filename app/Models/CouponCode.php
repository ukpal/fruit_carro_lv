<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class CouponCode extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'fc_coupon_codes';
    public $timestamps = false;
    protected $fillable = [
        'coupon_code','discount', 'discount_type','products','users', 'status'
    ];
}
