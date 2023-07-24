@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/change-password/store') }}" method="POST" id="changePasswordFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $siteSettings->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Old Password</label>
              <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">New Password</label>
              <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Retype Password</label>
              <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Retype Passwprd">
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="change_password" class="btn btn-primary">Submit</button>
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
$(document).ready(function(e) {
  $("#changePasswordFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      old_password: "required",
      new_password : "required",
      retype_password : {
        required: true,
        equalTo : "#new_password"
      }
    },
    messages: {
      old_password: "Please provide old password",
      new_password : "Please provide new password",
      retype_password : {
        required: "Please provide retype password",
        equalTo : "New password and retype password should be same"
      }
    }
  });
});
</script>
@endsection