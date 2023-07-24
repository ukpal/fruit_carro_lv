<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CouponCodeUser extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'fc_coupon_code_users';
    public $timestamps = false;
    protected $fillable = [
        'coupon_code_id','user_id'
    ];
}
