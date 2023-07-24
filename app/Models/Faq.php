<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Faq extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_faqs';
    
    public $timestamps = false;
    protected $fillable = [
        'title','description'
    ];
}
