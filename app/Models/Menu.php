<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Menu extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_menus';

    public $timestamps = false;
    protected $fillable = [
        'parent_id','page_id','title','status'
    ];
}
