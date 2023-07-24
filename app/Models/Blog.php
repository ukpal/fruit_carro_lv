<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Blog extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_blogs';
    
    public $timestamps = false;
    protected $fillable = [
        'title','creater_id','blog_image','content','entry_date', 'show_in_home_page','status'
    ];
}
