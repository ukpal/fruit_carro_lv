@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/profile/store') }}" method="POST" id="siteSettingFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName">First Name : </label>
              {{ $userDetails->first_name ?? '' }}
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Last Name : </label>
              {{ $userDetails->last_name ?? '' }}
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="phone">Email : </label>
              {{ $userDetails->email ?? '' }}
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="website">Username : </label>
              {{ $userDetails->username ?? '' }}
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="eMail">Profile Image : </label>
                @if (isset($userDetails->profile_image) && $userDetails->profile_image != '')
                <img src="{{ URL::asset('public/uploads/profile_images/thumb/').'/'.$userDetails->profile_image }}">
                @endif
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <a href="{{ url('/admin/profile/edit') }}"><button type="button" name="edit_profile" class="btn btn-primary">Edit Profile</button></a>
              <a href="{{ url('/admin/change-password') }}"><button type="button" name="change_password" class="btn btn-secondary">Change Password</button></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
@endsection