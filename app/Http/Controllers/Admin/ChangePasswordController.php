<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Session;
use Image;
use Hash;

class ChangePasswordController extends Controller {
    public function index() {
        $mainHeader = "Change Password" ;
        return view('admin.change_password.index', ['mainHeader' => $mainHeader]);
    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'old_password' => 'required|max:500',
            'new_password' => 'required|max:500',
            'retype_password' => 'required|max:500|required_with:new_password|same:new_password'
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
            $id = Auth::user()->id;
            $user = User::find($id);
            if(!Hash::check($request->get('old_password'), $user->password)) {
                Session::put('errorMsg', 'Old password doesnot match');
                Session::save();
                return back();
            } else {
                $user->password = Hash::make($request->get('new_password'));
                $return = $user->save();
                if($return) {
                    Session::put('successMsg', 'Password changed successfully');
                    Session::save();
                    return redirect('/admin/change-password');
                } else {
                    Session::put('errorMsg', 'Unable to save details');
                    Session::save();
                    return back();
                }
            }
        }
    }
}