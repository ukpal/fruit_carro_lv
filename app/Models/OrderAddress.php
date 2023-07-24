<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class OrderAddress extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_order_address';
    public $timestamps = false;
    protected $fillable = [
        'user_id','full_name','email_address','contact_number','address_line_1','address_line_2','city','state','country','zip_code','address_type','status'
    ];
}
