@extends('layouts.adminlogin')

@section('content')
<!-- Container start -->
<div class="container"> 
    <form action="{{ url('admin/check-login') }}" method="POST" id="loginFrm">
        {{ csrf_field() }}
        <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-screen">
                    <div class="login-box">
                        <a href="{{ url('/admin/login') }}" class="login-logo">
                            @if (isset($siteSettings->admin_login_logo) && $siteSettings->admin_login_logo != '')
                                <img src="{{ URL::asset('public/uploads/site_settings/normal/').'/'.$siteSettings->admin_login_logo }}" alt="{{ $siteSettings->site_name }}" class="center"/>
                            @else
                                {{ $siteSettings->site_name }}
                            @endif
                        </a>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email/Username" name="login_email"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="login_password"/>
                        </div>
                        <div class="actions mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember_pwd">
                                <label class="custom-control-label" for="remember_pwd">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>
                        <div class="forgot-pwd">
                            <a class="link" href="{{ url('/admin/forgot-password') }}">Forgot Password?</a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<script>
$(document).ready(function(e) {
  $("#loginFrm").validate({
    ignore: [],
    debug: false,
    rules: {
        login_email: "required",
        login_password : "required"
    },
    messages: {
        login_email: "Please provide email or username",
        login_password : "Please provide password"
    }
  });
});
</script>
<!-- Container end -->
@endsection