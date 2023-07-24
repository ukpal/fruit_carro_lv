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

class LoginController extends Controller {
    public function authenticated(Request $request) {
        $validation = Validator::make($request->all(),[
            'login_username_email' => 'required|max:500',
            'login_password' => 'required|max:500',
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
            $email    = $request->input('login_username_email');
            $password = $request->input('login_password');
            $userDetails = User::where([['email', '=', $email],['status', '=', 'Active']])->first();
            if(isset($userDetails) && $userDetails->id != '') {
                if(!Hash::check($password,$userDetails->password)) {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = 'Invalid email/username and password';
                } else {
                    $returnData['errorCode'] = "Success";
                    $returnData['userId'] = $userDetails->id;
                    $returnData['message'] = 'You logged in successfully';
                }
            } else {
                $userDetails = User::where([['username', '=', $email],['status', '=', 'Active']])->first();
                if(isset($userDetails) && $userDetails->id != '') {
                    if(!Hash::check($password,$userDetails->password)) {
                        $returnData['errorCode'] = "Error";
                        $returnData['message'] = 'Invalid email/username and password';
                    } else {
                        $returnData['errorCode'] = "Success";
                        $returnData['userId'] = $userDetails->id;
                        $returnData['message'] = 'You logged in successfully';
                    }
                } else {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = 'Invalid email/username and password';
                }
            }
        }
        return response()->json($returnData);
    }
}
