<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Slug;
use App\Models\ProductCategory;
use App\ProductGallery;
use App\ProductReview;
use App\ProductReviewLike;
use App\Library\Services\System;
use App\Models\Product;
use Validator;
use Session;
use DB;
use Carbon\Carbon;

class ProductsController extends Controller {
    public function index() {
        $mainHeader = "Shop" ;

        $productCategories = ProductCategory::where([['product_categories.status', '=' , 'Active']])->selectRaw('smr_slugs.slug,smr_slugs.slug_type,smr_products.id,count(smr_products.id) as productCount,smr_product_categories.*')->leftJoin('products', [['products.creater_id', '=', 'product_categories.id']])->leftJoin('slugs', [['slugs.parent_id', '=', 'product_categories.id'],['slugs.slug_type', '=', DB::raw("'ProductCategories'")]])->groupBy(DB::raw("'products.id'"))->get();

        $products = Product::where([['products.status','=','Active']])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();
        $allProducts = array();
        if(count($products) > 0) {
            $i = 0;
            foreach($products as $products1) {
                $allProducts[$i]['id'] = $products1->id;
                $allProducts[$i]['product_image'] = $products1->product_image;
                $allProducts[$i]['title'] = $products1->title;
                $allProducts[$i]['price'] = $products1->price;
                $allProducts[$i]['slug'] = $products1->slug;

                $averageRating = 0;
                $totalRatingCount = 0;
                $oneRatingCount = 0;
                $oneRatingPercent = 0;
                $twoRatingCount = 0;
                $twoRatingPercent = 0;
                $threeRatingCount = 0;
                $threeRatingPercent = 0;
                $fourRatingCount = 0;
                $fourRatingPercent = 0;
                $fiveRatingCount = 0;
                $fiveRatingPercent = 0;
                $totalCount = 0;
                $productReviews = ProductReview::where([['product_id', '=' ,$products1->id]])->get();
                if(count($productReviews) > 0) {
                    foreach($productReviews as $productReviews1) {
                        $rating = $productReviews1->rating;
                        $oneRatingCount = ($rating == 1) ? $oneRatingCount + 1: $oneRatingCount;
                        $twoRatingCount = ($rating == 2) ? $twoRatingCount + 1: $twoRatingCount;
                        $threeRatingCount = ($rating == 3) ? $threeRatingCount + 1: $threeRatingCount;
                        $fourRatingCount = ($rating == 4) ? $fourRatingCount + 1: $fourRatingCount;
                        $fiveRatingCount = ($rating == 5) ? $fiveRatingCount + 1: $fiveRatingCount;
                        $totalCount = ($rating != '') ? $totalCount + $rating : $totalCount;
                    }
                }
                $totalRatingCount = $oneRatingCount + $twoRatingCount + $threeRatingCount + $fourRatingCount + $fiveRatingCount;
                $oneRatingPercent = ($totalRatingCount > 0) ? ($oneRatingCount/$totalRatingCount)*100 : 0;
                $twoRatingPercent = ($totalRatingCount > 0) ? ($twoRatingCount/$totalRatingCount)*100 : 0;
                $threeRatingPercent = ($totalRatingCount > 0) ? ($threeRatingCount/$totalRatingCount)*100 : 0;
                $fourRatingPercent = ($totalRatingCount > 0) ? ($fourRatingCount/$totalRatingCount)*100 : 0;
                $fiveRatingPercent = ($totalRatingCount > 0) ? ($fiveRatingCount/$totalRatingCount)*100 : 0;
                $averageRating = ($totalCount > 0) ? round($totalCount/$totalRatingCount) : 0;
                $allProducts[$i]['average_rating'] = $averageRating;
                $allProducts[$i]['total_rating_count'] = $totalRatingCount;
                $allProducts[$i]['one_rating_count'] = $oneRatingCount;
                $allProducts[$i]['one_rating_percent'] = $oneRatingPercent;
                $allProducts[$i]['two_rating_count'] = $twoRatingCount;
                $allProducts[$i]['two_rating_percent'] = $twoRatingPercent;
                $allProducts[$i]['three_rating_count'] = $threeRatingCount;
                $allProducts[$i]['three_rating_percent'] = $threeRatingPercent;
                $allProducts[$i]['four_rating_count'] = $fourRatingCount;
                $allProducts[$i]['four_rating_percent'] = $fourRatingPercent;
                $allProducts[$i]['five_rating_count'] = $fiveRatingCount;
                $allProducts[$i]['five_rating_percent'] = $fiveRatingPercent;
                $allProducts[$i]['total_count'] = $totalCount;

                $i++;
            }
        }
        $allProducts = json_decode(json_encode($allProducts));

        return view('site.products.index', ['mainHeader' => $mainHeader,'allProducts' => $allProducts,'productCategories' => $productCategories]);
    }

    
    public function details(Request $request) {
        $slug=$request->slug;
        $product_id=Slug::where('slug',$slug)->where('slug_type','Products')->first(['parent_id']);
        $returnData['product']=Product::with('categories')->where('_id',$product_id->parent_id)->first();
        $returnData['relatedProducts']=Product::with('slug')->limit(5)->where('category_id',$returnData['product']->category_id)->get();
        $returnData['product_storage'] = env('APP_URL').'/public/uploads/products/normal/';


        // $productGalleries = ProductGallery::where([['product_id', '=' ,$product->id]])->get();

        // $relatedProducts = Product::where([['products.category_id', '=' ,$product->category_id],['products.status', '=' ,'Active'],['products.id', '!=' ,$product->id]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();
        $returnData['errorCode'] = "Success";
        return response()->json($returnData);
    }


    public function getProductByCategory(Request $request) {
        $slug = $request->get('get_val');
        $returnData['productView'] = '';
        if($slug != '') {
            if($slug == 'all') {
                $products = Product::where([['products.status','=','Active']])->select('slugs.slug','slugs.slug_type','products.*','product_categories.id AS product_category_id','product_categories.title AS product_category_title')->leftJoin('product_categories', [['product_categories.id', '=', 'products.category_id']])->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();
            } else {
                $slugDetails = Slug::where([['slug', '=' ,$slug],['slug_type','=','ProductCategories']])->first();
                $products = Product::where([['products.status','=','Active'],['products.category_id','=',$slugDetails->parent_id]])->select('slugs.slug','slugs.slug_type','products.*','product_categories.id AS product_category_id','product_categories.title AS product_category_title')->leftJoin('product_categories', [['product_categories.id', '=', 'products.category_id']])->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();
            }

            $allProducts = array();
            if(count($products) > 0) {
                $i = 0;
                foreach($products as $products1) {
                    $allProducts[$i]['id'] = $products1->id;
                    $allProducts[$i]['product_image'] = $products1->product_image;
                    $allProducts[$i]['title'] = $products1->title;
                    $allProducts[$i]['price'] = $products1->price;
                    $allProducts[$i]['slug'] = $products1->slug;

                    $averageRating = 0;
                    $totalRatingCount = 0;
                    $oneRatingCount = 0;
                    $oneRatingPercent = 0;
                    $twoRatingCount = 0;
                    $twoRatingPercent = 0;
                    $threeRatingCount = 0;
                    $threeRatingPercent = 0;
                    $fourRatingCount = 0;
                    $fourRatingPercent = 0;
                    $fiveRatingCount = 0;
                    $fiveRatingPercent = 0;
                    $totalCount = 0;
                    $productReviews = ProductReview::where([['product_id', '=' ,$products1->id]])->get();
                    if(count($productReviews) > 0) {
                        foreach($productReviews as $productReviews1) {
                            $rating = $productReviews1->rating;
                            $oneRatingCount = ($rating == 1) ? $oneRatingCount + 1: $oneRatingCount;
                            $twoRatingCount = ($rating == 2) ? $twoRatingCount + 1: $twoRatingCount;
                            $threeRatingCount = ($rating == 3) ? $threeRatingCount + 1: $threeRatingCount;
                            $fourRatingCount = ($rating == 4) ? $fourRatingCount + 1: $fourRatingCount;
                            $fiveRatingCount = ($rating == 5) ? $fiveRatingCount + 1: $fiveRatingCount;
                            $totalCount = ($rating != '') ? $totalCount + $rating : $totalCount;
                        }
                    }
                    $totalRatingCount = $oneRatingCount + $twoRatingCount + $threeRatingCount + $fourRatingCount + $fiveRatingCount;
                    $oneRatingPercent = ($totalRatingCount > 0) ? ($oneRatingCount/$totalRatingCount)*100 : 0;
                    $twoRatingPercent = ($totalRatingCount > 0) ? ($twoRatingCount/$totalRatingCount)*100 : 0;
                    $threeRatingPercent = ($totalRatingCount > 0) ? ($threeRatingCount/$totalRatingCount)*100 : 0;
                    $fourRatingPercent = ($totalRatingCount > 0) ? ($fourRatingCount/$totalRatingCount)*100 : 0;
                    $fiveRatingPercent = ($totalRatingCount > 0) ? ($fiveRatingCount/$totalRatingCount)*100 : 0;
                    $averageRating = ($totalCount > 0) ? round($totalCount/$totalRatingCount) : 0;
                    $allProducts[$i]['average_rating'] = $averageRating;
                    $allProducts[$i]['total_rating_count'] = $totalRatingCount;
                    $allProducts[$i]['one_rating_count'] = $oneRatingCount;
                    $allProducts[$i]['one_rating_percent'] = $oneRatingPercent;
                    $allProducts[$i]['two_rating_count'] = $twoRatingCount;
                    $allProducts[$i]['two_rating_percent'] = $twoRatingPercent;
                    $allProducts[$i]['three_rating_count'] = $threeRatingCount;
                    $allProducts[$i]['three_rating_percent'] = $threeRatingPercent;
                    $allProducts[$i]['four_rating_count'] = $fourRatingCount;
                    $allProducts[$i]['four_rating_percent'] = $fourRatingPercent;
                    $allProducts[$i]['five_rating_count'] = $fiveRatingCount;
                    $allProducts[$i]['five_rating_percent'] = $fiveRatingPercent;
                    $allProducts[$i]['total_count'] = $totalCount;

                    $i++;
                }
            }
            $allProducts = json_decode(json_encode($allProducts));

            $productView = view('site.products.ajax_products',['allProducts' => $allProducts])->render();
            $returnData['productView'] = $productView; 
        }
        echo json_encode($returnData);
        die();
    }


    public function ajaxReviewData(Request $request) {
        $returnData['reviewView'] = ''; 
        if($request->get('product_id') != '') {
            $productSlug = $request->get('product_id');

            $product = Product::where([['products.status','=','Active'],['slugs.slug','=',$productSlug]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();

            if(isset($product) && $product->id != '') {
                $averageRating = 0;
                $totalRatingCount = 0;
                $oneRatingCount = 0;
                $oneRatingPercent = 0;
                $twoRatingCount = 0;
                $twoRatingPercent = 0;
                $threeRatingCount = 0;
                $threeRatingPercent = 0;
                $fourRatingCount = 0;
                $fourRatingPercent = 0;
                $fiveRatingCount = 0;
                $fiveRatingPercent = 0;
                $totalCount = 0;
                $productReviews = ProductReview::where([['product_id', '=' ,$product->id]])->get();
                if(count($productReviews) > 0) {
                    foreach($productReviews as $productReviews1) {
                        $rating = $productReviews1->rating;
                        $oneRatingCount = ($rating == 1) ? $oneRatingCount + 1: $oneRatingCount;
                        $twoRatingCount = ($rating == 2) ? $twoRatingCount + 1: $twoRatingCount;
                        $threeRatingCount = ($rating == 3) ? $threeRatingCount + 1: $threeRatingCount;
                        $fourRatingCount = ($rating == 4) ? $fourRatingCount + 1: $fourRatingCount;
                        $fiveRatingCount = ($rating == 5) ? $fiveRatingCount + 1: $fiveRatingCount;
                        $totalCount = ($rating != '') ? $totalCount + $rating : $totalCount;
                    }
                }
                $totalRatingCount = $oneRatingCount + $twoRatingCount + $threeRatingCount + $fourRatingCount + $fiveRatingCount;
                $oneRatingPercent = ($totalRatingCount > 0) ? ($oneRatingCount/$totalRatingCount)*100 : 0;
                $twoRatingPercent = ($totalRatingCount > 0) ? ($twoRatingCount/$totalRatingCount)*100 : 0;
                $threeRatingPercent = ($totalRatingCount > 0) ? ($threeRatingCount/$totalRatingCount)*100 : 0;
                $fourRatingPercent = ($totalRatingCount > 0) ? ($fourRatingCount/$totalRatingCount)*100 : 0;
                $fiveRatingPercent = ($totalRatingCount > 0) ? ($fiveRatingCount/$totalRatingCount)*100 : 0;
                $averageRating = ($totalCount > 0) ? round($totalCount/$totalRatingCount) : 0;

                $productReviewDetails = (object)array('average_rating'=> $averageRating,'total_rating_count'=> $totalRatingCount,'one_rating_count'=> $oneRatingCount,'one_rating_percent'=> $oneRatingPercent,'two_rating_count'=> $twoRatingCount,'two_rating_percent'=> $twoRatingPercent,'three_rating_count'=> $threeRatingCount,'three_rating_percent'=> $threeRatingPercent,'four_rating_count'=> $fourRatingCount,'four_rating_percent'=> $fourRatingPercent,'five_rating_count'=> $fiveRatingCount,'five_rating_percent'=> $fiveRatingPercent,'total_count'=> $totalCount);

                $user = Auth::user();
                $userFullName = '';
                $userEmail = '';
                if(isset($user)) {
                    $userFullName = Auth::user()->first_name.' '.Auth::user()->last_name;
                    $userEmail = Auth::user()->email;
                }

                $reviewsPerPage = 10;
                $pageNum = $request->get('pagenum');

                $productTotalReviewsCount = ProductReview::where([['product_reviews.status','=','Active'],['product_reviews.product_id','=',$product->id]])->select('slugs.slug','slugs.slug_type','product_reviews.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'product_reviews.id'],['slugs.slug_type', '=', DB::raw("'Reviews'")]])->count();

                if (!(isset($pageNum))) {
                    $pageNum = 1; 
                } else {
                    $pageNum = intval($pageNum);        
                }
                $offSet = ($pageNum - 1) * $reviewsPerPage;
                $last = ceil($productTotalReviewsCount/$reviewsPerPage); 
                if ($pageNum < 1) { 
                    $pageNum = 1; 
                } elseif ($pageNum > $last)  { 
                    $pageNum = $last; 
                }

                $productReviews = ProductReview::where([['product_reviews.status','=','Active'],['product_reviews.product_id','=',$product->id]])->select('slugs.slug','slugs.slug_type','product_reviews.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'product_reviews.id'],['slugs.slug_type', '=', DB::raw("'Reviews'")]])->orderBy('id', 'DESC')->offset($offSet)->limit($reviewsPerPage)->get();

                $reviewView = view('site.products.ajax_reviews',['productReviews' => $productReviews,'productTotalReviewsCount' => $productTotalReviewsCount,'pageNum'=>$pageNum,'last'=>$last,'offSet'=>$offSet,'reviewsPerPage'=>$reviewsPerPage,'productSlug'=>$productSlug,'productReviewDetails' => $productReviewDetails,'userFullName' => $userFullName,'userEmail' => $userEmail,'userFullName' => $userFullName,'product' => $product ])->render();

                $returnData['errorCode'] = "Success";
                $returnData['message'] = "Product doesnot exist";
                $returnData['reviewView'] = $reviewView; 
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Product doesnot exist";
            }
        } else {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Product doesnot exist";
        }
        echo json_encode($returnData);
        die();
    }


    public function saveReview(Request $request) {
        $validation = Validator::make($request->all(),[
            'review_number' => 'required|max:10',
            'review_name' => 'required|max:500',
            'review_email' => 'required|max:500',
            'review_title' => 'required|max:500',
            'review_description' => 'required|max:5000',
            'review_product_id' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage.$error.'\n';
                }
            }
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errorMessage;
        } else {
            $userId = '';
            $user = Auth::user();
            if(isset($user) && $user->id != '') {
                $userId = $user->id;
            }
            $productSlug = $request->get('review_product_id');
            $product = Product::where([['products.status','=','Active'],['slugs.slug','=',$productSlug]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
            if(isset($product) && $product->id != '') {
                $productReview = new ProductReview;
                $productReview->product_id =  $product->id;
                $productReview->user_id =  $userId;
                $productReview->full_name =  $request->get('review_name');
                $productReview->email_address = $request->get('review_email');
                $productReview->title = $request->get('review_title');
                $productReview->review = $request->get('review_description');
                $productReview->rating = $request->get("review_number");
                $productReview->entry_date = date("Y-m-d H:i:s");
                $productReview->status = 'Active';
                $return = $productReview->save();
                $returnId = $productReview->id;

                if($return) {
                    $allData = array();
                    $allData['id'] = '';
                    $allData['slug'] = $request->get('review_title');
                    $allData['slug_type'] = 'Reviews';
                    $slugTitle = Slug::getSlug($allData);

                    $slugDetails = Slug::where([['parent_id', '=' ,$returnId],['slug_type','=','Reviews']])->first();
                    if(isset($slugDetails)) {
                        $slug = Slug::find($slugDetails->id);
                        $slug->slug = $slugTitle;
                        $slug->save();
                    } else {
                        $slug = new Slug;
                        $slug->slug =  $slugTitle;
                        $slug->parent_id = $returnId;
                        $slug->slug_type = 'Reviews';
                        $slug->save();
                    }

                    $returnData['errorCode'] = "Success";
                    $returnData['message'] = "Your review submitted successfully.";
                } else {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = "Error in review submittion";
                }
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Product doesnot exist";
            }
        }
        echo json_encode($returnData);
        die();
    }


    public function saveReviewLike(Request $request,System $systemLibrary) {
        $productReviewSlug = $request->get('product_review_id');
        $productReview = ProductReview::where([['slugs.slug','=',$productReviewSlug]])->select('slugs.slug','slugs.slug_type','product_reviews.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'product_reviews.id'],['slugs.slug_type', '=', DB::raw("'Reviews'")]])->first();
        
        $productReviewLikeCount = 0;
        $productReviewDislikeCount = 0;

        if(isset($productReview) && $productReview->id != '') {
            $productReviewLikeCount = ProductReviewLike::where([['like_type','=','Like'],['review_id','=',$productReview->id]])->count();
            $productReviewDislikeCount = ProductReviewLike::where([['like_type','=','Dislike'],['review_id','=',$productReview->id]])->count();
            $validation = Validator::make($request->all(),[
                'like_type' => 'required|max:10',
                'product_review_id' => 'required|max:10'
            ]);
            if($validation->fails()) {
                $errors = $validation->errors();
                $errorMessage = '';
                if ($errors->any()) {
                    foreach ($errors->all() as $error) {
                        $errorMessage = $errorMessage.$error.'\n';
                    }
                }
                $returnData['errorCode'] = "Error";
                $returnData['message'] = $errorMessage;
            } else {
                $userId = '';
                $user = Auth::user();
                if(isset($user) && $user->id != '') {
                    $userId = $user->id;
                }

                $ipAddress = $systemLibrary->ipAddress();
                $browser=$systemLibrary->browser();
                $deviceInfo=$systemLibrary->deviceInfo();
                $os = '';
                $device = '';
                if(count($deviceInfo) > 0) {
                    if(isset($deviceInfo['os'])) {
                        $os = $deviceInfo['os'];
                    }
                    if(isset($deviceInfo['device'])) {
                        $device = $deviceInfo['device'];
                    }
                }
                if($userId != '') {
                    $productReviewLike = ProductReviewLike::where([['user_id','=',$userId],['review_id','=',$productReview->id]])->select('*')->first();
                } else {
                    $productReviewLike = ProductReviewLike::where([['review_id','=',$productReview->id],['ip_address','=',$ipAddress],['browser','=',$browser],['operating_system','=',$os],['device','=',$device]])->select('*')->first();
                }
                if(isset($productReviewLike) && $productReviewLike->id != '') {
                    $productReviewLike = ProductReviewLike::find($productReviewLike->id);
                    $productReviewLike->review_id =  $productReview->id;
                    $productReviewLike->user_id =  $userId;
                    $productReviewLike->ip_address =  $ipAddress;
                    $productReviewLike->browser = $browser;
                    $productReviewLike->operating_system = $os;
                    $productReviewLike->device = $device;
                    $productReviewLike->like_type = $request->get('like_type');
                    $return = $productReviewLike->save();
                    $returnId = $productReviewLike->id;
                } else {
                    $productReviewLike = new ProductReviewLike;
                    $productReviewLike->review_id =  $productReview->id;
                    $productReviewLike->user_id =  $userId;
                    $productReviewLike->ip_address =  $ipAddress;
                    $productReviewLike->browser = $browser;
                    $productReviewLike->operating_system = $os;
                    $productReviewLike->device = $device;
                    $productReviewLike->like_type = $request->get('like_type');
                    $productReviewLike->entry_date = date("Y-m-d H:i:s");
                    $return = $productReviewLike->save();
                    $returnId = $productReviewLike->id;
                }

                if($return) {
                    $productReviewLikeCount = ProductReviewLike::where([['like_type','=','Like'],['review_id','=',$productReview->id]])->count();
                    $productReviewDislikeCount = ProductReviewLike::where([['like_type','=','Dislike'],['review_id','=',$productReview->id]])->count();

                    $ProductReview = ProductReview::find($productReview->id);
                    $ProductReview->like_count =  $productReviewLikeCount;
                    $ProductReview->dislike_count =  $productReviewDislikeCount;
                    $return = $ProductReview->save();

                    if($return) {
                        $returnData['errorCode'] = "Success";
                        $returnData['message'] = "Your review submitted successfully.";
                    } else {
                        $returnData['errorCode'] = "Error";
                        $returnData['message'] = "Error in review submittion";
                    }
                } else {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = "Error in review submittion";
                }
            }
        } else {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Product doesnot exist";
        }

        $returnData['likeCount'] = $productReviewLikeCount;
        $returnData['dislikeCount'] = $productReviewDislikeCount;

        echo json_encode($returnData);
        die();
    }
}
