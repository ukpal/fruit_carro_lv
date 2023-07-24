<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class PaymentType extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_payment_types';
    public $timestamps = false;
    protected $fillable = [
        'title','status'
    ];
}
