<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Slug;
use App\Models\Product;
use App\Models\ProductCategory;
use Validator;
use Session;
// use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $returnData['mainHeader'] = "Shop";

        // $productCategories = ProductCategory::where([['product_categories.status', '=' , 'Active']])->selectRaw('smr_slugs.slug,smr_slugs.slug_type,smr_products.id,count(smr_products.id) as productCount,smr_product_categories.*')->leftJoin('products', [['products.creater_id', '=', 'product_categories.id']])->leftJoin('slugs', [['slugs.parent_id', '=', 'product_categories.id'],['slugs.slug_type', '=', DB::raw("'ProductCategories'")]])->groupBy(DB::raw("'products.id'"))->get();

        // $products = Product::where([['status','=','Active']])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();

        $returnData['productCategories'] = ProductCategory::with('slug')->where('status', 'Active')->get();
        $returnData['shopByCategory'] = ProductCategory::with('slug')->offset(0)->limit(5)->where('status', 'Active')->get();
        $returnData['cat_img_storage_path'] = env('APP_URL') . '/public/uploads/product_categories/normal/';
        $returnData['product_img_storage_path'] = env('APP_URL') . '/public/uploads/products/normal/';


        $products = Product::with('slug')->where('status', 'Active');
        if($request->has('category') && count($request->category)!=0){
            $products=$products->whereIn('category_id', $request->category);
        }
        if($request->has('categorySlug')){
            $slug=Slug::where([['slug','=',$request->categorySlug],['slug_type','=','ProductCategories']])->first(); 
            $returnData['selectedCategory']=$slug->parent_id;
            $products=$products->where('category_id',$slug->parent_id);
        }
        if($request->has('max_price')){
            $products=$products->whereBetween('price', [$request->min_price,$request->max_price]);
        }
        if($request->has('sort_by') && $request->sort_by!=''){
            if($request->sort_by=='latest'){
                $products=$products->orderBy('created_at', 'DESC');
            }
            if($request->sort_by=='price_asc'){
                $products=$products->orderBy('price', 'ASC');
            }
            if($request->sort_by=='price_dsc'){
                $products=$products->orderBy('price', 'DESC');
            }
        }
        $products=$products->get();

        $returnData['products']=$products;

        // if (!empty($request->user_id)) {
        //     $returnData['shoppingCart'] = Cart::where('user_id', $request->user_id)->get();
        // }

        return response()->json($returnData);
    }
}
