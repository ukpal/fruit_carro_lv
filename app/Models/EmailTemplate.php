<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class EmailTemplate extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_email_templates';
    
    public $timestamps = false;
    protected $fillable = [
        'title','content', 'status'
    ];
}
