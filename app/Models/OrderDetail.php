<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OrderDetail extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'fc_order_details';
    public $timestamps = false;
    protected $fillable = [
        'order_id','product_id','quantity','price'
    ];
}
