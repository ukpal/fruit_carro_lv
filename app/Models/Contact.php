<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Contact extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_contacts';
    
    // public $timestamps = false;
    protected $fillable = [
        'full_name', 'email','phone_number', 'message'
    ];
    // protected $fillable = [
    //     'first_name','last_name', 'email','phone_number', 'message', 'entry_date'
    // ];
}
