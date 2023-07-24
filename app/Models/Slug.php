<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Slug extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'fc_slugs';
    
    public $timestamps = false;
    protected $fillable = [
        'slug','parent_id','slug_type'
    ];

    public static function getSlug($data) {
        $slug = $data['slug'];
        $allSlug = Slug::where('slug', 'LIKE', $slug . '%')->get();

        $slugData = array();
        if(count($allSlug) > 0) {
            foreach($allSlug as $allSlug1) {
                $slugData[] = $allSlug1->slug;
            }
            if(in_array($slug, $slugData)) {
                $count = 0;
                while( in_array( ($slug . '-' . ++$count ), $slugData) );
                $slug = $slug . '-' . $count;
            }
        }
        return $slug;
    }

    public function product(){
        return $this->belongsTo(Product::class, 'parent_id');
    }

    
}