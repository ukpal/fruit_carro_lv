<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $returnData['mainHeader'] = "Profile";
        // $id = Auth::user()->id;
        // $userDetails = User::find($id);
        $userDetails = $request->user();
        if ($userDetails) {
            $returnData['errorCode'] = "Success";
            $returnData['message'] = "Profile Details Send Successfully";
            $returnData['userDetails'] = $userDetails;
        } else {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = "Profile Details Send Failed";
        }
        return response()->json($returnData);
    }
    public function edit()
    {
        $mainHeader = "Edit Profile";
        $id = Auth::user()->id;
        $userDetails = User::find($id);
        return view('admin.profile.edit', ['mainHeader' => $mainHeader, 'userDetails' => $userDetails]);
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|max:500',
            'last_name' => 'required|max:500',
            'email' => 'required|max:500',
            'username' => 'required|max:500'
        ]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage . $error . '\n';
                }
            }
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errorMessage;
        } else {
            $id = $request->user()->id;
            $userCheck = DB::table('users');
            $userCheck->where('email', '=', $request->get('email'));
            $userCheck->where('id', '!=', $id);
            $userCheckCount = $userCheck->count();
            if ($userCheckCount > 0) {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Email is already exist';
            } else {
                $userCheck = DB::table('users');
                $userCheck->where('username', '=', $request->get('username'));
                $userCheck->where('id', '!=', $id);
                $userCheckCount = $userCheck->count();
                if ($userCheckCount > 0) {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = 'Username is already exist';
                } else {
                    $profile = User::find($id);
                    $profile->first_name =  $request->get('first_name');
                    $profile->last_name =  $request->get('last_name');
                    $profile->email = $request->get('email');
                    $profile->username = $request->get('username');
                    $return = $profile->save();
                    $returnId = $id;

                    if ($return) {
                        if ($id != '') {
                            $userDetails = User::find($id);
                        }

                        $profileImageName = '';
                        $profile_image = $request->file('profile_image');
                        if (isset($profile_image)) {
                            $fileName = $profile_image->getClientOriginalName();
                            $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                            $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                            $originalName = $actualName;
                            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                            if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                                $i = 1;
                                while (file_exists(public_path('uploads/profile_images/normal/') . $actualName . "." . $extension)) {
                                    $actualName = (string)$originalName . '-' . $i;
                                    $fileName = $actualName . "." . $extension;
                                    $i++;
                                }
                                $thumbImage = Image::make($profile_image->getRealPath())->resize(150, 150, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                                $thumbImage->save(public_path('uploads/profile_images/thumb/') . $fileName);
                                $profile_image->move(public_path('uploads/profile_images/normal'), $fileName);
                                $profileImageName = $fileName;
                                if ($id != '') {
                                    if ($userDetails->profile_image != '') {
                                        $delete_image_normal = public_path('uploads/profile_images/normal/') . $userDetails->profile_image;
                                        if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                        $delete_image_thumb = public_path('uploads/profile_images/thumb/') . $userDetails->profile_image;
                                        if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                                    }
                                }
                            }
                        } else {
                            if ($id != '') {
                                $profileImageName = $userDetails->profile_image;
                            }
                        }

                        $profile = User::find($returnId);
                        $profile->profile_image = $profileImageName;
                        $return = $profile->save();

                        if ($return) {
                            $returnData['errorCode'] = "Success";
                            $returnData['message'] = 'Profile details saved successfully';
                        } else {
                            $returnData['errorCode'] = "Error";
                            $returnData['message'] = 'Unable to save details';
                        }
                    } else {
                        $returnData['errorCode'] = "Error";
                        $returnData['message'] = 'Unable to save details';
                    }
                }
            }
        }
        return response()->json($returnData);
    }
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            Auth::logout();
        }
        return redirect('/admin/login');
    }
}
