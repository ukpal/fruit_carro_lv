<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Slug;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use Validator;
use Session;
use Image;
use DB;
use URL;
use Carbon\Carbon;
session_start();

class ProductsController extends Controller {
    public function index(Request $request) {
        $mainHeader = "Products" ;
        $returnData['mainHeader'] = $mainHeader;
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/products/thumb/';
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
            $returnData['products'] = (object)array();
            $returnData['totalProductsCount'] = 0;
        } else {
            $returnData['errorCode'] = "Success";

            $row = intval($request->input('row'));
            $rowPerPage = intval($request->input('row_per_page'));
            $columnName = $request->input('column_name');
            $columnSortOrder = $request->input('column_sort_order');
            $searchValue = $request->input('search_value');
            if($searchValue != '') {
                $products = Product::where([['title', 'LIKE' , '%'. $searchValue . '%']])->orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            } else {
                $products = Product::orderBy($columnName, $columnSortOrder)->limit($rowPerPage)->offset($row)->get();
            }
            $totalProductsCount = Product::count();
            $returnData['products'] = $products;
            $returnData['totalProductsCount'] = $totalProductsCount; 

            $returnData['message'] = 'Product page details send successfully';
        }
        return response()->json($returnData);
    }

    public function list(Request $request)
    {
        $returnData['mainHeader'] = "Products";
        $returnData['errorCode'] = "Success";
        $returnData['products'] = Product::with('categories')->select($request->input('column'))->get();
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/products/thumb/';
        $returnData['totalProductCount'] = Product::count();
        $returnData['message'] = 'Product page details send successfully';
        return response()->json($returnData);
    }


    public function edit(Request $request) {
        // echo $request->id; die();
        $mainHeader = ($request->input('id') != '') ? "Edit Product" : "Add Product";

        if($request->input('id') != '') {
            // $product = Product::where([['products.id', '=' ,$request->input('id')]])->select('slugs.slug','slugs.slug_type','products.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'products.id'],['slugs.slug_type', '=', DB::raw("'Products'")]])->first();
            $product = Product::with('slug')->where([['_id','=',$request->id]])->first();
            $productGalleries = ProductGallery::where([['product_id', '=' ,$request->input('id')]])->get();
        } else {
            $product = (object)array('id'=>'','title'=>'','category_id'=>'','price'=>'','amount'=>'','short_description'=>'','long_description'=>'','product_image'=>'','feature_product'=>'No','status'=>'');
            $productGalleries = array();
        }
        $productCategories = ProductCategory::all(['id','title']);

        $returnData['product'] = $product;
        $returnData['productGalleries'] = $productGalleries;
        $returnData['productCategories'] = $productCategories;
        $returnData['storage_path'] = env('APP_URL').'/public/uploads/products/thumb/';
        $returnData['errorCode'] = "Success";
        $returnData['mainHeader'] = $mainHeader;
        $returnData['message'] = 'Product page details send successfully';

        return response()->json($returnData);
    }
    
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'slug' => 'required|max:500',
            'title' => 'required|max:500',
            'category_id' => 'required',
            'price' => 'required',
            'amount' => 'required'
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
                // echo 'hii'; die();
                $product = Product::find($request->get('id'));
                $product->title =  $request->get('title');
                $product->category_id =  $request->get('category_id');
                $product->price =  $request->get('price');
                $product->amount = $request->get('amount');
                $product->short_description = htmlentities($request->get('short_description'));
                $product->long_description = htmlentities($request->get('long_description'));
                // $product->feature_product = $request->get('feature_product');
                $product->status = $request->get('status');
                $return = $product->save();
                $returnId = $product->id;
            } else {
                // echo 'hii'; die();
                $product = new Product;
                $product->title =  $request->get('title');
                $product->creater_id =  $request->get('user_id');
                $product->category_id =  $request->get('category_id');
                $product->price =  $request->get('price');
                $product->amount =  $request->get('amount');
                $product->product_image =  '';
                $product->short_description =  htmlentities($request->get('short_description'));
                $product->long_description = htmlentities($request->get('long_description'));
                $product->feature_product = 'No';
                // $product->feature_product = $request->get('feature_product');
                $product->status = $request->get('status');
                $return = $product->save();
                $returnId = $product->id;
            }
            if($return) {
                $slugDetails = Slug::where([['parent_id', '=' ,$returnId],['slug_type','=','Products']])->first();
                if(isset($slugDetails)) {
                    $slug = Slug::find($slugDetails->id);
                    $slug->slug =  $request->get('slug');
                    $slug->save();
                } else {
                    $slug = new Slug;
                    $slug->slug =  $request->get('slug');
                    $slug->parent_id =  $returnId;
                    $slug->slug_type =  'Products';
                    $slug->save();
                }

                if($request->get('id') != '') {
                    $productDetails = Product::find($request->get('id'));
                }

                $productImageName = '';
                $productImage = $request->file('product_image');
                if(isset($productImage)) {
                    $fileName = $productImage->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/products/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($productImage->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/products/thumb/'.$fileName);
                        // $thumbImage->save(public_path('uploads/products/thumb/').$fileName);
                        $productImage->move('public/uploads/products/normal/', $fileName);
                        $productImageName = $fileName;
                        if($request->get('id') != '') {
                            if($productDetails->product_image != '') {
                                $delete_image_normal = 'public/uploads/products/normal/'.$productDetails->product_image;
                                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                                $delete_image_thumb = 'public/uploads/products/thumb/'.$productDetails->product_image;
                                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                            }
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $productImageName = $productDetails->product_image;
                    }
                }

                $product = Product::find($returnId);
                $product->product_image = $productImageName;
                $return = $product->save();

                /*if(isset($_SESSION['galleryFiles']) && count($_SESSION['galleryFiles']) > 0) {
                    foreach($_SESSION['galleryFiles'] as $fileName) {
                        if($fileName != '') {
                            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                            if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                                $productGallery = new ProductGallery;
                                $productGallery->product_id =  $returnId;
                                $productGallery->file_name =  $fileName;
                                $productGallery->file_type = 'Image';
                                $productGallery->save();
                            }
                        }
                    }
                    unset($_SESSION['galleryFiles']);
                }*/
                
                if($return) {
                    $returnData['errorCode'] = "Success";
                    $returnData['message'] = 'Product details saved successfully';
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
            $productDetails = Product::find($request->get('id'));
            if($productDetails->product_image != '') {
                $delete_image_normal = public_path('uploads/products/normal/').$productDetails->product_image;
                if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                $delete_image_thumb = public_path('uploads/products/thumb/').$productDetails->product_image;
                if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
            }
            $deleteProducts = Product::findOrFail($request->get('id'));
            $return = $deleteProducts->delete();
            if($return) {
                $productGalleries = ProductGallery::where([['product_id', '=' ,$request->get('id')]])->get();
                if(count($productGalleries) > 0) {
                    foreach($productGalleries as $productGalleries1) {
                        $extension = pathinfo($productGalleries1->file_name, PATHINFO_EXTENSION);
                        if($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                            $deleteImageNormal = public_path('uploads/products/normal/') . $productGalleries1->file_name;
                            $deleteImageThumb = public_path('uploads/products/thumb/') . $productGalleries1->file_name;
                            if (file_exists($deleteImageNormal)) unlink($deleteImageNormal);
                            if (file_exists($deleteImageThumb)) unlink($deleteImageThumb);

                            $deleteProductGallery = ProductGallery::findOrFail($productGalleries1->id);
                            $deleteProductGallery->delete();
                        }
                    }
                }

                $slugDetails = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','Products']])->first();
                if(isset($slugDetails)) {
                    $deleteSlug = Slug::findOrFail($slugDetails->id);
                    $deleteSlug->delete();
                }
                $returnData['errorCode'] = "Success";
                $returnData['message'] = 'Header Slider deleted successfully';
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
                $slugs = Slug::where([['parent_id', '=' ,$request->get('id')],['slug_type','=','Products']])->first();
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
                    $allData['slug_type'] = 'Products';
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
                $allData['slug_type'] = 'Products';
                $slugTitle = Slug::getSlug($allData);
            }
            $returnData['errorCode'] = "Success";
            $returnData['slugTitle'] = $slugTitle;
            $returnData['message'] = 'Slug Url send successfully';
        }
        return response()->json($returnData);
    }
    public function uploadGalleryFiles(Request $request) {
        $fileSize = '';
        $fileUrl = '';
        $fileType = '';
        $fileList = array();

        if($request->fileCount > 0) {
            for ($x = 0; $x < $request->fileCount; $x++) {
                if ($request->hasFile('uploaded_files'.$x)) {
                    $productImage = $request->file('uploaded_files'.$x);
                    if(isset($productImage)) {
                        $fileName = $productImage->getClientOriginalName();
                        $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                        $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                        $originalName = $actualName;
                        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                        $fileName = $originalName.'.'.$extension;
                        
                        if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                            $i = 1;
                            while (file_exists(public_path('uploads/products/normal/') . $actualName . "." . $extension)) {
                                $actualName = (string)$originalName . '-' . $i;
                                $fileName = $actualName . "." . $extension;
                                $i++;
                            }

                            $thumbImage = Image::make($productImage->getRealPath())->resize(150,150, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            
                            $thumbImage->save(public_path('uploads/products/thumb/').$fileName);
                            $productImage->move(public_path('uploads/products/normal'), $fileName);
                            $productImageName = $fileName;
                            $fileSize = filesize(public_path('uploads/products/normal/').$fileName);
                            $fileUrl = URL::asset('public/uploads/products/thumb/').'/'.$fileName;
                            $fileType = 'Image';
                            $fileList[$x] = ['name'=>$fileName, 'size'=>$fileSize, 'path'=>$fileUrl,'file_type' => $fileType];
                            $_SESSION['galleryFiles'][$fileName] = $fileName;
                        }
                    }
                }
            }
        }
        echo json_encode($fileList);
        die();
    }
    public function deleteGalleryFiles(Request $request) {
        if($request->file_name != '') {
            $extension = pathinfo($request->file_name, PATHINFO_EXTENSION);
            if($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                $deleteImageNormal = public_path('uploads/products/normal/') . $request->file_name;
                $deleteImageThumb = public_path('uploads/products/thumb/') . $request->file_name;
                if (file_exists($deleteImageNormal)) unlink($deleteImageNormal);
                if (file_exists($deleteImageThumb)) unlink($deleteImageThumb);
            }
            unset($_SESSION['galleryFiles'][$request->file_name]);
        }
        echo  "Success";
        die();
    }
    public function deleteGallery(Request $request) {
        if($request->file_id != '') {
            $productGallery = ProductGallery::where([['id', '=' ,$request->file_id]])->first();
            if(isset($productGallery)) {
                $extension = pathinfo($productGallery->file_name, PATHINFO_EXTENSION);
                if($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                    $deleteImageNormal = public_path('uploads/products/normal/') . $productGallery->file_name;
                    $deleteImageThumb = public_path('uploads/products/thumb/') . $productGallery->file_name;
                    if (file_exists($deleteImageNormal)) unlink($deleteImageNormal);
                    if (file_exists($deleteImageThumb)) unlink($deleteImageThumb);

                    $deleteProductGallery = ProductGallery::findOrFail($request->file_id);
                    $deleteProductGallery->delete();
                }
            }

            $productGalleries = ProductGallery::where([['product_id', '=' ,$productGallery->product_id]])->get();
            $return = view('admin.products.galleries',['productGalleries' => $productGalleries])->render();
        } else {
            $return = '';
        }
        return $return;
        die();
    }
}
