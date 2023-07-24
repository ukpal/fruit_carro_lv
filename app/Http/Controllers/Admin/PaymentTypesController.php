<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentType;
use Validator;
use Session;
use Image;
use Carbon\Carbon;

class PaymentTypesController extends Controller {
    public function index() {
        $mainHeader = "Payment Types" ;
        return view('admin.payment_types.index', ['mainHeader' => $mainHeader]);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit Payment Type" : "Add Payment Type";
        if($id != '') {
            $paymentType = PaymentType::find($id);
        } else {
            $paymentType = (object)array('id'=>'','title'=>'','status'=>'');
        }
        return view('admin.payment_types.edit', ['mainHeader' => $mainHeader,'paymentType' => $paymentType]);
    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'title' => 'required|max:500'
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
            if($request->get('id') != '') {
                $paymentType = PaymentType::find($request->get('id'));
                $paymentType->title =  $request->get('title');
                $paymentType->status = $request->get('status');
                $return = $paymentType->save();
                $returnId = $paymentType->id;
            } else {
                $paymentType = new PaymentType;
                $paymentType->title =  $request->get('title');
                $paymentType->status = $request->get('status');
                $return = $paymentType->save();
                $returnId = $paymentType->id;
            }
            if($return) {
                
                $returnData['errorCode'] = "Success";
                    $returnData['message'] = 'Payment Type saved successfully';
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Unable to save details';
            }
        }
        return response()->json($returnData);
    }
    public function destroy($id) {
        $deletePaymentType = PaymentType::findOrFail($id);
        $return = $deletePaymentType->delete();
        if($return) {
            Session::put('successMsg', 'Payment Type deleted successfully');
            Session::save();
            return redirect('/admin/payment-types');
        } else {
            Session::put('errorMsg', 'Unable to delete');
            Session::save();
            return back();
        }
    }
    public function ajaxTableData() {
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowPerPage = $_POST['length'];
        $columnIndex = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $searchValue = $_POST['search']['value'];

        if($searchValue != '') {
            $paymentTypes = PaymentType::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $paymentTypes = PaymentType::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalPaymentTypesCount = PaymentType::count();

        $data = array();
        if(count($paymentTypes) > 0) {
            foreach($paymentTypes as $paymentTypes1) {
                $data[] = array( 
                    "id" => $paymentTypes1->id,
                    "title" => $paymentTypes1->title,
                    "status" => $paymentTypes1->status
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($paymentTypes)),
            "iTotalDisplayRecords" => intval($totalPaymentTypesCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
