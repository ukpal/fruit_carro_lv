<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderDetail;
use App\OrderAddress;
use App\Product;
use App\PaymentType;
use App\OrderStatus;
use App\Country;
use App\State;
use App\Slug;
use Validator;
use Session;
use DB;
use Hash;
use Carbon\Carbon;

class OrdersController extends Controller {
    public function index() {
        $mainHeader = "Orders" ;
        return view('site.orders.index', ['mainHeader' => $mainHeader]);
    }
    public function details($id='') {
        $userId = Auth::user()->id;

        $mainHeader = "Order Details";
        if($id != '') {
            $order = Order::where([['orders.order_number', '=' , $id],['orders.user_id', '=' , $userId]])->select('payment_types.title AS payment_type_title','payment_types.id','order_statuses.title AS order_status_title','order_statuses.id','orders.*')->leftJoin('payment_types', [['payment_types.id', '=', 'orders.payment_type_id']])->leftJoin('order_statuses', [['order_statuses.id', '=', 'orders.order_status_id']])->first();

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
        } else {
            $order = (object)array();
            $orderDetails = (object)array();
        }

        return view('site.orders.details', ['mainHeader' => $mainHeader,'order' => $order,'shippingDetails' => $shippingDetails,'billingDetails' => $billingDetails,'orderDetails' => $orderDetails,'shippingCountry' => $shippingCountry,'shippingState' => $shippingState,'billingCountry' => $billingCountry,'billingState' => $billingState ]);
    }
    public function ajaxTableData() {
        $id = Auth::user()->id;

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowPerPage = $_POST['length'];
        $columnIndex = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $searchValue = $_POST['search']['value'];

        if($searchValue != '') {
            $orders = Order::where([['orders.user_id', '=' , $id],['order_addresses.full_name', 'LIKE' , '%'. $searchValue . '%']])->orWhere([['order_addresses.email_address', 'LIKE' , '%'. $searchValue . '%']])->orWhere([['order_addresses.contact_number', 'LIKE' , '%'. $searchValue . '%']])->orWhere([['orders.order_number', 'LIKE' , '%'. $searchValue . '%']])->select('order_addresses.full_name','order_addresses.email_address','order_addresses.contact_number','orders.*')->leftJoin('order_addresses', [['order_addresses.id', '=', 'orders.shipping_address_id']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $orders = Order::where([['orders.user_id', '=' , $id]])->select('order_addresses.full_name','order_addresses.email_address','order_addresses.contact_number','orders.*')->leftJoin('order_addresses', [['order_addresses.id', '=', 'orders.shipping_address_id']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalOrdersCount = Order::count();

        $data = array();
        if(count($orders) > 0) {
            foreach($orders as $orders1) {
                $data[] = array( 
                    "order_number" => $orders1->order_number,
                    "full_name" => $orders1->full_name,
                    "email_address" => $orders1->email_address,
                    "contact_number" => $orders1->contact_number,
                    "total_price" => $orders1->total_price
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($orders)),
            "iTotalDisplayRecords" => intval($totalOrdersCount),
            "data" => $data
        );

        echo json_encode($response);
    }
    public function destroy($id) {
        $userId = Auth::user()->id;
        $order = Order::where([['order_number', '=' ,$id],['user_id', '=' ,$userId]])->first();
        if(isset($order) && $order->id != '') {
            $deleteOrder = Order::findOrFail($order->id);
            $return = $deleteOrder->delete();
            if($return) {
                $orderDetail = OrderDetail::where([['order_id', '=' ,$order->id]])->delete();
                Session::put('successMsg', 'Order deleted successfully');
                Session::save();
                return redirect('/orders');
            } else {
                Session::put('errorMsg', 'Unable to delete');
                Session::save();
                return back();
            }
        } else {
            Session::put('errorMsg', 'Unable to delete');
            Session::save();
            return back();
        }
    }
}
