<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ProductGallery extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_product_galleries';

    protected $fillable = [
        'product_id','file_name','file_type'
    ];
}
