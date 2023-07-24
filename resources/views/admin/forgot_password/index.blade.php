@extends('layouts.adminlogin')

@section('content')
<!-- Container start -->
<div class="container"> 
    <form action="{{ url('admin/fotgot-password/check-email') }}" method="POST" id="forgotPasswordFrm">
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
                            <input type="text" class="form-control" placeholder="Email/Username" name="forgot_password_email"/>
                        </div>
                        <div class="actions mb-4">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                        <div class="forgot-pwd">
                            <a class="link" href="{{ url('/admin/login') }}">Back To Login</a>
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
  $("#forgotPasswordFrm").validate({
    ignore: [],
    debug: false,
    rules: {
        forgot_password_email: "required"
    },
    messages: {
        forgot_password_email: "Please provide email or username"
    }
  });
});
</script>
<!-- Container end -->
@endsection