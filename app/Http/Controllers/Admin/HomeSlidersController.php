<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\HomeSlider;
use App\Models\Slug;
use App\Models\User;
use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;

class HomeSlidersController extends Controller
{
    public function index(Request $request)
    {
        $mainHeader = "Home Sliders";
        $returnData['mainHeader'] = $mainHeader;
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/home_sliders/thumb/';
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
            $returnData['homeSliders'] = (object)array();
            $returnData['totalHomeSlidersCount'] = 0;
        } else {
            $returnData['errorCode'] = "Success";

            $row = intval($request->input('row'));
            $rowPerPage = intval($request->input('row_per_page'));
            $columnName = $request->input('column_name');
            $columnSortOrder = $request->input('column_sort_order');
            $searchValue = $request->input('search_value');
            if ($searchValue != '') {
                $homeSliders = HomeSlider::where([['title', 'LIKE', '%' . $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            } else {
                $homeSliders = HomeSlider::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            }
            $totalHomeSlidersCount = HomeSlider::count();
            $returnData['homeSliders'] = $homeSliders;
            $returnData['totalHomeSlidersCount'] = $totalHomeSlidersCount;

            $returnData['message'] = 'Home Slider page details send successfully';
        }
        return response()->json($returnData);
    }

    public function list()
    {
        $returnData['mainHeader'] = "Home Sliders";
        $returnData['errorCode'] = "Success";
        $totalHomeSlidersCount = HomeSlider::count();
        $returnData['homeSliders'] = HomeSlider::all();
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/home_sliders/thumb/';
        $returnData['totalHomeSlidersCount'] = $totalHomeSlidersCount;
        $returnData['message'] = 'Home Slider page details send successfully';
        return response()->json($returnData);
    }


    public function edit(Request $request)
    {
        $mainHeader = ($request->input('id') != '') ? "Edit Home Slider" : "Add Home Slider";
        if ($request->input('id') != '') {
            $homeSlider = HomeSlider::find($request->get('id'));
        } else {
            $homeSlider = (object)array('id' => '', 'title' => '', 'image' => '', 'content' => '', 'status' => '');
        }
        $returnData['homeSlider'] = $homeSlider;
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/home_sliders/thumb/';
        $returnData['errorCode'] = "Success";
        $returnData['mainHeader'] = $mainHeader;
        $returnData['message'] = 'Home Slider page details send successfully';

        return response()->json($returnData);
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required'
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
            if ($request->get('id') != '') {
                $homeSlider = HomeSlider::find($request->get('id'));
                $homeSlider->title =  $request->get('title');
                $homeSlider->content =  htmlentities($request->get('content'));
                $homeSlider->status = $request->get('status');
                $return = $homeSlider->save();
                $returnId = $homeSlider->_id;
            } else {
                $homeSlider = new HomeSlider;
                $homeSlider->title =  $request->get('title');
                $homeSlider->content =  htmlentities($request->get('content'));
                $homeSlider->image =  '';
                $homeSlider->entry_date = date("Y-m-d H:i:s");
                $homeSlider->status = $request->get('status');
                $return = $homeSlider->save();
                $returnId = $homeSlider->_id;
            }

            if ($return) {
                if ($request->get('id') != '') {
                    $homeSliderDetails = HomeSlider::find($request->get('id'));
                }
                $homeSliderImageName = '';
                $image = $request->file('image');
                if (isset($image)) {
                    $fileName = $image->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/home_sliders/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($image->getRealPath())->resize(150, 150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/home_sliders/thumb/' . $fileName);
                        $image->move('public/uploads/home_sliders/normal/', $fileName);
                        $homeSliderImageName = $fileName;
                        if ($request->get('id') != '') {
                            if ($homeSliderDetails->image != '') {
                                $delete_image_normal = 'public/uploads/home_sliders/normal/' . $homeSliderDetails->image;
                                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                $delete_image_thumb = 'public/uploads/home_sliders/thumb/' . $homeSliderDetails->image;
                                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                            }
                        }
                    }
                } else {
                    if ($request->get('id') != '') {
                        $homeSliderImageName = $homeSliderDetails->image;
                    }
                }

                $homeSlider = HomeSlider::find($returnId);
                $homeSlider->image = $homeSliderImageName;
                $return = $homeSlider->save();

                if ($return) {
                    $returnData['errorCode'] = "Success";
                    $returnData['message'] = 'Home Slider details saved successfully';
                } else {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = 'Unable to save details';
                }
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Unable to save details';
            }
        }
        // return response($returnData)->json()->header('X-Total-Count', count($homeSlider));
        return response()->json($returnData);
    }


    public function destroy(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required'
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
            $homeSliderDetails = HomeSlider::find($request->get('id'));
            if ($homeSliderDetails->blog_image != '') {
                $delete_image_normal = public_path('uploads/home_sliders/normal/') . $homeSliderDetails->blog_image;
                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                $delete_image_thumb = public_path('uploads/home_sliders/thumb/') . $homeSliderDetails->blog_image;
                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
            }
            $deleteHomeSliders = HomeSlider::findOrFail($request->get('id'));
            $return = $deleteHomeSliders->delete();
            if ($return) {
                $returnData['errorCode'] = "Success";
                $returnData['message'] = 'Home Slider deleted successfully';
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Unable to save details';
            }
        }
        return response()->json($returnData);
    }

    public function getSlider(Request $request){
        $validation = Validator::make($request->all(), [
            'id' => 'required'
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
            // $homeSliderDetails = HomeSlider::find($request->get('id'));
            
            $HomeSliders = HomeSlider::findOrFail($request->get('id'));
            if ($HomeSliders) {
                $returnData['errorCode'] = "Success";
                $returnData['message'] = 'Home Slider fetched successfully';
                $returnData['slider'] = $HomeSliders;
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Unable to find details';
            }
            $returnData['storage_path'] = env('APP_URL').'/public/uploads/home_sliders/thumb/';
        }
        return response()->json($returnData);
    }
}
