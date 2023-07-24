@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/users/store') }}" method="POST" id="userFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $user->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">User Type *</label>
              <select name="user_type" class="form-control" id="user_type">
                <option value="">Select User type</option>
                <option value="Landlord" {{ ($user->user_type == 'Landlord') ? 'selected' : '' }}>Landlord</option>
                <option value="Tenant" {{ ($user->user_type == 'Tenant') ? 'selected' : '' }}>Tenant</option>
              </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">First Name *</label>
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ $user->first_name ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Last Name *</label>
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ $user->last_name ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Email *</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Username *</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ $user->username ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Password *</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Phone Number </label>
              <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" value="{{ $user->phone_number ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">User Image</label>
              <div class="row">
                <div class="col-10">
                <input type="file" class="form-control" name="profile_image" id="profile_image">
                </div>
                <div class="col-2" id="profile_image_div">
                @if (isset($user->profile_image) && $user->profile_image!= '')
                <img src="{{ URL::asset('public/uploads/profile_images/thumb/').'/'.$user->profile_image }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($user->status == 'Active' || $user->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($user->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/users') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
  $("#userFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      user_type: "required",
      first_name: "required",
      last_name: "required",
      email: {
          required: true,
          email : true,
          remote: {
              url: "{{ url('admin/users/check-email') }}",
              type: "post",
              data: {
                  email: function(){ return $("#email").val(); },
                  id: function(){ return $("#id").val(); },
                  _token: function(){ return "{{ csrf_token() }}"; }
              }
          }
      },
      username: {
          required: true,
          remote: {
              url: "{{ url('admin/users/check-username') }}",
              type: "post",
              data: {
                username: function(){ return $("#username").val(); },
                id: function(){ return $("#id").val(); },
                  _token: function(){ return "{{ csrf_token() }}"; }
              }
          }
      },
      password: {
          required: function (element) {
              if($("#id").val() != ''){
                  return false;
              } else {
                  return true;
              }
          }
      }
    },
    messages: {
      user_type: "Please select user type",
      first_name: "Please provide first name",
      last_name: "Please provide last name",
      email: {
          required: "Please provide email",
          email : "Please provide valid email",
          remote: "Email is already exist"
      },
      username: {
          required: "Please provide username",
          remote: "Username is already exist"
      },
      password: "Please provide password"
    }
  });

  $("#profile_image").change(function() {
    readURL(this,'profile_image');
  });
});
</script>
@endsection