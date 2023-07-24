<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use App\Models\Property;
use App\Models\Slug;
use Validator;
use Session;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    // public function index() {
    //     $mainHeader = "Home" ;

    //     $testimonials = Testimonial::select('testimonials.*')->get();
    //     $properties = Property::select('properties.*')->get();

    //     return view('site.home.index', ['mainHeader' => $mainHeader,'testimonials' => $testimonials,'properties' => $properties]);
    // }

    public function index()
    {
        $returnData['mainHeader'] = "Home";


        $returnData['productCategories'] = ProductCategory::offset(0)->limit(5)->where('status', 'Active')->get();
        $returnData['cat_img_storage_path'] = env('APP_URL') . '/public/uploads/product_categories/normal/';
        // $returnData['fruits_on_sale'] = Slug::with('productCategories')->where('slug','fruits-on-sale')->get();
        $returnData['best_selling_fruits'] = Product::with('slug')->where('feature_product', 'Yes')->where('status', 'Active')->get();
        // $returnData['best_selling_fruits'] = Product::where([['feature_product','=','Yes']])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();
        $returnData['fresh_deals'] = Product::with('slug')->where('fresh_deals', 'Yes')->where('status', 'Active')->get();
        $returnData['product_img_storage_path'] = env('APP_URL') . '/public/uploads/products/normal/';
        return response()->json($returnData);
    }

    public function slider()
    {
        $returnData['errorCode'] = "Success";
        $returnData['sliders_storage_path'] = env('APP_URL') . '/public/uploads/home_sliders/normal/';
        $returnData['homeSliders'] = HomeSlider::where('status', 'Active')->get();
        return response()->json($returnData);
    }

    public function products()
    {
        $returnData['errorCode'] = "Success";
        $returnData['best_selling_fruits'] = Product::with('slug')->where('feature_product', 'Yes')->where('status', 'Active')->get();
        $returnData['fresh_deals'] = Product::with('slug')->where('fresh_deals', 'Yes')->where('status', 'Active')->get();
        $returnData['product_img_storage_path'] = env('APP_URL') . '/public/uploads/products/normal/';
        return response()->json($returnData);
    }

    public function shopByCategory()
    {
        $returnData['errorCode'] = "Success";
        $returnData['cat_img_storage_path'] = env('APP_URL') . '/public/uploads/product_categories/normal/';
        $returnData['productCategories'] = ProductCategory::with('slug')->offset(0)->limit(5)->where('status', 'Active')->get();
        return response()->json($returnData);
    }
}
