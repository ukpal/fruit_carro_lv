<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SiteSetting;
use Session;
use Mail;
use Validator;

class ForgotPasswordController extends Controller {
    public function index() {
        $mainHeader = "Forgot Password" ;
        $siteSettings = SiteSetting::first();
        return view('admin.forgot_password.index', ['mainHeader' => $mainHeader,'siteSettings' => $siteSettings]);
    }
    public function checkEmail(Request $request) {
        $validation = Validator::make($request->all(),[
            'forgot_password_email' => 'required|max:500'
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
            $checkEmail = User::where([['email', '=' ,$request->get('forgot_password_email')]])->orWhere([['username', '=' ,$request->get('forgot_password_email')]])->first();
            if(isset($checkEmail)) {
                $verificationCode = uniqid();
                $user = User::find($checkEmail->id);
                $user->verification_code = $verificationCode;
                $return = $user->save();
                if($return) {
                    $siteSettings = SiteSetting::first();
                    $userFullName = $checkEmail->first_name.' '.$checkEmail->last_name;
                    $userEmail = $checkEmail->email;
                    $forgotPasswordLink = url('/admin/forgot-password/verify/').'/'.$verificationCode;
                    $message = "Hello ".$userFullName.",<br/>Click the below link to reset password.<br/>Link is : <a href='".$forgotPasswordLink."'>".$forgotPasswordLink."</a>";
                    $data = array('name'=> $userFullName);
                    $mailContent = array();
                    $mailContent['userFullName'] = $userFullName;
                    $mailingAddress = $siteSettings->mailing_address;
                    $siteName = $siteSettings->site_name;
                    $returnMail = Mail::send('mails.forgot_password', $data, function($message) use($userEmail,$userFullName,$mailingAddress,$siteName) {
                        $message->to($userEmail, $userFullName)->subject($message);
                        $message->from($mailingAddress,$siteName);
                    });
                    if($returnMail) {
                        Session::put('successMsg', 'Reset password link has been sent to you email id.');
                        Session::save();
                        return redirect('/admin/forgot-password');
                    } else {
                        Session::put('errorMsg', 'Unable to send mail. Please contact administrator.');
                        Session::save();
                        return back();
                    }
                } else {
                    Session::put('errorMsg', 'Error occurs');
                    Session::save();
                    return back();
                }
            } else {
                Session::put('errorMsg', 'Email/Username doesnot exist');
                Session::save();
                return back();
            }
        }
    }
}
