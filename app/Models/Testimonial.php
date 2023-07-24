<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Testimonial extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_testimonials';
    
    public $timestamps = false;
    protected $fillable = [
        'user_full_name','user_image','content','entry_date', 'status'
    ];
}
