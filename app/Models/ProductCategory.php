<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ProductCategory extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_product_categories';

    protected $fillable = [
        'title','creater_id','product_category_image','description', 'status'
    ];

    public function slug(){
        return $this->hasOne(Slug::class, 'parent_id');
    }
}
