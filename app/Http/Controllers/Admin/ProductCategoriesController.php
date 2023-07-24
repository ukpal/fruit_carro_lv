<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductCategory;
use App\Models\Slug;
use Validator;
use Session;
use Image;
use DB;
use Carbon\Carbon;

class ProductCategoriesController extends Controller {
    public function index(Request $request) {
        $mainHeader = "Product Categories" ;
        $returnData['mainHeader'] = $mainHeader;
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/product_categories/thumb/';
        $validation = Validator::make($request->all(),[
            'row' => 'required',
            'row_per_page' => 'required',
            'column_name' => 'required|max:500',
            'column_sort_order' => 'required',
            'search_value' => 'max:500'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage.$error.'\n';
                }
            }
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errorMessage;
            $returnData['productCategories'] = (object)array();
            $returnData['totalProductCategoriesCount'] = 0;
        } else {
            $returnData['errorCode'] = "Success";

            $row = intval($request->input('row'));
            $rowPerPage = intval($request->input('row_per_page'));
            $columnName = $request->input('column_name');
            $columnSortOrder = $request->input('column_sort_order');
            $searchValue = $request->input('search_value');
            if($searchValue != '') {
                $productCategories = ProductCategory::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            } else {
                $productCategories = ProductCategory::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            }
            $totalProductCategoriesCount = ProductCategory::count();
            $returnData['productCategories'] = $productCategories;
            $returnData['totalProductCategoriesCount'] = $totalProductCategoriesCount; 

            $returnData['message'] = 'Product category page details send successfully';
        }
        return response()->json($returnData);
    }

    public function list(Request $request)
    {
        $returnData['mainHeader'] = "Product Categories";
        $returnData['errorCode'] = "Success";
        $returnData['productCategories'] = ProductCategory::select($request->input('column'))->get();
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/product_categories/thumb/';
        // $returnData['storage_path'] = public_path('uploads/product_categories/thumb/');
        $returnData['totalCategoryCount'] = ProductCategory::count();
        $returnData['message'] = 'Product category page details send successfully';
        return response()->json($returnData);
    }

    
    public function edit(Request $request) {
        $mainHeader = ($request->input('id') != '') ? "Edit Product Category" : "Add Product Category";
        if($request->input('id') != '') {
            // $productCategory = ProductCategory::where([['product_categories.id', '=' ,$request->input('id')]])->select('slugs.slug','slugs.slug_type','product_categories.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'product_categories.id'],['slugs.slug_type', '=', DB::raw("'ProductCategories'")]])->first();
            $productCategory = ProductCategory::with('slug')->where([['_id','=',$request->id]])->first();
        } else {
            $productCategory = (object)array('id'=>'','title'=>'','product_category_image'=>'','description'=>'','status'=>'');
        }
        $returnData['productCategory'] = $productCategory;
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/product_categories/thumb/';
        $returnData['errorCode'] = "Success";
        $returnData['mainHeader'] = $mainHeader;
        $returnData['message'] = 'Product Category page details send successfully';

        return response()->json($returnData);
    }


    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'user_id' => 'required',
            'title' => 'required|max:500',
            'slug' => 'required|max:500'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage.$error.'\n';
                }
            }
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errorMessage;
        } else {
            if($request->get('id') != '') {
                $productCategory = ProductCategory::find($request->get('id'));
                $productCategory->title =  $request->get('title');
                $productCategory->description = htmlentities($request->get('description'));
                $productCategory->status = $request->get('status');
                $return = $productCategory->save();
                $returnId = $productCategory->id;
            } else {
                $productCategory = new ProductCategory;
                $productCategory->title =  $request->get('title');
                $productCategory->creater_id =  $request->get('user_id');
                $productCategory->description = htmlentities($request->get('description'));
                $productCategory->status = $request->get('status');
                $return = $productCategory->save();
                $returnId = $productCategory->id;
            }
            if($return) {
                $slugDetails = Slug::where([['parent_id', '=' ,$returnId],['slug_type','=','ProductCategories']])->first();
                if(isset($slugDetails)) {
                    $slug = Slug::find($slugDetails->id);
                    $slug->slug =  $request->get('slug');
                    $slug->save();
                } else {
                    $slug = new Slug;
                    $slug->slug =  $request->get('slug');
                    $slug->parent_id =  $returnId;
                    $slug->slug_type =  'ProductCategories';
                    $slug->save();
                }

                if($request->get('id') != '') {
                    $productCategoryDetails = ProductCategory::find($request->get('id'));
                }

                $productCategoryImageName = '';
                $product_category_image = $request->file('product_category_image');
                if(isset($product_category_image)) {
                    $fileName = $product_category_image->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/product_categories/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($product_category_image->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/product_categories/thumb/'.$fileName);
                        $product_category_image->move('public/uploads/product_categories/normal/', $fileName);
                        $productCategoryImageName = $fileName;
                        if($request->get('id') != '') {
                            if($productCategoryDetails->product_category_image != '') {
                                $delete_image_normal = 'public/uploads/product_categories/normal/'.$productCategoryDetails->product_category_image;
                                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                $delete_image_thumb = 'public/uploads/product_categories/thumb/'.$productCategoryDetails->product_category_image;
                                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                            }
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $productCategoryImageName = $productCategoryDetails->product_category_image;
                    }
                }

                $productCategory = ProductCategory::find($returnId);
                $productCategory->product_category_image = $productCategoryImageName;
                $return = $productCategory->save();
                
                if($return) {
                    $returnData['errorCode'] = "Success";
                    $returnData['message'] = 'Product category details saved successfully';
                } else {
                    $returnData['errorCode'] = "Error";
                    $returnData['message'] = 'Unable to save details';
                }
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Unable to save details';
            }
        }
        return response()->json($returnData);
    }


    public function destroy(Request $request) {
        $validation = Validator::make($request->all(),[
            'id' => 'required'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            $errorMessage = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $errorMessage = $errorMessage.$error.'\n';
                }
            }
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errorMessage;
        } else {
            $productCategoryDetails = ProductCategory::find($request->get('id'));
            if($productCategoryDetails->product_category_image != '') {
                $delete_image_normal = public_path('uploads/product_categories/normal/').$productCategoryDetails->product_category_image;
                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                $delete_image_thumb = public_path('uploads/product_categories/thumb/').$productCategoryDetails->product_category_image;
                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
            }
            $deleteProductCategories = ProductCategory::findOrFail($request->get('id'));
            $return = $deleteProductCategories->delete();
            if($return) {
                $slugDetails = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','ProductCategories']])->first();
                if(isset($slugDetails)) {
                    $deleteSlug = Slug::findOrFail($slugDetails->id);
                    $deleteSlug->delete();
                }
                $returnData['errorCode'] = "Success";
                $returnData['message'] = 'Product category deleted successfully';
            } else {
                $returnData['errorCode'] = "Error";
                $returnData['message'] = 'Unable to delete';
            }
        }
        return response()->json($returnData);
    }


    public function getSlugUrl(Request $request) {
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
            $returnData['errorCode'] = "Error";
            $returnData['message'] = $errorMessage;
        } else {
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
                $slugs = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','ProductCategories']])->first();
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
                    $allData['slug_type'] = 'ProductCategories';
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
                $allData['slug_type'] = 'ProductCategories';
                $slugTitle = Slug::getSlug($allData);
            }
            $returnData['errorCode'] = "Success";
            $returnData['slugTitle'] = $slugTitle;
            $returnData['message'] = 'Slug Url send successfully';
        }
        return response()->json($returnData);
    }
}
