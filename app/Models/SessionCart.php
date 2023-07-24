<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SessionCart extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_session_cart';
    // protected $guarded=[];
    protected $fillable = [
        'unique_id','cart_count','cart_details'
    ];

    
}
