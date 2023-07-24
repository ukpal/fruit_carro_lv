<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HomeSlider extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_home_sliders';
    
    public $timestamps = false;
    protected $fillable = [
        'title','image', 'content', 'entry_date', 'status'
    ];
}
