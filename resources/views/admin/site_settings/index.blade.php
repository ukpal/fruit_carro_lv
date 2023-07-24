@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/site-settings/store') }}" method="POST" id="siteSettingFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $siteSettings->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Site Name *</label>
              <input type="text" class="form-control" name="site_name" id="site_name" placeholder="Site Name" value="{{ $siteSettings->site_name ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Mailing Address *</label>
              <input type="text" class="form-control" name="mailing_address" id="mailing_address" placeholder="Mailing Address" value="{{ $siteSettings->mailing_address ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="phone">Custom Admin Url *</label>
              <input type="text" class="form-control" name="custom_admin_url" id="custom_admin_url" placeholder="Custom Admin Url" value="{{ $siteSettings->custom_admin_url ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Address *</label>
              <textarea name="address" id="address" class="form-control">{{ $siteSettings->address ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Contact Number *</label>
              <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number" value="{{ $siteSettings->contact_number ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Paypal Business Email</label>
              <input type="text" class="form-control" name="paypal_business_email" id="paypal_business_email" placeholder="Paypal Business Email" value="{{ $siteSettings->paypal_business_email ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Site Tagline</label>
              <input type="text" class="form-control" name="site_tagline" id="site_tagline" placeholder="Site Tagline" value="{{ $siteSettings->site_tagline ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="phone">Facebook Url</label>
              <input type="text" class="form-control" name="facebook_url" id="facebook_url" placeholder="Facebook Url" value="{{ $siteSettings->facebook_url ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Facebook Class</label>
              <input type="text" class="form-control" name="facebook_class" id="facebook_class" placeholder="Facebook Class" value="{{ $siteSettings->facebook_class ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Twitter Url</label>
              <input type="text" class="form-control" name="twitter_url" id="twitter_url" placeholder="Twitter Url" value="{{ $siteSettings->twitter_url ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Twitter Class</label>
              <input type="text" class="form-control" name="twitter_class" id="twitter_class" placeholder="Twitter Class" value="{{ $siteSettings->twitter_class ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="phone">Linkedin Url</label>
              <input type="text" class="form-control" name="linkedin_url" id="linkedin_url" placeholder="Linkedin Url" value="{{ $siteSettings->linkedin_url ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Linkedin Class</label>
              <input type="text" class="form-control" name="linkedin_class" id="linkedin_class" placeholder="Linkedin Class" value="{{ $siteSettings->linkedin_class ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="phone">Pintarest Url</label>
              <input type="text" class="form-control" name="pintarest_url" id="pintarest_url" placeholder="Pintarest Url" value="{{ $siteSettings->pintarest_url ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Pintarest Class</label>
              <input type="text" class="form-control" name="pintarest_class" id="pintarest_class" placeholder="Pintarest Class" value="{{ $siteSettings->pintarest_class ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Instagram Url</label>
              <input type="text" class="form-control" name="instagram_url" id="instagram_url" placeholder="Instagram Url" value="{{ $siteSettings->instagram_url ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Instagram Class</label>
              <input type="text" class="form-control" name="instagram_class" id="instagram_class" placeholder="Instagram Class" value="{{ $siteSettings->instagram_class ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Featured Product Section Title</label>
              <textarea name="home_page_featured_product_section_title" id="home_page_featured_product_section_title" class="form-control" placeholder="Home Page Featured Product Section Title">{{ $siteSettings->home_page_featured_product_section_title ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Featured Product Section Description</label>
              <textarea name="home_page_featured_product_section_description" id="home_page_featured_product_section_description" class="form-control" placeholder="Home Page Featured Product Section Description">{{ $siteSettings->home_page_featured_product_section_description ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Testimonial Section Title</label>
              <textarea name="home_page_testimonial_section_title" id="home_page_testimonial_section_title" class="form-control" placeholder="Home Page Testimonial Section Title">{{ $siteSettings->home_page_testimonial_section_title ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Testimonial Section Description</label>
              <textarea name="home_page_testimonial_section_description" id="home_page_testimonial_section_description" class="form-control" placeholder="Home Page Testimonial Section Description">{{ $siteSettings->home_page_testimonial_section_description ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Newsletter Section Title</label>
              <textarea name="home_page_newsletter_section_title" id="home_page_newsletter_section_title" class="form-control" placeholder="Home Page Newsletter Section Title">{{ $siteSettings->home_page_newsletter_section_title ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Newsletter Section Description</label>
              <textarea name="home_page_newsletter_section_description" id="home_page_newsletter_section_description" class="form-control" placeholder="Home Page Newsletter Section Description">{{ $siteSettings->home_page_newsletter_section_description ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Forum Section Title</label>
              <textarea name="home_page_forum_section_title" id="home_page_forum_section_title" class="form-control" placeholder="Home Page Forum Section Title">{{ $siteSettings->home_page_forum_section_title ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">Home Page Forum Section Description</label>
              <textarea name="home_page_forum_section_description" id="home_page_forum_section_description" class="form-control" placeholder="Home Page Forum Section Description">{{ $siteSettings->home_page_forum_section_description ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Upload Admin Login Logo</label>
              <div class="row">
                <div class="col-8">
                <input type="file" class="form-control" name="admin_login_logo" id="admin_login_logo">
                </div>
                <div class="col-4" id="admin_login_logo_div">
                @if (isset($siteSettings->admin_login_logo))
                <img src="{{ URL::asset('public/uploads/site_settings/thumb/').'/'.$siteSettings->admin_login_logo }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Upload Admin Logo</label>
              <div class="row">
                <div class="col-8">
                <input type="file" class="form-control" name="admin_logo" id="admin_logo">
                </div>
                <div class="col-4" id="admin_logo_div">
                @if (isset($siteSettings->admin_logo))
                <img src="{{ URL::asset('public/uploads/site_settings/thumb/').'/'.$siteSettings->admin_logo }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Site Logo</label>
              <div class="row">
                <div class="col-8">
                <input type="file" class="form-control" name="site_logo" id="site_logo">
                </div>
                <div class="col-4" id="site_logo_div">
                @if (isset($siteSettings->site_logo))
                <img src="{{ URL::asset('public/uploads/site_settings/thumb/').'/'.$siteSettings->site_logo }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Site Footer Logo</label>
              <div class="row">
                <div class="col-8">
                <input type="file" class="form-control" name="site_footer_logo" id="site_footer_logo">
                </div>
                <div class="col-4" id="site_footer_logo_div">
                @if (isset($siteSettings->site_footer_logo))
                <img src="{{ URL::asset('public/uploads/site_settings/thumb/').'/'.$siteSettings->site_footer_logo }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Favicon</label>
              <div class="row">
                <div class="col-8">
                <input type="file" class="form-control" name="favicon" id="favicon">
                </div>
                <div class="col-4" id="favicon_div">
                @if (isset($siteSettings->favicon))
                <img src="{{ URL::asset('public/uploads/site_settings/thumb/').'/'.$siteSettings->favicon }}">
                @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <button type="button" name="cancel" class="btn btn-secondary">Cancel</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
<script>
function readURL(input,getVal) {
  if (input.files && input.files[0]) {
    var extension=$('#'+getVal).val().replace(/^.*\./, '');
    if(extension.toLowerCase() == 'jpg' || extension.toLowerCase() == 'gif' ||extension.toLowerCase() == 'jpeg' || extension.toLowerCase() == 'png' || extension.toLowerCase() == 'ico') {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#'+getVal+"_div").html('<img src="'+e.target.result+'" alt="" height="150" width="150">');
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    } else {
      $('#'+getVal+"_div").html('');
    }
  }
}

$(document).ready(function(e) {
  $("#siteSettingFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      site_name: "required",
      mailing_address : "required",
      custom_admin_url: "required",
      address : "required",
      contact_number : "required"
    },
    messages: {
      site_name: "Please provide site name",
      mailing_address : "Please provide mailing address",
      custom_admin_url : "Please provide custom admin url",
      address : "Please provide address",
      contact_number : "Please provide contact number"
    }
  });

  $("#admin_login_logo").change(function() {
    readURL(this,'admin_login_logo');
  });
  $("#admin_logo").change(function() {
    readURL(this,'admin_logo');
  });
  $("#site_logo").change(function() {
    readURL(this,'site_logo');
  });
  $("#site_footer_logo").change(function() {
    readURL(this,'site_footer_logo');
  });
  $("#favicon").change(function() {
    readURL(this,'favicon');
  });
});
</script>
@endsection