<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\Slug;
// use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $returnData['mainHeader'] = "Contact Messages";
        $validation = Validator::make($request->all(), [
            'row' => 'required',
            'row_per_page' => 'required',
            'column_name' => 'required|max:500',
            'column_sort_order' => 'required',
            'search_value' => 'max:500'
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
            $returnData['contactMessages'] = (object)array();
            $returnData['totalContactMessages'] = 0;
        } else {
            $returnData['errorCode'] = "Success";

            $row = intval($request->input('row'));
            $rowPerPage = intval($request->input('row_per_page'));
            $columnName = $request->input('column_name');
            $columnSortOrder = $request->input('column_sort_order');
            $searchValue = $request->input('search_value');
            if ($searchValue != '') {
                $contactMessages = Contact::where([['title', 'LIKE', '%' . $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            } else {
                $contactMessages = Contact::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            }
            $totalContactMessages = Contact::count();
            $returnData['contactMessages'] = $contactMessages;
            $returnData['totalContactMessages'] = $totalContactMessages;

            $returnData['message'] = 'Contact Messages send successfully';
        }
        return response()->json($returnData);
    }


    public function details($id = '')
    {
        $mainHeader = "Contact Details";
        if ($id != '') {
            $contact = Contact::where([['contacts.id', '=', $id]])->first();
        } else {
            $contact = (object)array('id' => '', 'first_name' => '', 'last_name' => '', 'email' => '', 'phone_number' => '', 'message' => '', 'status' => '');
        }
        return view('admin.contacts.details', ['mainHeader' => $mainHeader, 'contact' => $contact]);
    }


    public function destroy(Request $request)
    {
        $deleteContacts = Contact::findOrFail($request->id);
        $return = $deleteContacts->delete();
        if ($return) {
            $returnData['errorCode'] = "Success";
            $returnData['message'] = 'Contacts deleted successfully';
        } else {
            $returnData['errorCode'] = "Error";
            $returnData['message'] = 'Unable to delete';
        }
        return response()->json($returnData);
    }


    public function ajaxTableData()
    {
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowPerPage = $_POST['length'];
        $columnIndex = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $searchValue = $_POST['search']['value'];

        if ($searchValue != '') {
            $contacts = Contact::where([['first_name', 'LIKE', '%' . $searchValue . '%'], ['last_name', 'LIKE', '%' . $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $contacts = Contact::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalContactsCount = Contact::count();

        $data = array();
        if (count($contacts) > 0) {
            foreach ($contacts as $contacts1) {
                $data[] = array(
                    "id" => $contacts1->id,
                    "first_name" => $contacts1->first_name,
                    "last_name" => $contacts1->last_name,
                    "email" => $contacts1->email,
                    "entry_date" => date('F d,Y', strtotime($contacts1->entry_date)),
                    "status" => $contacts1->status
                );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($contacts)),
            "iTotalDisplayRecords" => intval($totalContactsCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
