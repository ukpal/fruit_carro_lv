<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteSetting;
use Validator;
use Session;
use Image;
use Carbon\Carbon;

class SiteSettingsController extends Controller {
    public function index() {
        $returnData['mainHeader'] = "Site Settings" ;
        $siteSettings = SiteSetting::first();
        if($siteSettings){
            $returnData['siteSettings'] = $siteSettings;
            $returnData['storage_path'] = env('APP_URL').'/public/uploads/site_settings/thumb/';
            $returnData['errorCode'] = "Success";
            $returnData['message'] = 'Site Settings details send successfully';
        }
        
        return response()->json($returnData);
    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
            'site_name' => 'required|max:255',
            'mailing_address' => 'required|max:500',
            'custom_admin_url' => 'required|max:500',
            'address' => 'required|max:500',
            'contact_number' => 'required|max:50'
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
                $siteSettings = SiteSetting::find($request->get('id'));
                $siteSettings->site_name =  $request->get('site_name');
                $siteSettings->mailing_address = $request->get('mailing_address');
                $siteSettings->paypal_business_email = $request->get('paypal_business_email');
                $siteSettings->custom_admin_url = $request->get('custom_admin_url');
                $siteSettings->site_tagline = $request->get('site_tagline');
                $siteSettings->address = $request->get('address');
                $siteSettings->contact_number = $request->get('contact_number');
                $siteSettings->facebook_url =  $request->get('facebook_url');
                $siteSettings->facebook_class = $request->get('facebook_class');
                $siteSettings->twitter_url = $request->get('twitter_url');
                $siteSettings->twitter_class = $request->get('twitter_class');
                $siteSettings->linkedin_url = $request->get('linkedin_url');
                $siteSettings->linkedin_class = $request->get('linkedin_class');
                $siteSettings->pintarest_url =  $request->get('pintarest_url');
                $siteSettings->pintarest_class = $request->get('pintarest_class');
                $siteSettings->instagram_url = $request->get('instagram_url');
                $siteSettings->instagram_class = $request->get('instagram_class');
                $siteSettings->home_page_featured_product_section_title = $request->get('home_page_featured_product_section_title');
                $siteSettings->home_page_featured_product_section_description = $request->get('home_page_featured_product_section_description');
                $siteSettings->home_page_testimonial_section_title = $request->get('home_page_testimonial_section_title');
                $siteSettings->home_page_testimonial_section_description = $request->get('home_page_testimonial_section_description');
                $siteSettings->home_page_newsletter_section_title = $request->get('home_page_newsletter_section_title');
                $siteSettings->home_page_newsletter_section_description = $request->get('home_page_newsletter_section_description');
                $siteSettings->home_page_forum_section_title = $request->get('home_page_forum_section_title');
                $siteSettings->home_page_forum_section_description = $request->get('home_page_forum_section_description');
                $return = $siteSettings->save();
                $returnId = $siteSettings->id;
            } else {
                $siteSettings = new SiteSetting;
                $siteSettings->site_name =  $request->get('site_name');
                $siteSettings->mailing_address = $request->get('mailing_address');
                $siteSettings->paypal_business_email = $request->get('paypal_business_email');
                $siteSettings->custom_admin_url = $request->get('custom_admin_url');
                $siteSettings->site_tagline = $request->get('site_tagline');
                $siteSettings->address = $request->get('address');
                $siteSettings->contact_number = $request->get('contact_number');
                $siteSettings->facebook_url =  $request->get('facebook_url');
                $siteSettings->facebook_class = $request->get('facebook_class');
                $siteSettings->twitter_url = $request->get('twitter_url');
                $siteSettings->twitter_class = $request->get('twitter_class');
                $siteSettings->linkedin_url = $request->get('linkedin_url');
                $siteSettings->linkedin_class = $request->get('linkedin_class');
                $siteSettings->pintarest_url =  $request->get('pintarest_url');
                $siteSettings->pintarest_class = $request->get('pintarest_class');
                $siteSettings->instagram_url = $request->get('instagram_url');
                $siteSettings->instagram_class = $request->get('instagram_class');
                $siteSettings->home_page_featured_product_section_title = $request->get('home_page_featured_product_section_title');
                $siteSettings->home_page_featured_product_section_description = $request->get('home_page_featured_product_section_description');
                $siteSettings->home_page_testimonial_section_title = $request->get('home_page_testimonial_section_title');
                $siteSettings->home_page_testimonial_section_description = $request->get('home_page_testimonial_section_description');
                $siteSettings->home_page_newsletter_section_title = $request->get('home_page_newsletter_section_title');
                $siteSettings->home_page_newsletter_section_description = $request->get('home_page_newsletter_section_description');
                $siteSettings->home_page_forum_section_title = $request->get('home_page_forum_section_title');
                $siteSettings->home_page_forum_section_description = $request->get('home_page_forum_section_description');
                $return = $siteSettings->save();
                $returnId = $siteSettings->id;
            }
            if($return) {
                if($request->get('id') != '') {
                    $siteSettings = SiteSetting::find($request->get('id'));
                }

                $adminLoginLogoName = '';
                $adminLoginLogo = $request->file('admin_login_logo');
                if(isset($adminLoginLogo)) {
                    $fileName = $adminLoginLogo->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/site_settings/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($adminLoginLogo->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/site_settings/thumb/'.$fileName);
                        $adminLoginLogo->move('public/uploads/site_settings/normal/', $fileName);
                        $adminLoginLogoName = $fileName;
                        if($siteSettings->admin_login_logo != '') {
                            $delete_image_normal = 'public/uploads/site_settings/normal/'.$siteSettings->admin_login_logo;
                            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                            $delete_image_thumb = 'public/uploads/site_settings/thumb/'.$siteSettings->admin_login_logo;
                            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $adminLoginLogoName = $siteSettings->admin_login_logo;
                    }
                }

                $adminLogoName = '';
                $adminLogo = $request->file('admin_logo');
                if(isset($adminLogo)) {
                    $fileName = $adminLogo->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/site_settings/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($adminLogo->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/site_settings/thumb/'.$fileName);
                        $adminLogo->move('public/uploads/site_settings/normal/', $fileName);
                        $adminLogoName = $fileName;
                        if($siteSettings->admin_logo != '') {
                            $delete_image_normal = 'public/uploads/site_settings/normal/'.$siteSettings->admin_logo;
                            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                            $delete_image_thumb = 'public/uploads/site_settings/thumb/'.$siteSettings->admin_logo;
                            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $adminLogoName = $siteSettings->admin_logo;
                    }
                }

                $siteLogoName = '';
                $siteLogo = $request->file('site_logo');
                if(isset($siteLogo)) {
                    $fileName = $siteLogo->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/site_settings/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($siteLogo->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/site_settings/thumb/'.$fileName);
                        $siteLogo->move('public/uploads/site_settings/normal/', $fileName);
                        $siteLogoName = $fileName;
                        if($siteSettings->site_logo != '') {
                            $delete_image_normal = 'public/uploads/site_settings/normal/'.$siteSettings->site_logo;
                            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                            $delete_image_thumb = 'public/uploads/site_settings/thumb/'.$siteSettings->site_logo;
                            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $siteLogoName = $siteSettings->site_logo;
                    }
                }

                $siteFooterLogoName = '';
                $siteFooterLogo = $request->file('site_footer_logo');
                if(isset($siteFooterLogo)) {
                    $fileName = $siteFooterLogo->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/site_settings/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($siteFooterLogo->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/site_settings/thumb/'.$fileName);
                        $siteFooterLogo->move('public/uploads/site_settings/normal/', $fileName);
                        $siteFooterLogoName = $fileName;
                        if($siteSettings->site_footer_logo != '') {
                            $delete_image_normal = 'public/uploads/site_settings/normal/'.$siteSettings->site_footer_logo;
                            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                            $delete_image_thumb = 'public/uploads/site_settings/thumb/'.$siteSettings->site_footer_logo;
                            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $siteFooterLogoName = $siteSettings->site_footer_logo;
                    }
                }

                $faviconName = '';
                $favicon = $request->file('favicon');
                if(isset($favicon)) {
                    $fileName = $favicon->getClientOriginalName();
                    $actualName = pathinfo($fileName, PATHINFO_FILENAME);
                    $actualName = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($actualName)));
                    $originalName = $actualName;
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if ($extension == 'jpg' || $extension == 'gif' || $extension == 'jpeg' || $extension == 'png' || $extension == 'ico') {
                        $i = 1;
                        while (file_exists('public/uploads/site_settings/normal/' . $actualName . "." . $extension)) {
                            $actualName = (string)$originalName . '-' . $i;
                            $fileName = $actualName . "." . $extension;
                            $i++;
                        }
                        $thumbImage = Image::make($favicon->getRealPath())->resize(150,150, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $thumbImage->save('public/uploads/site_settings/thumb/'.$fileName);
                        $favicon->move('public/uploads/site_settings/normal/', $fileName);
                        $faviconName = $fileName;
                        if($siteSettings->favicon != '') {
                            $delete_image_normal = 'public/uploads/site_settings/normal/'.$siteSettings->favicon;
                            if (file_exists($delete_image_normal)) unlink($delete_image_normal);
                            $delete_image_thumb = 'public/uploads/site_settings/thumb/'.$siteSettings->favicon;
                            if (file_exists($delete_image_thumb)) unlink($delete_image_thumb);
                        }
                    }
                } else {
                    if($request->get('id') != '') {
                        $faviconName = $siteSettings->favicon;
                    }
                }

                $siteSettings = SiteSetting::find($returnId);
                $siteSettings->admin_login_logo = $adminLoginLogoName;
                $siteSettings->admin_logo = $adminLogoName;
                $siteSettings->site_logo = $siteLogoName;
                $siteSettings->site_footer_logo = $siteFooterLogoName;
                $siteSettings->favicon = $faviconName;
                $return = $siteSettings->save();

                if($return) {                  
                    $returnData['errorCode'] = "Success";
                    $returnData['message'] = 'Site settings saved successfully';
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
}
