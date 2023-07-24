<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Page extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_pages';
    
    public $timestamps = false;
    protected $fillable = [
        'title','content','status'
    ];
}
