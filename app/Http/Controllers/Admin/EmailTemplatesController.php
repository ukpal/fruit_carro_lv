<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailTemplate;
use Validator;
use Session;
use Image;
use Carbon\Carbon;

class EmailTemplatesController extends Controller {
    public function index(Request $request) {
        $mainHeader = "Email Templates" ;

        $row = $request->get('row');
        $rowPerPage = $request->get('row_per_page');
        $columnName = $request->get('column_name');
        $columnSortOrder = $request->get('column_sort_order');
        $searchValue = $request->get('search_value');

        if($searchValue != '') {
            $emailTemplates = EmailTemplate::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $emailTemplates = EmailTemplate::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalEmailTemplatesCount = EmailTemplate::count();

        $returnData['errorCode'] = "Success";
        $returnData['mainHeader'] = $mainHeader;
        $returnData['message'] = 'Email Template page details send successfully';
        return response()->json($returnData);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit Email Template" : "Add Email Template";
        if($id != '') {
            $emailTemplate = EmailTemplate::find($id);
        } else {
            $emailTemplate = (object)array('id'=>'','title'=>'','content'=>'','status'=>'');
        }
        return view('admin.email_templates.edit', ['mainHeader' => $mainHeader,'emailTemplate' => $emailTemplate]);
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
            Session::put('errorMsg', $errorMessage);
            Session::save();
            return back();
        } else {
            if($request->get('id') != '') {
                $emailTemplate = EmailTemplate::find($request->get('id'));
                $emailTemplate->title =  $request->get('title');
                $emailTemplate->content = htmlentities($request->get('content'));
                $emailTemplate->status = $request->get('status');
                $return = $emailTemplate->save();
                $returnId = $emailTemplate->id;
            } else {
                $emailTemplate = new EmailTemplate;
                $emailTemplate->title =  $request->get('title');
                $emailTemplate->content = htmlentities($request->get('content'));
                $emailTemplate->status = $request->get('status');
                $return = $emailTemplate->save();
                $returnId = $emailTemplate->id;
            }
            if($return) {
                Session::put('successMsg', 'Email Template saved successfully');
                Session::save();
                return redirect('/admin/email-templates');
            } else {
                Session::put('errorMsg', 'Unable to save details');
                Session::save();
                return back();
            }
        }
    }
    public function destroy($id) {
        $deleteEmailTemplate = EmailTemplate::findOrFail($id);
        $return = $deleteEmailTemplate->delete();
        if($return) {
            Session::put('successMsg', 'Email Template deleted successfully');
            Session::save();
            return redirect('/admin/email-templates');
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
            $emailTemplates = EmailTemplate::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $emailTemplates = EmailTemplate::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalEmailTemplatesCount = EmailTemplate::count();

        $data = array();
        if(count($emailTemplates) > 0) {
            foreach($emailTemplates as $emailTemplates1) {
                $data[] = array( 
                    "id" => $emailTemplates1->id,
                    "title" => $emailTemplates1->title,
                    "status" => $emailTemplates1->status
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($emailTemplates)),
            "iTotalDisplayRecords" => intval($totalEmailTemplatesCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
