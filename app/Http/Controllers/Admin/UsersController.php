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
use Carbon\Carbon;

class UsersController extends Controller {
    public function index() {
        $mainHeader = "Users" ;
        return view('admin.users.index', ['mainHeader' => $mainHeader]);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit User" : "Add User";
        if($id != '') {
            $user = User::find($id);
        } else {
            $user = (object)array('id'=>'','user_full_name'=>'','user_type' => '','user_image'=>'','content'=>'','status'=>'');
        }
        return view('admin.users.edit', ['mainHeader' => $mainHeader,'user' => $user]);
    }
    public function checkUsername(Request $request) {
        $validation = Validator::make($request->all(),[
            'username' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $return = "false";
        } else {
            if($request->get('id') != '') {
                $userCheckCount = User::where([['username', '=', $request->get('username')],['id', '!=', $request->get('id')]])->count();
            } else {
                $userCheckCount = User::where([['username', '=', $request->get('username')]])->count();
            }
            $return = ($userCheckCount > 0) ? "false" : "true";
        }
        echo $return;
        die();
    }
    public function checkEmail(Request $request) {
        $validation = Validator::make($request->all(),[
            'email' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $return = "false";
        } else {
            if($request->get('id') != '') {
                $userCheckCount = User::where([['email', '=', $request->get('email')],['id', '!=', $request->get('id')]])->count();
            } else {
                $userCheckCount = User::where([['email', '=', $request->get('email')]])->count();
            }
            $return = ($userCheckCount > 0) ? "false" : "true";
        }
        echo $return;
        die();
    }
    public function store(Request $request) {
        if($request->get('id') != '') {
            $validation = Validator::make($request->all(),[
                'user_type' => 'in:Landlord,Tenant',
                'first_name' => 'required|max:500',
                'last_name' => 'required|max:500',
                'email' => 'required|max:500',
                'username' => 'required|max:255'
            ]);
        } else {
            $validation = Validator::make($request->all(),[
                'user_type' => 'in:Landlord,Tenant',
                'first_name' => 'required|max:500',
                'last_name' => 'required|max:500',
                'email' => 'required|max:500',
                'username' => 'required|max:255',
                'password' => 'required|max:255'
            ]);
        }
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
            if($request->get('id') != '') {
                $userDetails = User::find($request->get('id'));
            }
            if($request->get('id') != '') {
                $userCheckCount = User::where([['email', '=', $request->get('email')],['email', '!=', $userDetails->email]])->count();
                if($userCheckCount > 0) {
                    Session::put('errorMsg', 'Email is already exist');
                    Session::save();
                    return back();
                } else {
                    $userCheckCount = User::where([['username', '=', $request->get('username')],['username', '!=', $userDetails->username]])->count();
                    if($userCheckCount > 0) {
                        Session::put('errorMsg', 'Username is already exist');
                        Session::save();
                        return back();
                    } else {
                        $password = ($request->get('password') != '') ? Hash::make($request->get('password')) : $userDetails->password;
                        $user = User::find($request->get('id'));
                        $user->user_type =  $request->get('user_type');
                        $user->first_name =  $request->get('first_name');
                        $user->last_name =  $request->get('last_name');
                        $user->profile_image =  '';
                        $user->email =  $request->get('email');
                        $user->username =  $request->get('username');
                        $user->phone_number =  $request->get('phone_number');
                        $user->password =  $password;
                        $user->status = $request->get('status');
                        $return = $user->save();
                        $returnId = $user->id;
                    }
                }
            } else {
                $userCheckCount = User::where([['email', '=', $request->get('email')]])->count();
                if($userCheckCount > 0) {
                    Session::put('errorMsg', 'Email is already exist');
                    Session::save();
                    return back();
                } else {
                    $userCheckCount = User::where([['username', '=', $request->get('username')]])->count();
                    if($userCheckCount > 0) {
                        Session::put('errorMsg', 'Username is already exist');
                        Session::save();
                        return back();
                    } else {
                        $user = new User;
                        $user->user_type =  $request->get('user_type');
                        $user->first_name =  $request->get('first_name');
                        $user->last_name =  $request->get('last_name');
                        $user->profile_image =  '';
                        $user->email =  $request->get('email');
                        $user->username =  $request->get('username');
                        $user->phone_number =  $request->get('phone_number');
                        $user->password =  Hash::make($request->get('password'));
                        $user->register_time = date("Y-m-d H:i:s");
                        $user->status = $request->get('status');
                        $return = $user->save();
                        $returnId = $user->id;
                    }
                }
            }
            if($return) {
                $userImageName = '';
                $profile_image = $request->file('profile_image');
                if(isset($profile_image)) {
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
                        $thumbImage = Image::make($profile_image->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save(public_path('uploads/profile_images/thumb/').$fileName);
                        $profile_image->move(public_path('uploads/profile_images/normal'), $fileName);
                        $userImageName = $fileName;
                        if($request->get('id') != '') {
                            if($userDetails->profile_image != '') {
                                $delete_image_normal = public_path('uploads/profile_images/normal/').$userDetails->profile_image;
                                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                $delete_image_thumb = public_path('uploads/profile_images/thumb/').$userDetails->profile_image;
                                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                            }
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $userImageName = $userDetails->profile_image;
                    }
                }

                $user = User::find($returnId);
                $user->profile_image = $userImageName;
                $return = $user->save();
                
                if($return) {
                    Session::put('successMsg', 'User details saved successfully');
                    Session::save();
                    return redirect('/admin/users');
                } else {
                    Session::put('errorMsg', 'Unable to save details');
                    Session::save();
                    return back();
                }
            } else {
                Session::put('errorMsg', 'Unable to save details');
                Session::save();
                return back();
            }
        }
    }
    public function destroy($id) {
        $userDetails = User::find($id);
        if($userDetails->profile_image != '') {
            $delete_image_normal = public_path('uploads/users/normal/').$userDetails->profile_image;
            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
            $delete_image_thumb = public_path('uploads/users/thumb/').$userDetails->profile_image;
            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
        }
        $deleteUsers = User::findOrFail($id);
        $return = $deleteUsers->delete();
        if($return) {
            Session::put('successMsg', 'User deleted successfully');
            Session::save();
            return redirect('/admin/users');
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
            $users = User::where([['user_type', '!=' , 'Admin'],['first_name', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $users = User::where([['user_type', '!=' , 'Admin']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalUsersCount = User::count();

        $data = array();
        if(count($users) > 0) {
            foreach($users as $users1) {
                $data[] = array( 
                    "id" => $users1->id,
                    "first_name" => $users1->first_name,
                    "last_name" => $users1->last_name,
                    "email" => $users1->email,
                    "username" => $users1->username,
                    "user_type" => $users1->user_type,
                    "status" => $users1->status
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($users)),
            "iTotalDisplayRecords" => intval($totalUsersCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
