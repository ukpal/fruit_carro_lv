@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/profile/store') }}" method="POST" id="profileFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">First Name</label>
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ $userDetails->first_name ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Last Name</label>
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ $userDetails->last_name ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="phone">Email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ $userDetails->email ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ $userDetails->username ?? '' }}">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Profile Image</label>
              <div class="row">
                <div class="col-8">
                <input type="file" class="form-control" name="profile_image" id="profile_image">
                </div>
                <div class="col-4" id="profile_image_div">
                @if (isset($userDetails->profile_image) && $userDetails->profile_image != '')
                <img src="{{ URL::asset('public/uploads/profile_images/thumb/').'/'.$userDetails->profile_image }}">
                @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="edit_profile" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/profile') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
    if(extension.toLowerCase() == 'jpg' || extension.toLowerCase() == 'gif' || extension.toLowerCase() == 'jpeg' || extension.toLowerCase() == 'png' || extension.toLowerCase() == 'ico') {
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
  $("#profileFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      first_name: "required",
      last_name : "required",
      email: "required",
      username : "required"
    },
    messages: {
      first_name: "Please provide first name",
      last_name : "Please provide last name",
      email : "Please provide email",
      username : "Please provide username"
    }
  });

  $("#profile_image").change(function() {
    readURL(this,'profile_image');
  });
});
</script>
@endsection