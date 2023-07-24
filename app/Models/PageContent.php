<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PageContent extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_page_contents';
    
    public $timestamps = false;
    protected $fillable = [
        'slug_title','page_id', 'title','file_name', 'file_type', 'content', 'entry_date'
    ];
}
