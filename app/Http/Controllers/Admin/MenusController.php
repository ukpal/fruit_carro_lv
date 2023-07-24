<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Slug;
use App\Models\Page;
use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;

class MenusController extends Controller {
    public function index() {
        $mainHeader = "Menus" ;
        $allMenus = $this->getAllMenus(0,0);
        return view('admin.menus.index', ['mainHeader' => $mainHeader,'allMenus' => $allMenus]);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit Menu" : "Add Menu";
        if($id != '') {
            $menu = Menu::where([['menus.id', '=' ,$id]])->select('slugs.slug','slugs.slug_type','menus.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'menus.id'],['slugs.slug_type', '=', DB::raw("'Menus'")]])->first();
        } else {
            $menu = (object)array('id'=>'','parent_id' => '','page_id'=>'','title'=>'','status'=>'');
        }
        $parentMenus = Menu::where([['parent_id', '=' ,0]])->select('*')->get();
        $pages = Page::where([['status', '=' ,'Active']])->select('*')->get();
        return view('admin.menus.edit', ['mainHeader' => $mainHeader,'menu' => $menu,'parentMenus' => $parentMenus,'pages' => $pages]);
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
                $menu = Menu::find($request->get('id'));
                $menu->title =  $request->get('title');
                $menu->parent_id =  ($request->get('parent_id') != '') ? $request->get('parent_id') : 0;
                $menu->page_id =  ($request->get('page_id') != '') ? $request->get('page_id') : 0;
                $menu->status = $request->get('status');
                $return = $menu->save();
                $returnId = $menu->id;
            } else {
                $menu = new Menu;
                $menu->title =  $request->get('title');
                $menu->parent_id =  ($request->get('parent_id') != '') ? $request->get('parent_id') : 0;
                $menu->page_id =  ($request->get('page_id') != '') ? $request->get('page_id') : 0;
                if($request->get('parent_id') != '') {
                    $menuDetails = Menu::where([['parent_id', '=' ,$request->get('parent_id')]])->selectRaw('MAX(ordering) AS max_ordering')->first();
                    if(isset($menuDetails)) {
                        $new_ordering = $menuDetails->max_ordering + 1;
                        $menu->ordering =  $new_ordering;
                    }
                } else {
                    $menu->ordering = 0;
                }
                $menu->status = $request->get('status');
                $return = $menu->save();
                $returnId = $menu->id;
            }
            if($return) {
                $slugDetails = Slug::where([['parent_id', '=' ,$returnId],['slug_type','=','Menus']])->first();
                if(isset($slugDetails)) {
                    $slug = Slug::find($slugDetails->id);
                    $slug->slug =  $request->get('slug');
                    $slug->save();
                } else {
                    $slug = new Slug;
                    $slug->slug =  $request->get('slug');
                    $slug->parent_id =  $returnId;
                    $slug->slug_type =  'Menus';
                    $slug->save();
                }
                Session::put('successMsg', 'Menu details saved successfully');
                Session::save();
                return redirect('/admin/menus');
            } else {
                Session::put('errorMsg', 'Unable to save details');
                Session::save();
                return back();
            }
        }
    }
    public function destroy($id) {
        $deleteMenus = Menu::findOrFail($id);
        $return = $deleteMenus->delete();
        if($return) {
            $menus = Menu::where([['parent_id', '=' ,$id]])->get();
            if(count($menus) > 0) {
                foreach($menus as $menus1) {
                    $menu = Menu::find($menus1->id);
                    $menu->parent_id =  0;
                    $menu->save();
                }
            }

            $slugDetails = Slug::where([['parent_id', '=' ,$id],['slug_type','=','Menus']])->first();
            if(isset($slugDetails)) {
                $deleteSlug = Slug::findOrFail($slugDetails->id);
                $deleteSlug->delete();
            }
            Session::put('successMsg', 'Menu deleted successfully');
            Session::save();
            return redirect('/admin/menus');
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
            $slugs = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','Menus']])->first();
            if(isset($slugs) && $slugs->slug == $slugTitle) {
                $slugCount = Slug::where([['slug', '=' ,$slugTitle],['parent_id', '!=' ,$request->get('id')]])->count();
                if($slugCount > 0) {
                    $allData = array();
                    $allData['id'] = $request->get('id');
                    $allData['slug'] = $slugTitle;
                    $allData['slug_type'] = 'Menus';
                    $slugTitle = Slug::getSlug($allData);
                }
            } else {
                $allData = array();
                $allData['id'] = $request->get('id');
                $allData['slug'] = $slugTitle;
                $allData['slug_type'] = 'Menus';
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
            $allData['slug_type'] = 'Menus';
            $slugTitle = Slug::getSlug($allData);
        }
        echo $slugTitle;
        die();
    }
    public function getAllMenus($parentId = 0, $level = 0) {
        $menus = Menu::where([['menus.parent_id', '=' ,$parentId]])->select('menus.*')->orderBy('ordering', 'ASC')->get();
        $allMenus = '';
        if(count($menus) > 0) {
            foreach($menus as $menus1) {
                $allMenus .= '<li class="dd-item" data-id="'.$menus1->id.'"><div class="dd-handle">'.$menus1->title.'</div> <div class="float-right"><a href="'.url('admin/menus/edit/'.$menus1->id).'"><span class="icon-edit dd-demo"></span></a><a href="javascript:void(0)" onclick="javascript:deleteData('.$menus1->id.');"><span class="icon-delete dd-demo1"></span></a></div>';
                $allMenus .= '<ol class="dd-list">';
                $allMenus .= $this->getAllMenus($menus1->id,$level + 1);
                $allMenus .= '</ol>';
                $allMenus .= '</li>';
            }
        }
        return $allMenus;
    }
    public function updateSerializeMenus(Request $request) {
        $arrayData = json_decode($request->get('serialize_data'));
        $this->sameMenus(0,$arrayData);
        $allMenus = $this->getAllMenus(0,0);
        return $allMenus;
    }
    public function sameMenus($parentId = 0,$arrayData = array()) {
        if(count($arrayData) > 0) {
            $i = 1;
            foreach($arrayData as $arrayData1) {
                $menu = Menu::find($arrayData1->id);
                $menu->ordering =  ($parentId == 0) ? 0 : $i;
                $menu->parent_id = $parentId;
                $menu->save();
                if(isset($arrayData1->children) && count($arrayData1->children) > 0) {
                    $this->sameMenus($arrayData1->id,$arrayData1->children);
                }
                $i++;
            }
        }
        return true;
    }
}
