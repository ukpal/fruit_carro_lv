<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Cart extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_cart';
    // protected $guarded=[];
    protected $fillable = [
        'user_id','cart_count','cart_details'
    ];

    
}
