<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Slug;
use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;

class BlogsController extends Controller {
    public function index() {
        $mainHeader = "Blogs" ;
        return view('admin.blogs.index', ['mainHeader' => $mainHeader]);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit Blog" : "Add Blog";
        if($id != '') {
            $blog = Blog::where([['blogs.id', '=' ,$id]])->select('slugs.slug','slugs.slug_type','blogs.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'blogs.id'],['slugs.slug_type', '=', DB::raw("'Blogs'")]])->first();
        } else {
            $blog = (object)array('id'=>'','title'=>'','blog_image'=>'','short_content'=>'','long_content'=>'','status'=>'');
        }
        return view('admin.blogs.edit', ['mainHeader' => $mainHeader,'blog' => $blog]);
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
                $blog = Blog::find($request->get('id'));
                $blog->title =  $request->get('title');
                $blog->short_content =  htmlentities($request->get('short_content'));
                $blog->long_content =  htmlentities($request->get('long_content'));
                $blog->status = $request->get('status');
                $return = $blog->save();
                $returnId = $blog->id;
            } else {
                $blog = new Blog;
                $blog->title =  $request->get('title');
                $blog->creater_id =  Auth::user()->id;
                $blog->short_content =  htmlentities($request->get('short_content'));
                $blog->long_content =  htmlentities($request->get('long_content'));
                $blog->blog_image =  '';
                $blog->entry_date = date("Y-m-d H:i:s");
                $blog->status = $request->get('status');
                $return = $blog->save();
                $returnId = $blog->id;
            }
            if($return) {
                $slugDetails = Slug::where([['parent_id', '=' ,$returnId],['slug_type','=','Blogs']])->first();
                if(isset($slugDetails)) {
                    $slug = Slug::find($slugDetails->id);
                    $slug->slug =  $request->get('slug');
                    $slug->save();
                } else {
                    $slug = new Slug;
                    $slug->slug =  $request->get('slug');
                    $slug->parent_id =  $returnId;
                    $slug->slug_type =  'Blogs';
                    $slug->save();
                }

                if($request->get('id') != '') {
                    $blogDetails = Blog::find($request->get('id'));
                }

                $blogImageName = '';
                $blog_image = $request->file('blog_image');
                if(isset($blog_image)) {
                    $fileName = $blog_image->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists(public_path('uploads/blogs/normal/') . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($blog_image->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save(public_path('uploads/blogs/thumb/').$fileName);
                        $blog_image->move(public_path('uploads/blogs/normal'), $fileName);
                        $blogImageName = $fileName;
                        if($request->get('id') != '') {
                            if($blogDetails->blog_image != '') {
                                $delete_image_normal = public_path('uploads/blogs/normal/').$blogDetails->blog_image;
                                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                $delete_image_thumb = public_path('uploads/blogs/thumb/').$blogDetails->blog_image;
                                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                            }
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $blogImageName = $blogDetails->blog_image;
                    }
                }

                $blog = Blog::find($returnId);
                $blog->blog_image = $blogImageName;
                $return = $blog->save();
                
                if($return) {
                    Session::put('successMsg', 'Blog details saved successfully');
                    Session::save();
                    return redirect('/admin/blogs');
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
        $blogDetails = Blog::find($id);
        if($blogDetails->blog_image != '') {
            $delete_image_normal = public_path('uploads/blogs/normal/').$blogDetails->blog_image;
            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
            $delete_image_thumb = public_path('uploads/blogs/thumb/').$blogDetails->blog_image;
            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
        }
        $deleteBlogs = Blog::findOrFail($id);
        $return = $deleteBlogs->delete();
        if($return) {
            $slugDetails = Slug::where([['parent_id', '=' ,$id],['slug_type','=','Blogs']])->first();
            if(isset($slugDetails)) {
                $deleteSlug = Slug::findOrFail($slugDetails->id);
                $deleteSlug->delete();
            }
            Session::put('successMsg', 'Blog deleted successfully');
            Session::save();
            return redirect('/admin/blogs');
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
            $slugs = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','Blogs']])->first();
            if(isset($slugs) && $slugs->slug == $slugTitle) {
                $slugCount = Slug::where([['slug', '=' ,$slugTitle],['parent_id', '!=' ,$request->get('id')]])->count();
                if($slugCount > 0) {
                    $allData = array();
                    $allData['id'] = $request->get('id');
                    $allData['slug'] = $slugTitle;
                    $allData['slug_type'] = 'Blogs';
                    $slugTitle = Slug::getSlug($allData);
                }
            } else {
                $allData = array();
                $allData['id'] = $request->get('id');
                $allData['slug'] = $slugTitle;
                $allData['slug_type'] = 'Blogs';
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
            $allData['slug_type'] = 'Blogs';
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
            $blogs = Blog::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $blogs = Blog::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalBlogsCount = Blog::count();

        $data = array();
        if(count($blogs) > 0) {
            foreach($blogs as $blogs1) {
                $data[] = array( 
                    "id" => $blogs1->id,
                    "title" => $blogs1->title,
                    "entry_date" => date('F d,Y', strtotime($blogs1->entry_date)),
                    "status" => $blogs1->status
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($blogs)),
            "iTotalDisplayRecords" => intval($totalBlogsCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
