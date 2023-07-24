<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OrderStatus extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'fc_order_status';
    public $timestamps = false;
    protected $fillable = [
        'title','status'
    ];
}
