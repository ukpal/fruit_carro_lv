<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Property;
use App\Models\PaymentList;
use App\Models\Slug;
use Validator;
use Session;
use DB;
use Carbon\Carbon;

class BlogsController extends Controller {
    public function index() {
        $mainHeader = "Blogs" ;
        
        $blogs = Blog::select('blogs.*','slugs.slug','users.first_name','users.last_name')->leftJoin('slugs', [['slugs.parent_id', '=', 'blogs.id'],['slugs.slug_type', '=', DB::raw("'Blogs'")]])->leftJoin('users', [['users.id', '=', 'blogs.creater_id']])->get();

        return view('site.blogs.index', ['mainHeader' => $mainHeader,'blogs' => $blogs]);
    }
    public function details(Request $request) {
        $slug = $request->segment(1);

        $blogDetails = Blog::where([['slugs.slug','=',$slug]])->select('blogs.*','slugs.slug','users.first_name','users.last_name')->leftJoin('slugs', [['slugs.parent_id', '=', 'blogs.id'],['slugs.slug_type', '=', DB::raw("'Blogs'")]])->leftJoin('users', [['users.id', '=', 'blogs.creater_id']])->first();

        $popularBlogs = Blog::where([['slugs.slug','!=',$slug]])->select('blogs.*','slugs.slug','users.first_name','users.last_name')->leftJoin('slugs', [['slugs.parent_id', '=', 'blogs.id'],['slugs.slug_type', '=', DB::raw("'Blogs'")]])->leftJoin('users', [['users.id', '=', 'blogs.creater_id']])->get();

        $featureProperties = Property::where([['properties.status','=','Active']])->select('slugs.slug','slugs.slug_type','properties.*','payment_lists.rent_amount','property_types.title AS property_type_title','users.first_name','users.last_name','users.email','users.phone_number','users.profile_image')->leftJoin('slugs', [['slugs.parent_id', '=', 'properties.id'],['slugs.slug_type', '=', DB::raw("'Properties'")]])->leftJoin('property_types', [['property_types.id', '=', 'properties.property_type_id']])->leftJoin('payment_lists', [['payment_lists.property_id', '=', 'properties.id']])->leftJoin('users', [['users.id', '=', 'properties.user_id']])->get();

        $mainHeader = $blogDetails->title;

        return view('site.blogs.details', ['mainHeader' => $mainHeader,'blogDetails' => $blogDetails,'popularBlogs' => $popularBlogs, 'featureProperties' => $featureProperties]);
    }
}
