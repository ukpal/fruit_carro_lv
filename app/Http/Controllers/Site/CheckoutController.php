<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\PaymentType;
use App\OrderStatus;
use App\Models\Country;
use App\Models\State;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderAddress;
use App\Models\User;
use App\Models\CouponCode;
use App\Models\CouponCodeProduct;
use App\Models\CouponCodeUser;
use Validator;
use Session;
use DB;
use Hash;
use Carbon\Carbon;

class CheckoutController extends Controller {
    public function index(Request $request) {
        $mainHeader = "Checkout" ;
        // $sessionCart = Session::get('cart');
        $paymentTypes = PaymentType::where([['status', '=' ,'Active']])->get();
        // $orderStatuses = OrderStatus::where([['status', '=' ,'Active']])->get();
        $countryDetails = Country::all();
        
        $shippingStates = (object)array();
        $billingStates = (object)array();
        $shippingDetails = (object)array();
        $billingDetails = (object)array();

        // $user = Auth::user();
        if(isset($request->user_id)) {
            $userDetails = User::find($request->user_id);
            $shippingDetails = OrderAddress::where([['user_id', '=' ,$request->user_id],['address_type', '=' ,"Shipping"]])->first();
            $billingDetails = OrderAddress::where([['user_id', '=' ,$request->user_id],['address_type', '=' ,"Billing"]])->first();
            if(isset($shippingDetails) && $shippingDetails->country != '') {
                $shippingStates = State::where([['country_id', '=' ,$shippingDetails->country]])->get();
            }
            if(isset($billingDetails) && $billingDetails->country != '') {
                $billingStates = State::where([['country_id', '=' ,$billingDetails->country]])->get();
            }
        } else {
            $userDetails = (object)array();
        }

        $returnData=[
            'mainHeader' => $mainHeader,
            // 'sessionCart' => $sessionCart,
            'paymentTypes' => $paymentTypes, 
            // 'orderStatuses' => $orderStatuses,
            'countryDetails' => $countryDetails,
            'shippingStates' => $shippingStates,
            'billingStates' => $billingStates,
            'userDetails' => $userDetails,
            'shippingDetails' => $shippingDetails,
            'billingDetails' => $billingDetails];

        return response()->json($returnData);
    }
    public function checkLogin(Request $request) {
        $validation = Validator::make($request->all(),[
            'login_email' => 'required|max:500',
            'login_password' => 'required|max:255',
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage.$error.'\n';
                }
            }
            Session::put('errorMsg', $errorMessage);
            Session::save();
            return back();
        } else {
            $email    = $request->input('login_email');
            $password = $request->input('login_password');
            if (Auth::attempt(['email'=>$email, 'password' =>$password,'user_type' => 'User'])) {
                Auth::login(Auth::user(), true);
                return redirect('checkout');
            } else {
                if (Auth::attempt(['username'=>$email, 'password' =>$password,'user_type' => 'User'])) {
                    Auth::login(Auth::user(), true);
                    return redirect('checkout');
                } else {
                    Session::put('errorMsg', 'Invalid email/username and password');
                    Session::save();
                    return back();
                }
            }
        }
    }
    public function saveCheckout(Request $request) {
        $validation = Validator::make($request->all(),[
            'shipping_full_name' => 'required',
            'shipping_email_address' => 'required',
            'shipping_contact_number' => 'required',
            'shipping_address_line_1' => 'required',
            'shipping_zip_code' => 'required',
            'shipping_country' => 'required',
            'shipping_state' => 'required',
            // 'shipping_city' => 'required',
            'billing_full_name' => 'required',
            'billing_email_address' => 'required',
            'billing_contact_number' => 'required',
            'billing_address_line_1' => 'required',
            'billing_zip_code' => 'required',
            'billing_country' => 'required',
            'billing_state' => 'required',
            // 'billing_city' => 'required'
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
            $sessionCart = json_decode(json_encode($request->cartDetails));
            if(isset($sessionCart['productDetails']) && $sessionCart['cartCount'] > 0) {
                $shippingMethodId = $sessionCart['cartDetails']['shippingMethod']['shipping_method_id'];
                $user = Auth::user();
                if(isset($user)) {
                    $userId = $user->id;
                } else {
                    $userId = '';
                }

                $order = new Order;
                $orderNumber = uniqid();
                $order->order_number =  $orderNumber;
                $order->user_id =  $userId;
                $order->order_date = date("Y-m-d H:i:s");
                $order->payment_type_id = $request->get('payment_type');
                $order->order_status_id = 1;
                $order->shipping_method_id = $shippingMethodId;
                $return = $order->save();
                $returnId = $order->id;

                $shippingAddressId = '';
                $billingAddressId = '';
                $orderShippingId = 0;
                $orderBillingId = 0;
                if($return) {
                    if($userId != '') {
                        $shippingAddress = OrderAddress::where([['user_id', '=' ,$userId],['address_type', '=' ,"Shipping"]])->first();
                        if(isset($shippingAddress) && $shippingAddress->id != '') {
                            $shippingAddressId = $shippingAddress->id;
                        }
                        $billingAddress = OrderAddress::where([['user_id', '=' ,$userId],['address_type', '=' ,"Billing"]])->first();
                        if(isset($billingAddress) && $billingAddress->id != '') {
                            $billingAddressId = $billingAddress->id;
                        }
                    }

                    if($shippingAddressId != '') {
                        $orderShippingAddress = OrderAddress::find($shippingAddressId);
                        $orderShippingAddress->full_name =  $request->get('shipping_full_name');
                        $orderShippingAddress->email_address =  $request->get('shipping_email_address');
                        $orderShippingAddress->contact_number = $request->get('shipping_contact_number');
                        $orderShippingAddress->address_line_1 = $request->get('shipping_address_line_1');
                        $orderShippingAddress->address_line_2 =  $request->get('shipping_address_line_2');
                        $orderShippingAddress->zip_code =  $request->get('shipping_zip_code');
                        $orderShippingAddress->country = $request->get('shipping_country');
                        $orderShippingAddress->state = $request->get('shipping_state');
                        $orderShippingAddress->city =  $request->get('shipping_city');
                        $orderShippingAddress->save();
                        $orderShippingId = $orderShippingAddress->id;
                    } else {
                        $orderShippingAddress = new OrderAddress;
                        $orderShippingAddress->user_id = $userId;
                        $orderShippingAddress->full_name =  $request->get('shipping_full_name');
                        $orderShippingAddress->email_address =  $request->get('shipping_email_address');
                        $orderShippingAddress->contact_number = $request->get('shipping_contact_number');
                        $orderShippingAddress->address_line_1 = $request->get('shipping_address_line_1');
                        $orderShippingAddress->address_line_2 =  $request->get('shipping_address_line_2');
                        $orderShippingAddress->zip_code =  $request->get('shipping_zip_code');
                        $orderShippingAddress->country = $request->get('shipping_country');
                        $orderShippingAddress->state = $request->get('shipping_state');
                        $orderShippingAddress->city =  $request->get('shipping_city');
                        $orderShippingAddress->address_type =  "Shipping";
                        $orderShippingAddress->status =  "Active";
                        $orderShippingAddress->save();
                        $orderShippingId = $orderShippingAddress->id;
                    }

                    if($billingAddressId != '') {
                        $orderBillingAddress = OrderAddress::find($billingAddressId);
                        $orderBillingAddress->full_name =  $request->get('billing_full_name');
                        $orderBillingAddress->email_address =  $request->get('billing_email_address');
                        $orderBillingAddress->contact_number = $request->get('billing_contact_number');
                        $orderBillingAddress->address_line_1 = $request->get('billing_address_line_1');
                        $orderBillingAddress->address_line_2 =  $request->get('billing_address_line_2');
                        $orderBillingAddress->zip_code =  $request->get('billing_zip_code');
                        $orderBillingAddress->country = $request->get('billing_country');
                        $orderBillingAddress->state = $request->get('billing_state');
                        $orderBillingAddress->city =  $request->get('billing_city');
                        $orderBillingAddress->save();
                        $orderBillingId = $orderBillingAddress->id;
                    } else {
                        $orderBillingAddress = new OrderAddress;
                        $orderBillingAddress->user_id = $userId;
                        $orderBillingAddress->full_name =  $request->get('billing_full_name');
                        $orderBillingAddress->email_address = $request->get('billing_email_address');
                        $orderBillingAddress->contact_number = $request->get('billing_contact_number');
                        $orderBillingAddress->address_line_1 =  $request->get('billing_address_line_1');
                        $orderBillingAddress->address_line_2 = $request->get('billing_address_line_2');
                        $orderBillingAddress->zip_code = $request->get('billing_zip_code');
                        $orderBillingAddress->country =  $request->get('billing_country');
                        $orderBillingAddress->state =  $request->get('billing_state');
                        $orderBillingAddress->city = $request->get('billing_city');
                        $orderBillingAddress->address_type =  "Billing";
                        $orderBillingAddress->status =  "Active";
                        $orderBillingAddress->save();
                        $orderBillingId = $orderBillingAddress->id;
                    }                

                    if(isset($sessionCart['cartDetails'])) {
                        $totalPrice = 0;
                        $totalDiscountedPrice = 0;
                        $couponCodeId = 0;
                        $couponCode = '';
                        $discount = 0;
                        $discountType = '';
                        $productActive = 'N'; 
                        $userActive = 'N';

                        if(isset($sessionCart['cartDetails']['couponDetails']['coupon_id'])) {
                            $couponCodeDetails = CouponCode::where([['id', '=', $sessionCart['cartDetails']['couponDetails']['coupon_id']]])->first();
                            if(isset($couponCodeDetails)) {
                                $couponCodeId = $couponCodeDetails->id;
                                $couponCode = $couponCodeDetails->coupon_code;
                                $discount = $couponCodeDetails->discount;
                                $discountType = $couponCodeDetails->discount_type;

                                if($couponCodeDetails->products == 'Selected') {
                                    $couponCodeProductDetails = CouponCodeProduct::where([['coupon_code_id', '=' ,$couponCodeDetails->id]])->get();
                                    if(count($couponCodeProductDetails) > 0) {
                                        foreach($couponCodeProductDetails as $couponCodeProductDetails1) {
                                            if(isset($sessionCart['cartDetails'][$couponCodeProductDetails1->product_id])) {
                                                $productActive = 'Y';
                                            }
                                        }
                                    }
                                } else {
                                    $productActive = 'Y';
                                }
                                if($couponCodeDetails->users == 'Selected') {
                                    $userDetails = Auth::user();
                                    if(isset($userDetails)) {
                                        $couponCodeUserCount = CouponCodeUser::where([['coupon_code_id', '=' ,$couponCodeDetails->id],['user_id', '=' ,$userDetails->id]])->count();
                                        if($couponCodeUserCount > 0) {
                                            $userActive = 'Y';
                                        }
                                    }
                                } else {
                                    $userActive = 'Y';
                                }
                            }
                        }
                        if($productActive == 'Y' && $userActive == 'Y') {
                            if(isset($sessionCart['cartDetails'])) {
                                foreach($sessionCart['cartDetails'] as $key=>$cartDetails) {
                                    $productDetails = Product::where([['products.status','=','Active'],['products.id','=',$key]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
                                    if(isset($productDetails)) {
                                        $price = $productDetails->price;
                                        if($couponCodeDetails->products == 'Selected') {
                                            $productCouponCodeCount = CouponCodeProduct::where([['coupon_code_id', '=' ,$couponCodeDetails->id],['product_id', '=' ,$productDetails->id]])->count();
                                            if($productCouponCodeCount > 0) {
                                                if($couponCodeDetails->discount != '') {
                                                    if($couponCodeDetails->discount_type == 'Fixed') {
                                                        if($price > $couponCodeDetails->discount) {
                                                            $price = $price - $couponCodeDetails->discount;
                                                        } else {
                                                            $price = 0;
                                                        }
                                                    } else if($couponCodeDetails->discount_type == 'Percent') {
                                                        $price = $price - (($price/100)*$couponCodeDetails->discount);
                                                    }
                                                }
                                            }
                                        }

                                        $orderDetails = new OrderDetail;
                                        $orderDetails->order_id =  $returnId;
                                        $orderDetails->product_id =  $productDetails->id;
                                        $orderDetails->quantity =  $cartDetails['quantity'];
                                        $orderDetails->price = $productDetails->price;
                                        $orderDetails->total_price = $productDetails->price * $cartDetails['quantity'];
                                        $totalPrice = $totalPrice + ($productDetails->price * $cartDetails['quantity']);
                                        $totalDiscountedPrice = $totalDiscountedPrice + ($price * $cartDetails['quantity']);
                                        $orderDetails->save();
                                    }
                                }
                            }
                
                            if($couponCodeDetails->products == 'All') {
                                if($couponCodeDetails->discount != '') {
                                    if($couponCodeDetails->discount_type == 'Fixed') {
                                        if($totalPrice > $couponCodeDetails->discount) {
                                            $totalDiscountedPrice = $totalPrice - $couponCodeDetails->discount;
                                        } else {
                                            $totalDiscountedPrice = 0;
                                        }
                                    } else if($couponCodeDetails->discount_type == 'Percent') {
                                        $totalDiscountedPrice = $totalPrice - (($totalPrice/100)*$couponCodeDetails->discount);
                                    }
                                }
                            }
                        } else {
                            if(isset($sessionCart['cartDetails'])) {
                                foreach($sessionCart['cartDetails'] as $key=>$cartDetails) {
                                    $productDetails = Product::where([['products.status','=','Active'],['products.id','=',$key]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
                                    if(isset($productDetails)) {
                                        $orderDetails = new OrderDetail;
                                        $orderDetails->order_id =  $returnId;
                                        $orderDetails->product_id =  $productDetails->id;
                                        $orderDetails->quantity =  $cartDetails['quantity'];
                                        $orderDetails->price = $productDetails->price;
                                        $orderDetails->total_price = $productDetails->price * $cartDetails['quantity'];
                                        $totalPrice = $totalPrice + ($productDetails->price * $cartDetails['quantity']);
                                        $totalDiscountedPrice = $totalDiscountedPrice + ($productDetails->price * $cartDetails['quantity']);
                                        $orderDetails->save();
                                    }
                                }
                            }
                        }

                        $order = Order::find($returnId);
                        $order->total_price =  $totalPrice;
                        $order->shipping_address_id =  $orderShippingId;
                        $order->billing_address_id = $orderBillingId;
                        $order->total_discounted_price = $totalDiscountedPrice;
                        $order->coupon_code_id = $couponCodeId;
                        $order->coupon_code = $couponCode;
                        $order->discount = $discount;
                        $order->discount_type = $discountType;
                        $order->save();
                    }
                    
                    Session::forget('cart');
                    Session::save();
                    Session::put('successMsg', "Order Placed successfully.");
                    Session::save();
                    return redirect('checkout/order-details/'.$orderNumber);
                } else {
                    Session::put('errorMsg', "Error in order placing");
                    Session::save();
                    return back();
                }
            } else {
                Session::put('errorMsg', "Your cart is empty");
                Session::save();
                return back();
            } 
        }
        return response()->json($returnData);
    }
    public function getStates(Request $request) {
        $validation = Validator::make($request->all(),[
            'country_id' => 'required'
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
            $states = State::where([['country_id', '=' ,$request->country_id]])->get();
            // $getStates = view('site.checkout.ajax_get_states',['states' => $states])->render();     
            $returnData['errorCode'] = "Success";
            $returnData['getStates'] = $states;
            $returnData['message'] = "State details showing successfully.";
        }
        echo json_encode($returnData);
        
    }
    public function saveUser(Request $request) {
        $validation = Validator::make($request->all(),[
            'signup_first_name' => 'required|max:500',
            'signup_last_name' => 'required|max:500',
            'signup_username' => 'required|max:255',
            'signup_email' => 'required|max:500',
            'signup_password' => 'required|max:255'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage.$error.'\n';
                }
            }
            Session::put('errorMsg', $errorMessage);
            Session::save();
            return back();
        } else {
            $userCheckCount = User::where([['username', '=', $request->get('signup_username')],['status', '=', 'Active']])->count();
            if($userCheckCount > 0) {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Username is already exist";
            } else {
                $userCheckCount = User::where([['email', '=', $request->get('signup_email')],['status', '=', 'Active']])->count();
                if($userCheckCount > 0) {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = "Email is already exist";
                } else {
                    $user = new User;
                    $user->first_name =  $request->get('signup_first_name');
                    $user->last_name =  $request->get('signup_last_name');
                    $user->username = $request->get('signup_username');
                    $user->email = $request->get('signup_email');
                    $user->password = Hash::make($request->get('signup_password'));
                    $user->register_time = date("Y-m-d H:i:s");
                    $user->user_type = "User";
                    $user->status = "Active";
                    $return = $user->save();
                    $returnId = $user->id;

                    if($return) {
                        if (Auth::attempt(['username'=>$request->get('signup_username'), 'password' =>$request->get('signup_password'),'user_type' => 'User'])) {
                            Auth::login(Auth::user(), true);
                            Session::put('successMsg', "You have been logged in successfully with your provided registration details.");
                            Session::save();
                            return redirect('checkout');
                        } else {
                            Session::put('errorMsg', "Error Occurs.");
                            Session::save();
                            return redirect('checkout');
                        }
                    } else {
                        Session::put('errorMsg', "Error in registration");
                        Session::save();
                        return back();
                    }
                }
            }
        }
    }
    public function signOut() {
        $user = Auth::user();
        if($user) {
            Auth::logout();
        }
        return redirect('/checkout');
    }
    public function orderDetails($id) {
        $mainHeader = "Order Details" ;
        $order = Order::where([['orders.order_number', '=' , $id]])->select('payment_types.title AS payment_type_title','payment_types.id','order_statuses.title AS order_status_title','order_statuses.id','orders.*')->leftJoin('payment_types', [['payment_types.id', '=', 'orders.payment_type_id']])->leftJoin('order_statuses', [['order_statuses.id', '=', 'orders.order_status_id']])->first();

        $shippingCountry = '';
        $shippingState = '';
        $billingCountry = '';
        $billingState = '';
        $shippingDetails = (object)array();
        $billingDetails = (object)array();
        if($order->shipping_address_id != '') {
            $shippingDetails = OrderAddress::where([['id', '=' ,$order->shipping_address_id]])->first();
            if($shippingDetails->country != '') {
                $countryDetails = Country::where([['id', '=' ,$shippingDetails->country]])->first();
                $shippingCountry = $countryDetails->name;
            }
            if($shippingDetails->state != '') {
                $stateDetails = State::where([['id', '=' ,$shippingDetails->state]])->first();
                $shippingState = $stateDetails->name;
            }
        }
        if($order->billing_address_id != '') {
            $billingDetails = OrderAddress::where([['id', '=' ,$order->billing_address_id]])->first();
            if($billingDetails->country != '') {
                $countryDetails = Country::where([['id', '=' ,$billingDetails->country]])->first();
                $billingCountry = $countryDetails->name;
            }
            if($billingDetails->state != '') {
                $stateDetails = State::where([['id', '=' ,$billingDetails->state]])->first();
                $billingState = $stateDetails->name;
            }
        }

        $orderDetails = OrderDetail::where([['order_details.order_id', '=' , $order->id]])->select('slugs.slug','slugs.slug_type','products.title','products.price','products.id','order_details.*')->leftJoin('products', [['order_details.product_id', '=', 'products.id']])->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->get();

        return view('site.checkout.order_details', ['mainHeader' => $mainHeader,'order' => $order,'shippingDetails' => $shippingDetails,'billingDetails' => $billingDetails,'orderDetails' => $orderDetails,'shippingCountry' => $shippingCountry,'shippingState' => $shippingState,'billingCountry' => $billingCountry,'billingState' => $billingState ]);
    }
}
