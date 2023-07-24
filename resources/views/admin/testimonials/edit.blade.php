@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/testimonials/store') }}" method="POST" id="testimonialFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $testimonial->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">User Full Name *</label>
              <input type="text" class="form-control" name="user_full_name" id="user_full_name" placeholder="User Full Name" value="{{ $testimonial->user_full_name ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">User Image</label>
              <div class="row">
                <div class="col-10">
                <input type="file" class="form-control" name="user_image" id="user_image">
                </div>
                <div class="col-2" id="user_image_div">
                @if (isset($testimonial->user_image) && $testimonial->user_image!= '')
                <img src="{{ URL::asset('public/uploads/testimonials/thumb/').'/'.$testimonial->user_image }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Content</label>
              <textarea class="form-control ckeditor" name="content" id="content">{{ html_entity_decode($testimonial->content) ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($testimonial->status == 'Active' || $testimonial->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($testimonial->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/testimonials') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
  $("#testimonialFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      user_full_name: "required"
    },
    messages: {
      user_full_name: "Please provide user full name"
    }
  });

  $("#user_image").change(function() {
    readURL(this,'user_image');
  });
});
</script>
@endsection