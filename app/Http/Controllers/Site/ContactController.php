<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\SiteSetting;
use Validator;
use Session;
use DB;
use Carbon\Carbon;

class ContactController extends Controller {
    public function index() {
        $mainHeader = "Contact Us" ;
        $siteSettings = SiteSetting::first();
        return view('site.contact.index', ['mainHeader' => $mainHeader,'siteSettings' => $siteSettings]);
    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'full_name' => 'required|max:500',
            // 'last_name' => 'required|max:500',
            'email' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errors;
        } else {
            $contact = new Contact;
            $contact->full_name =  $request->get('full_name');
            // $contact->last_name =  $request->get('last_name');
            $contact->email = $request->get('email');
            $contact->phone_number = $request->get('phone_number');
            $contact->message = $request->get('message');
            // $contact->entry_date = date("Y-m-d H:i:s");
            $return = $contact->save();

            if($return) {
                if($return) {
                    $returnData['errorCode'] = "Success";
                    $returnData['message'] = "Contact details send to administrator";
                } else {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = "Unable to send email. Please contact administrator.";
                }
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Unable to save details";
            }
        }
        echo json_encode($returnData);
        die();
    }
}
