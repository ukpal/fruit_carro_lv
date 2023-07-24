<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Slug;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SessionCart;
use App\ProductCategory;
use App\ProductGallery;
use App\CouponCode;
use App\CouponCodeProduct;
use App\CouponCodeUser;
// use App\Models\Product as ModelsProduct;
use App\ShippingMethod;
use App\Notice;
use Validator;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // public function index(Request $request) {
    //     $mainHeader = "Cart" ;
    //     // $sessionCart = Session::get('cart');
    //     $sessionCart = $request->cartDetails;
    //     $allCartDetails = array();
    //     $totalPrice = 0;
    //     $totalDiscountedPrice = 0;
    //     $productActive = 'N';
    //     $userActive = 'N';

    //     if(isset($sessionCart['cartDetails']['couponDetails']['coupon_id'])) {
    //         $couponCodeDetails = CouponCode::where([['id', '=', $sessionCart['cartDetails']['couponDetails']['coupon_id']]])->first();
    //         if(isset($couponCodeDetails)) {
    //             if($couponCodeDetails->products == 'Selected') {
    //                 $couponCodeProductDetails = CouponCodeProduct::where([['coupon_code_id', '=' ,$couponCodeDetails->id]])->get();
    //                 if(count($couponCodeProductDetails) > 0) {
    //                     foreach($couponCodeProductDetails as $couponCodeProductDetails1) {
    //                         if(isset($sessionCart['cartDetails'][$couponCodeProductDetails1->product_id])) {
    //                             $productActive = 'Y';
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 $productActive = 'Y';
    //             }
    //             if($couponCodeDetails->users == 'Selected') {
    //                 $userDetails = Auth::user();
    //                 if(isset($userDetails)) {
    //                     $couponCodeUserCount = CouponCodeUser::where([['coupon_code_id', '=' ,$couponCodeDetails->id],['user_id', '=' ,$userDetails->id]])->count();
    //                     if($couponCodeUserCount > 0) {
    //                         $userActive = 'Y';
    //                     }
    //                 }
    //             } else {
    //                 $userActive = 'Y';
    //             }
    //         }
    //     }
    //     if($productActive == 'Y' && $userActive == 'Y') {
    //         if(isset($sessionCart['cartDetails'])) {
    //             foreach($sessionCart['cartDetails'] as $key=>$cartDetails) {
    //                 $productDetails = Product::where([['products.status','=','Active'],['products.id','=',$key]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
    //                 if(isset($productDetails)) {
    //                     $price = $productDetails->price;
    //                     if($couponCodeDetails->products == 'Selected') {
    //                         $productCouponCodeCount = CouponCodeProduct::where([['coupon_code_id', '=' ,$couponCodeDetails->id],['product_id', '=' ,$productDetails->id]])->count();
    //                         if($productCouponCodeCount > 0) {
    //                             if($couponCodeDetails->discount != '') {
    //                                 if($couponCodeDetails->discount_type == 'Fixed') {
    //                                     if($price > $couponCodeDetails->discount) {
    //                                         $price = $price - $couponCodeDetails->discount;
    //                                     } else {
    //                                         $price = 0;
    //                                     }
    //                                 } else if($couponCodeDetails->discount_type == 'Percent') {
    //                                     $price = $price - (($price/100)*$couponCodeDetails->discount);
    //                                 }
    //                             }
    //                         }
    //                     }
    //                     $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
    //                     $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
    //                     $allCartDetails['cart'][$key]['title'] = $productDetails->title;
    //                     $allCartDetails['cart'][$key]['price'] = $productDetails->price;
    //                     $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
    //                     $allCartDetails['cart'][$key]['quantity'] = $cartDetails['quantity'];
    //                     $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $cartDetails['quantity'];
    //                     $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
    //                     $allCartDetails['cart'][$key]['total_discounted_price'] = $price * $cartDetails['quantity'];
    //                     $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
    //                 }
    //             }
    //         }
    //         $allCartDetails['total_price'] = $totalPrice;

    //         if($couponCodeDetails->products == 'All') {
    //             if($couponCodeDetails->discount != '') {
    //                 if($couponCodeDetails->discount_type == 'Fixed') {
    //                     if($totalPrice > $couponCodeDetails->discount) {
    //                         $totalDiscountedPrice = $totalPrice - $couponCodeDetails->discount;
    //                     } else {
    //                         $totalDiscountedPrice = 0;
    //                     }
    //                 } else if($couponCodeDetails->discount_type == 'Percent') {
    //                     $totalDiscountedPrice = $totalPrice - (($totalPrice/100)*$couponCodeDetails->discount);
    //                 }
    //             }
    //         }

    //         $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
    //         $allCartDetails['coupon_id'] = $sessionCart['cartDetails']['couponDetails']['coupon_id'];
    //         $allCartDetails['coupon_code'] = $sessionCart['cartDetails']['couponDetails']['coupon_code'];
    //         $allCartDetails = json_decode(json_encode($allCartDetails));
    //     } else {
    //         if(isset($sessionCart['cartDetails'])) {
    //             foreach($sessionCart['cartDetails'] as $key=>$cartDetails) {
    //                 $productDetails = Product::where([['products.status','=','Active'],['products.id','=',$key]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
    //                 if(isset($productDetails)) {
    //                     $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
    //                     $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
    //                     $allCartDetails['cart'][$key]['title'] = $productDetails->title;
    //                     $allCartDetails['cart'][$key]['price'] = $productDetails->price;
    //                     $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
    //                     $allCartDetails['cart'][$key]['quantity'] = $cartDetails['quantity'];
    //                     $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $cartDetails['quantity'];
    //                     $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
    //                     $allCartDetails['cart'][$key]['total_discounted_price'] = $productDetails->price * $cartDetails['quantity'];
    //                     $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
    //                 }
    //             }
    //         }
    //         $allCartDetails['total_price'] = $totalPrice;
    //         $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
    //         $allCartDetails = json_decode(json_encode($allCartDetails));
    //     }

    //     $products = Product::where([['products.status','=','Active']])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();

    //     // $notices = Notice::where([['notices.status','=','Active']])->select('slugs.slug','slugs.slug_type','notices.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'notices.id'],['slugs.slug_type', '=', DB::raw("'Notices'")]])->get();

    //     // $shippingMethods = ShippingMethod::where([['status', '=' ,'Active']])->get();

    //     // $returnData= ['mainHeader' => $mainHeader,'allCartDetails' => $allCartDetails,'products' => $products,'notices' => $notices,'shippingMethods' => $shippingMethods];
    //     $returnData= ['mainHeader' => $mainHeader,'allCartDetails' => $allCartDetails,'products' => $products];
    //     return response()->json($returnData);
    // }


    public function index(Request $request)
    {
        $mainHeader = "Cart";
        
        $sessionCart = json_decode(json_encode($request->cartDetails));
        // $sessionCart = $request->cartDetails;
        $allCartDetails = array();
        $totalPrice = 0;
        $totalDiscountedPrice = 0;
        $productActive = 'N';
        $userActive = 'N';
        if ($request->has('uuid')) {
            $sessionCart = SessionCart::where('unique_id',$request->uuid)->first();
            // foreach ($sessionCart->productDetails as $key => $value) {
            //     $product_id = $value->product->id;
            //     $productDetails = Product::where('_id', $product_id)->first();
            //     // print_r($productDetails);
            //     if (isset($productDetails)) {
            //         $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
            //         $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
            //         $allCartDetails['cart'][$key]['title'] = $productDetails->title;
            //         $allCartDetails['cart'][$key]['price'] = $productDetails->price;
            //         $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
            //         $allCartDetails['cart'][$key]['quantity'] = $value->quantity;
            //         $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $value->quantity;
            //         $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
            //         // $allCartDetails['cart'][$key]['total_discounted_price'] = $productDetails->price * $cartDetails['quantity'];
            //         // $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
            //     }
            // }
            foreach ($sessionCart->cart_details as $key=>$value) {
                // return $key; die();
                $allCartDetails['cart'][$key]['title'] = $value['product']['title'];
                // $allCartDetails['cart'][$key]['slug'] = $value['product']->slug;
                $allCartDetails['cart'][$key]['price'] = $value['product']['price'];
                $allCartDetails['cart'][$key]['product_image'] = $value['product']['product_image'];
                $allCartDetails['cart'][$key]['quantity'] = $value['product_count'];
                $allCartDetails['cart'][$key]['product_sub_total'] = $value['product']['price']*$value['product_count'];
                $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['product_sub_total'];
                // return $value['product']['_id']; die();
                // $productDetails=$value['product'];
                // $allCartDetails['cart'][$key]['product_id'] = $value['product']['_id'];
                // $allCartDetails['cart'][$key]['slug'] = $productDetails['slug']['slug'];
                // $allCartDetails['cart'][$key]['title'] = $productDetails['title'];
                // $allCartDetails['cart'][$key]['price'] = $productDetails['price'];
                // $allCartDetails['cart'][$key]['product_image'] = $productDetails['product_image'];
                // $allCartDetails['cart'][$key]['quantity'] = $value['product_count'];
                // $allCartDetails['cart'][$key]['product_sub_total'] = $productDetails['price'] * $value['product_count'];
                // $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['product_sub_total'];
            }
        }
        $allCartDetails['total_price'] = $totalPrice;
        $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
        $allCartDetails['product_storage'] = env('APP_URL') . '/public/uploads/products/thumb/';
        // $allCartDetails = $allCartDetails;

        $returnData = ['mainHeader' => $mainHeader, 'allCartDetails' => $allCartDetails];
        return response()->json($returnData);
        // print_r($sessionCart->productDetails);
    }


    // public function addToCart(Request $request) {
    //     $sessionCart = Session::get('cart');
    //     if(empty($request->product_id)) {
    //         $returnData['errorCode'] = "Error";
    //         $returnData['message'] = "Please select any product";
    //         $returnData['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] : 0 ;
    //     } else {
    //         $productDetails = Product::find($request->product_id);
    //         if(isset($productDetails)) {
    //             $productQuantity = ($request->quantity != '') ? $request->quantity : 1;
    //             if(isset($sessionCart['cartDetails'][$request->product_id])) {
    //                 $sessionCart['cartDetails'][$request->product_id]['quantity'] = $sessionCart['cartDetails'][$request->product_id]['quantity'] + $productQuantity;
    //             } else {
    //                 $sessionCart['cartDetails'][$request->product_id]['quantity'] = $productQuantity;
    //             }
    //             $sessionCart['cartDetails']['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] + $productQuantity : $productQuantity;
    //             Session::put('cart', $sessionCart);
    //             Session::save();
    //             $sessionCart = Session::get('cart');
    //             $returnData['errorCode'] = "Success";
    //             $returnData['message'] = "Product added to cart";
    //             $returnData['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] : 0 ;
    //         } else {
    //             $returnData['errorCode'] = "Error";
    //             $returnData['message'] = "Invalid product";
    //             $returnData['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] : 0 ;
    //         }
    //     }
    //     echo json_encode($returnData);
    //     die();
    // }



    public function addToCart(Request $request)
    {
        if ($request->user_id) {
            $oldCartUser = Cart::where('user_id', $request->user_id)->first();
            if($oldCartUser){
                $oldCartUser->cart_item=$oldCartUser->cart_item+1;
                $cartDetails=$oldCartUser->cart_details;
                array_push($cartDetails,$request->cart_details);
                $oldCartUser->cart_details=$cartDetails;
                if($oldCartUser->save()){
                    $returnData['errorCode']='Success';
                    $returnData['message']='Cart updated Successfully';
                }
            }else{
                $newCartUser=new Cart();
                $newCartUser->user_id=$request->user_id;
                $newCartUser->cart_item=1;
                $newCartUser->cart_details=[$request->cart_details];
                if($newCartUser->save()){
                    $returnData['errorCode']='Success';
                    $returnData['message']='Cart updated Successfully';
                }
            }
        } else {
            if ($request->uuid) {
                $oldDetails = SessionCart::where('unique_id', $request->uuid)->first();
                $oldDetails->cart_count = 1 + $oldDetails->cart_count;
                $cartDetails=$oldDetails->cart_details;
                array_push($cartDetails,$request->cart_details);
                $oldDetails->cart_details=$cartDetails;
                if($oldDetails->save()){
                    $returnData['errorCode']='Success';
                    $returnData['message']='Cart updated Successfully';
                }
            } else {
                do {
                    $uniqueId = uniqid();
                } while (SessionCart::where('unique_id', $uniqueId)->exists());
                $newCartItem = new SessionCart();
                $newCartItem->unique_id = $uniqueId;
                $newCartItem->cart_count = 1;
                $newCartItem->cart_details = [$request->cart_details];
                if($newCartItem->save()){
                    $returnData['errorCode']='Success';
                    $returnData['message']='Cart updated Successfully';
                    $returnData['uniqueId'] = $uniqueId;
                }
                
            }
        }
        return response()->json($returnData);
    }


    public function changeCart(Request $request)
    {
        $sessionCart = Session::get('cart');

        if (empty($request->product_id)) {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Please select any product";
            $returnData['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] : 0;
        } else {
            $productDetails = Product::find($request->product_id);
            if (isset($productDetails)) {
                if ($request->change_type == 'Plus') {
                    $newQuantity = $sessionCart['cartDetails'][$request->product_id]['quantity'] + 1;
                    $sessionCart['cartDetails'][$request->product_id]['quantity'] = $newQuantity;
                    $sessionCart['cartDetails']['cartCount'] = $sessionCart['cartDetails']['cartCount'] + 1;
                } else if ($request->change_type == 'Minus') {
                    $newQuantity = $sessionCart['cartDetails'][$request->product_id]['quantity'] - 1;
                    if ($newQuantity == 0) {
                        unset($sessionCart['cartDetails'][$request->product_id]);
                    } else {
                        $sessionCart['cartDetails'][$request->product_id]['quantity'] = $newQuantity;
                    }
                    $sessionCart['cartDetails']['cartCount'] = (isset($sessionCart['cartDetails']['cartCount']) && $sessionCart['cartDetails']['cartCount'] > 0) ? $sessionCart['cartDetails']['cartCount'] - 1 : 0;
                } else if ($request->change_type == 'Remove') {
                    $sessionCart['cartDetails']['cartCount'] = (isset($sessionCart['cartDetails']['cartCount']) && $sessionCart['cartDetails']['cartCount'] > 0) ? $sessionCart['cartDetails']['cartCount'] - $sessionCart['cartDetails'][$request->product_id]['quantity'] : 0;
                    unset($sessionCart['cartDetails'][$request->product_id]);
                }
                Session::put('cart', $sessionCart);
                Session::save();
                $sessionCart = Session::get('cart');

                $returnData['errorCode'] = "Success";
                $returnData['message'] = "Cart has been updated";
                $returnData['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] : 0;
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Invalid product";
                $returnData['cartCount'] = (isset($sessionCart['cartDetails']['cartCount'])) ? $sessionCart['cartDetails']['cartCount'] : 0;
            }
        }

        $allCartDetails = array();
        $totalPrice = 0;
        $totalDiscountedPrice = 0;
        $productActive = 'N';
        $userActive = 'N';

        if (isset($sessionCart['cartDetails']['couponDetails']['coupon_id'])) {
            $couponCodeDetails = CouponCode::where([['id', '=', $sessionCart['cartDetails']['couponDetails']['coupon_id']]])->first();
            if (isset($couponCodeDetails)) {

                if ($couponCodeDetails->products == 'Selected') {
                    $couponCodeProductDetails = CouponCodeProduct::where([['coupon_code_id', '=', $couponCodeDetails->id]])->get();
                    if (count($couponCodeProductDetails) > 0) {
                        foreach ($couponCodeProductDetails as $couponCodeProductDetails1) {
                            if (isset($sessionCart['cartDetails'][$couponCodeProductDetails1->product_id])) {
                                $productActive = 'Y';
                            }
                        }
                    }
                } else {
                    $productActive = 'Y';
                }
                if ($couponCodeDetails->users == 'Selected') {
                    $userDetails = Auth::user();
                    if (isset($userDetails)) {
                        $couponCodeUserCount = CouponCodeUser::where([['coupon_code_id', '=', $couponCodeDetails->id]])->count();
                        if ($couponCodeUserCount > 0) {
                            $userActive = 'Y';
                        }
                    }
                } else {
                    $userActive = 'Y';
                }
            }
        }
        if ($productActive == 'Y' && $userActive == 'Y') {
            if (isset($sessionCart['cartDetails'])) {
                foreach ($sessionCart['cartDetails'] as $key => $cartDetails) {
                    $productDetails = Product::where([['products.status', '=', 'Active'], ['products.id', '=', $key]])->select('slugs.slug', 'slugs.slug_type', 'products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'], ['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
                    if (isset($productDetails)) {
                        $price = $productDetails->price;
                        if ($couponCodeDetails->products == 'Selected') {
                            $productCouponCodeCount = CouponCodeProduct::where([['coupon_code_id', '=', $couponCodeDetails->id], ['product_id', '=', $productDetails->id]])->count();
                            if ($productCouponCodeCount > 0) {
                                if ($couponCodeDetails->discount != '') {
                                    if ($couponCodeDetails->discount_type == 'Fixed') {
                                        if ($price > $couponCodeDetails->discount) {
                                            $price = $price - $couponCodeDetails->discount;
                                        } else {
                                            $price = 0;
                                        }
                                    } else if ($couponCodeDetails->discount_type == 'Percent') {
                                        $price = $price - (($price / 100) * $couponCodeDetails->discount);
                                    }
                                }
                            }
                        }
                        $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
                        $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
                        $allCartDetails['cart'][$key]['title'] = $productDetails->title;
                        $allCartDetails['cart'][$key]['price'] = $productDetails->price;
                        $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
                        $allCartDetails['cart'][$key]['quantity'] = $cartDetails['quantity'];
                        $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $cartDetails['quantity'];
                        $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
                        $allCartDetails['cart'][$key]['total_discounted_price'] = $price * $cartDetails['quantity'];
                        $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
                    }
                }
            }
            $allCartDetails['total_price'] = $totalPrice;

            if ($couponCodeDetails->products == 'All') {
                if ($couponCodeDetails->discount != '') {
                    if ($couponCodeDetails->discount_type == 'Fixed') {
                        if ($totalPrice > $couponCodeDetails->discount) {
                            $totalDiscountedPrice = $totalPrice - $couponCodeDetails->discount;
                        } else {
                            $totalDiscountedPrice = 0;
                        }
                    } else if ($couponCodeDetails->discount_type == 'Percent') {
                        $totalDiscountedPrice = $totalPrice - (($totalPrice / 100) * $couponCodeDetails->discount);
                    }
                }
            }

            $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
            $allCartDetails['coupon_id'] = $sessionCart['cartDetails']['couponDetails']['coupon_id'];
            $allCartDetails['coupon_code'] = $sessionCart['cartDetails']['couponDetails']['coupon_code'];
            $allCartDetails = json_decode(json_encode($allCartDetails));
        } else {
            if (isset($sessionCart['cartDetails'])) {
                foreach ($sessionCart['cartDetails'] as $key => $cartDetails) {
                    $productDetails = Product::where([['products.status', '=', 'Active'], ['products.id', '=', $key]])->select('slugs.slug', 'slugs.slug_type', 'products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'], ['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
                    if (isset($productDetails)) {
                        $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
                        $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
                        $allCartDetails['cart'][$key]['title'] = $productDetails->title;
                        $allCartDetails['cart'][$key]['price'] = $productDetails->price;
                        $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
                        $allCartDetails['cart'][$key]['quantity'] = $cartDetails['quantity'];
                        $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $cartDetails['quantity'];
                        $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
                        $allCartDetails['cart'][$key]['total_discounted_price'] = $productDetails->price * $cartDetails['quantity'];
                        $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
                    }
                }
            }
            $allCartDetails['total_price'] = $totalPrice;
            $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
            $allCartDetails = json_decode(json_encode($allCartDetails));
        }

        $shippingMethods = ShippingMethod::where([['status', '=', 'Active']])->get();
        $cartView = view('site.cart.ajax_cart_details', ['allCartDetails' => $allCartDetails, 'shippingMethods' => $shippingMethods])->render();

        $returnData['cartView'] = $cartView;

        echo json_encode($returnData);
        die();
    }
    public function applyCouponCode(Request $request)
    {
        $sessionCart = Session::get('cart');

        if (empty($request->coupon_code)) {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Please select any product";
            $returnData['cartTotalView'] = '';
        } else {
            $couponCodeDetails = CouponCode::where([['coupon_code', '=', $request->coupon_code]])->first();
            if (isset($couponCodeDetails)) {
                $productActive = 'N';
                $userActive = 'N';
                if ($couponCodeDetails->products == 'Selected') {
                    $couponCodeProductDetails = CouponCodeProduct::where([['coupon_code_id', '=', $couponCodeDetails->id]])->get();
                    if (count($couponCodeProductDetails) > 0) {
                        foreach ($couponCodeProductDetails as $couponCodeProductDetails1) {
                            if (isset($sessionCart['cartDetails'][$couponCodeProductDetails1->product_id])) {
                                $productActive = 'Y';
                            }
                        }
                    }
                } else {
                    $productActive = 'Y';
                }
                if ($couponCodeDetails->users == 'Selected') {
                    $userDetails = Auth::user();
                    if (isset($userDetails)) {
                        $couponCodeUserCount = CouponCodeUser::where([['coupon_code_id', '=', $couponCodeDetails->id]])->count();
                        if ($couponCodeUserCount > 0) {
                            $userActive = 'Y';
                        }
                    }
                } else {
                    $userActive = 'Y';
                }
            }
            if ($productActive == 'Y' && $userActive == 'Y') {
                $sessionCart['cartDetails']['couponDetails']['coupon_id'] = $couponCodeDetails->id;
                $sessionCart['cartDetails']['couponDetails']['coupon_code'] = $couponCodeDetails->coupon_code;

                $allCartDetails = array();
                $totalPrice = 0;
                $totalDiscountedPrice = 0;
                if (isset($sessionCart['cartDetails'])) {
                    foreach ($sessionCart['cartDetails'] as $key => $cartDetails) {
                        $productDetails = Product::where([['products.status', '=', 'Active'], ['products.id', '=', $key]])->select('slugs.slug', 'slugs.slug_type', 'products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'], ['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
                        if (isset($productDetails)) {
                            $price = $productDetails->price;
                            if ($couponCodeDetails->products == 'Selected') {
                                $productCouponCodeCount = CouponCodeProduct::where([['coupon_code_id', '=', $couponCodeDetails->id], ['product_id', '=', $productDetails->id]])->count();
                                if ($productCouponCodeCount > 0) {
                                    if ($couponCodeDetails->discount != '') {
                                        if ($couponCodeDetails->discount_type == 'Fixed') {
                                            if ($price > $couponCodeDetails->discount) {
                                                $price = $price - $couponCodeDetails->discount;
                                            } else {
                                                $price = 0;
                                            }
                                        } else if ($couponCodeDetails->discount_type == 'Percent') {
                                            $price = $price - (($price / 100) * $couponCodeDetails->discount);
                                        }
                                    }
                                }
                            }
                            $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
                            $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
                            $allCartDetails['cart'][$key]['title'] = $productDetails->title;
                            $allCartDetails['cart'][$key]['price'] = $productDetails->price;
                            $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
                            $allCartDetails['cart'][$key]['quantity'] = $cartDetails['quantity'];
                            $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $cartDetails['quantity'];
                            $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
                            $allCartDetails['cart'][$key]['total_discounted_price'] = $price * $cartDetails['quantity'];
                            $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
                        }
                    }
                }
                $allCartDetails['total_price'] = $totalPrice;

                if ($couponCodeDetails->products == 'All') {
                    if ($couponCodeDetails->discount != '') {
                        if ($couponCodeDetails->discount_type == 'Fixed') {
                            if ($totalPrice > $couponCodeDetails->discount) {
                                $totalDiscountedPrice = $totalPrice - $couponCodeDetails->discount;
                            } else {
                                $totalDiscountedPrice = 0;
                            }
                        } else if ($couponCodeDetails->discount_type == 'Percent') {
                            $totalDiscountedPrice = $totalPrice - (($totalPrice / 100) * $couponCodeDetails->discount);
                        }
                    }
                }

                $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
                $allCartDetails['coupon_id'] = $sessionCart['cartDetails']['couponDetails']['coupon_id'];
                $allCartDetails['coupon_code'] = $sessionCart['cartDetails']['couponDetails']['coupon_code'];
                $allCartDetails = json_decode(json_encode($allCartDetails));

                Session::put('cart', $sessionCart);
                Session::save();

                $cartTotalView = view('site.cart.ajax_cart_total', ['allCartDetails' => $allCartDetails])->render();
                $returnData['cartTotalView'] = $cartTotalView;
                $returnData['errorCode'] = "Success";
                $returnData['message'] = "Coupon code exist";
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Coupon code doesnot exist";
                $returnData['cartTotalView'] = '';
            }
        }
        echo json_encode($returnData);
    }
    public function removeCouponCode(Request $request)
    {
        $sessionCart = Session::get('cart');

        if (empty($request->coupon_code)) {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Please select any product";
            $returnData['cartTotalView'] = '';
        } else {
            $couponCodeDetails = CouponCode::where([['coupon_code', '=', $request->coupon_code]])->first();
            if (isset($couponCodeDetails)) {
                unset($sessionCart['cartDetails']['couponDetails']['coupon_id']);
                unset($sessionCart['cartDetails']['couponDetails']['coupon_code']);
            }

            $allCartDetails = array();
            $totalPrice = 0;
            $totalDiscountedPrice = 0;
            if (isset($sessionCart['cartDetails'])) {
                foreach ($sessionCart['cartDetails'] as $key => $cartDetails) {
                    $productDetails = Product::where([['products.status', '=', 'Active'], ['products.id', '=', $key]])->select('slugs.slug', 'slugs.slug_type', 'products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'], ['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
                    if (isset($productDetails)) {
                        $allCartDetails['cart'][$key]['product_id'] = $productDetails->id;
                        $allCartDetails['cart'][$key]['slug'] = $productDetails->slug;
                        $allCartDetails['cart'][$key]['title'] = $productDetails->title;
                        $allCartDetails['cart'][$key]['price'] = $productDetails->price;
                        $allCartDetails['cart'][$key]['product_image'] = $productDetails->product_image;
                        $allCartDetails['cart'][$key]['quantity'] = $cartDetails['quantity'];
                        $allCartDetails['cart'][$key]['total_price'] = $productDetails->price * $cartDetails['quantity'];
                        $totalPrice = $totalPrice + $allCartDetails['cart'][$key]['total_price'];
                        $allCartDetails['cart'][$key]['total_discounted_price'] = $productDetails->price * $cartDetails['quantity'];
                        $totalDiscountedPrice = $totalDiscountedPrice + $allCartDetails['cart'][$key]['total_discounted_price'];
                    }
                }
            }
            $allCartDetails['total_price'] = $totalPrice;
            $allCartDetails['total_discounted_price'] = $totalDiscountedPrice;
            $allCartDetails = json_decode(json_encode($allCartDetails));

            Session::put('cart', $sessionCart);
            Session::save();

            $cartTotalView = view('site.cart.ajax_cart_total', ['allCartDetails' => $allCartDetails])->render();
            $returnData['cartTotalView'] = $cartTotalView;
            $returnData['errorCode'] = "Success";
            $returnData['message'] = "Coupon code exist";
        }
        echo json_encode($returnData);
    }
    public function saveShippingMethod(Request $request)
    {
        $sessionCart = Session::get('cart');

        if (empty($request->shipping_method)) {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Please select shipping method";
        } else {
            $sessionCart['cartDetails']['shippingMethod']['shipping_method_id'] = $request->shipping_method;
            Session::put('cart', $sessionCart);
            Session::save();

            $returnData['errorCode'] = "Success";
            $returnData['message'] = "Coupon code exist";
        }
        echo json_encode($returnData);
    }
}
