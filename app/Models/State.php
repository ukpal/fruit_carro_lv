<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class State extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_states';
    
    public $timestamps = false;
    protected $fillable = [
        'name','country_id'
    ];
}
