<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Session;

class DashboardController extends Controller {
    public function index(Request $request) {
        $mainHeader = "Dashboard" ;
        $userDetails = User::find($request->input('id'));
        $returnData['errorCode'] = "Success";
        $returnData['mainHeader'] = $mainHeader;
        $returnData['userDetails'] = $userDetails;
        $returnData['message'] = 'Dashboard page details send successfully';
        return response()->json($returnData);
    }
}
