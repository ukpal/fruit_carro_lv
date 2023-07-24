<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Session;
use DB;
use Hash;
use Carbon\Carbon;

class SignUpController extends Controller {
    public function checkUsername(Request $request) {
        $validation = Validator::make($request->all(),[
            'signup_username' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = 'Please provide valid username';
        } else {
            $userCheckCount = User::where([['username', '=', $request->get('signup_username')]])->count();
            if($userCheckCount > 0) {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Username is already exist';
            } else {
                $returnData['errorCode'] = "Success";
                $returnData['message'] = 'Username is available'; 
            }
        }
        return response()->json($returnData);
    }
    public function checkEmail(Request $request) {
        $validation = Validator::make($request->all(),[
            'signup_email' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = 'Please provide valid email';
        } else {
            $userCheckCount = User::where([['email', '=', $request->get('signup_email')]])->count();
            if($userCheckCount > 0) {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Email is already exist';
            } else {
                $returnData['errorCode'] = "Success";
                $returnData['message'] = 'Email is available';
            }
        }
        return response()->json($returnData);
    }
    public function saveUser(Request $request) {
        $validation = Validator::make($request->all(),[
            'signup_first_name' => 'required|max:500',
            'signup_last_name' => 'required|max:500',
            'signup_username' => 'required|max:500',
            'signup_email' => 'required|max:500',
            'signup_password' => 'required|max:255',
            'signup_retype_password' => 'required|max:255'
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
            $userCheckCount = User::where([['username', '=', $request->get('signup_username')]])->count();
            if($userCheckCount > 0) {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = "Username is already exist";
            } else {
                $userCheckCount = User::where([['email', '=', $request->get('signup_email')]])->count();
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
                    $user->user_type = 'User';
                    $user->status = 'Active';
                    $return = $user->save();

                    if($return) {
                        if($return) {
                            $returnData['errorCode'] = "Success";
                            $returnData['message'] = "You have been registered successfully.";
                        } else {
                            $returnData['errorCode'] = "Error";
                            $returnData['message'] = "Error in registration";
                        }
                    } else {
                        $returnData['errorCode'] = "Error";
                        $returnData['message'] = "Unable to save details";
                    }
                }
            }
        }
        return response()->json($returnData);
    }
}
