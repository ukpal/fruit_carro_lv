<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use Validator;
use Session;
use Image;
use Carbon\Carbon;

class TestimonialsController extends Controller {
    public function index() {
        $mainHeader = "Testimonials" ;
        return view('admin.testimonials.index', ['mainHeader' => $mainHeader]);
    }
    public function edit($id='') {
        $mainHeader = ($id != '') ? "Edit Testimonial" : "Add Testimonial";
        if($id != '') {
            $testimonial = Testimonial::find($id);
        } else {
            $testimonial = (object)array('id'=>'','user_full_name'=>'','user_image'=>'','content'=>'','status'=>'');
        }
        return view('admin.testimonials.edit', ['mainHeader' => $mainHeader,'testimonial' => $testimonial]);
    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'user_full_name' => 'required|max:500'
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
                $testimonial = Testimonial::find($request->get('id'));
                $testimonial->user_full_name =  $request->get('user_full_name');
                $testimonial->content =  htmlentities($request->get('content'));
                $testimonial->status = $request->get('status');
                $return = $testimonial->save();
                $returnId = $testimonial->id;
            } else {
                $testimonial = new Testimonial;
                $testimonial->user_full_name =  $request->get('user_full_name');
                $testimonial->content =  htmlentities($request->get('content'));
                $testimonial->user_image =  '';
                $testimonial->entry_date = date("Y-m-d H:i:s");
                $testimonial->status = $request->get('status');
                $return = $testimonial->save();
                $returnId = $testimonial->id;
            }
            if($return) {
                if($request->get('id') != '') {
                    $testimonialDetails = Testimonial::find($request->get('id'));
                }

                $testimonialImageName = '';
                $user_image = $request->file('user_image');
                if(isset($user_image)) {
                    $fileName = $user_image->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists(public_path('uploads/testimonials/normal/') . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($user_image->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save(public_path('uploads/testimonials/thumb/').$fileName);
                        $user_image->move(public_path('uploads/testimonials/normal'), $fileName);
                        $testimonialImageName = $fileName;
                        if($request->get('id') != '') {
                            if($testimonialDetails->user_image != '') {
                                $delete_image_normal = public_path('uploads/testimonials/normal/').$testimonialDetails->user_image;
                                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                $delete_image_thumb = public_path('uploads/testimonials/thumb/').$testimonialDetails->user_image;
                                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                            }
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $testimonialImageName = $testimonialDetails->user_image;
                    }
                }

                $testimonial = Testimonial::find($returnId);
                $testimonial->user_image = $testimonialImageName;
                $return = $testimonial->save();
                
                if($return) {
                    Session::put('successMsg', 'Testimonial details saved successfully');
                    Session::save();
                    return redirect('/admin/testimonials');
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
        $testimonialDetails = Testimonial::find($id);
        if($testimonialDetails->user_image != '') {
            $delete_image_normal = public_path('uploads/testimonials/normal/').$testimonialDetails->user_image;
            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
            $delete_image_thumb = public_path('uploads/testimonials/thumb/').$testimonialDetails->user_image;
            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
        }
        $deleteTestimonials = Testimonial::findOrFail($id);
        $return = $deleteTestimonials->delete();
        if($return) {
            Session::put('successMsg', 'Testimonial deleted successfully');
            Session::save();
            return redirect('/admin/testimonials');
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
            $testimonials = Testimonial::where([['user_full_name', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        } else {
            $testimonials = Testimonial::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
        }

        $totalTestimonialsCount = Testimonial::count();

        $data = array();
        if(count($testimonials) > 0) {
            foreach($testimonials as $testimonials1) {
                $data[] = array( 
                    "id" => $testimonials1->id,
                    "user_full_name" => $testimonials1->user_full_name,
                    "entry_date" => date('F d,Y', strtotime($testimonials1->entry_date)),
                    "status" => $testimonials1->status
                 );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval(count($testimonials)),
            "iTotalDisplayRecords" => intval($totalTestimonialsCount),
            "data" => $data
        );

        echo json_encode($response);
    }
}
