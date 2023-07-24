<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use App\Models\Slug;
use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;

class PagesController extends Controller {
    public function index() {
        $mainHeader = "Pages" ;
        return view('admin.pages.index', ['mainHeader' => $mainHeader]);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit Page" : "Add Page";
        if($id != '') {
            $page = Page::where([['pages.id', '=' ,$id]])->select('slugs.slug','slugs.slug_type','pages.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'pages.id'],['slugs.slug_type', '=', DB::raw("'Pages'")]])->first();
        } else {
            $page = (object)array('id'=>'','title'=>'','content'=>'','status'=>'');
        }
        return view('admin.pages.edit', ['mainHeader' => $mainHeader,'page' => $page]);
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
                $page = Page::find($request->get('id'));
                $page->title =  $request->get('title');
                $page->content =  htmlentities($request->get('content'));
                $page->status = $request->get('status');
                $return = $page->save();
                $returnId = $page->id;
            } else {
                $page = new Page;
                $page->title =  $request->get('title');
                $page->content =  htmlentities($request->get('content'));
                $page->status = $request->get('status');
                $return = $page->save();
                $returnId = $page->id;
            }
            if($return) {
                $slugDetails = Slug::where([['parent_id', '=' ,$returnId],['slug_type','=','Pages']])->first();
                if(isset($slugDetails)) {
                    $slug = Slug::find($slugDetails->id);
                    $slug->slug =  $request->get('slug');
                    $slug->save();
                } else {
                    $slug = new Slug;
                    $slug->slug =  $request->get('slug');
                    $slug->parent_id =  $returnId;
                    $slug->slug_type =  'Pages';
                    $slug->save();
                }
                Session::put('successMsg', 'Page details saved successfully');
                Session::save();
                return redirect('/admin/pages');
            } else {
                Session::put('errorMsg', 'Unable to save details');
                Session::save();
                return back();
            }
        }
    }
    public function destroy($id) {
        $deletePages = Page::findOrFail($id);
        $return = $deletePages->delete();
        if($return) {
            $slugDetails = Slug::where([['parent_id', '=' ,$id],['slug_type','=','Pages']])->first();
            if(isset($slugDetails)) {
                $deleteSlug = Slug::findOrFail($slugDetails->id);
                $deleteSlug->delete();
            }
            Session::put('successMsg', 'Page deleted successfully');
            Session::save();
            return redirect('/admin/pages');
        } else {
            Session::put('errorMsg', 'Unable to delete');
            Session::save();
            return back();
        }
    }
    public function getSlugUrl(Request $request) {
        $slug = preg_replace('~[^\pL\d]+~u', '-', $request->get('title'));
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('~-+~', '-', $slug);
        $slug = strtolower($slug);

        $slugTitle = '';
        if($request->get('id') != '') {
            if($request->get('slug') != '') {
                if($request->get('slug') != $slug) {
                    $slug = preg_replace('~[^\pL\d]+~u', '-', $request->get('slug'));
                    $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
                    $slug = preg_replace('~[^-\w]+~', '', $slug);
                    $slug = trim($slug, '-');
                    $slug = preg_replace('~-+~', '-', $slug);
                    $slug = strtolower($slug);
                    $slugTitle = $slug;
                } else {
                    $slugTitle = $slug;
                }
            } else {
                $slugTitle = $slug;
            }
            $slugs = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','Pages']])->first();
            if(isset($slugs) && $slugs->slug == $slugTitle) {
                $slugCount = Slug::where([['slug', '=' ,$slugTitle],['parent_id', '!=' ,$request->get('id')]])->count();
                if($slugCount > 0) {
                    $allData = array();
                    $allData['id'] = $request->get('id');
                    $allData['slug'] = $slugTitle;
                    $allData['slug_type'] = 'Pages';
                    $slugTitle = Slug::getSlug($allData);
                }
            } else {
                $allData = array();
                $allData['id'] = $request->get('id');
                $allData['slug'] = $slugTitle;
                $allData['slug_type'] = 'Pages';
                $slugTitle = Slug::getSlug($allData);
            }
        } else {
            if($request->get('slug') != '') {
                if($request->get('slug') != $slug) {
                    $slug = preg_replace('~[^\pL\d]+~u', '-', $request->get('slug'));
                    $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
                    $slug = preg_replace('~[^-\w]+~', '', $slug);
                    $slug = trim($slug, '-');
                    $slug = preg_replace('~-+~', '-', $slug);
                    $slug = strtolower($slug);
                    $slugTitle = $slug;
                } else {
                    $slugTitle = $slug;
                }
            } else {
                $slugTitle = $slug;
            }
            $allData = array();
            $allData['id'] = $request->get('id');
            $allData['slug'] = $slugTitle;
            $allData['slug_type'] = 'Pages';
            $slugTitle = Slug::getSlug($allData);
        }
        echo $slugTitle;
        die();
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
            $pages = Page::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $pages = Page::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalPagesCount = Page::count();

        $data = array();
        if(count($pages) > 0) {
            foreach($pages as $pages1) {
                $data[] = array( 
                    "id" => $pages1->id,
                    "title" => $pages1->title,
                    "status" => $pages1->status
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($pages)),
            "iTotalDisplayRecords" => intval($totalPagesCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
