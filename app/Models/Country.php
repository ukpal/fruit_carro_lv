<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Country extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_countries';
    
    public $timestamps = false;
    protected $fillable = [
        'sortname','name', 'phonecode'
    ];
}
