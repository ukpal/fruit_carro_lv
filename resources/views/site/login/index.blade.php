@extends('layouts.site')

@section('content')

<section class="main-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                                    
                <div role="tabpanel" class="log-sign-prt">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active">
                            <form action="{{ url('login/check-login') }}" method="POST" id="loginFrm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="text" class="form-control" name="login_username_email" id="login_username_email" placeholder="Username / Email Address">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Password">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="checkbox">
                                            <input type="checkbox"> Remember Me
                                        </label>       
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="#" class="fp">Forget Password?</a>
                                    </div>
                                </div>
                                <button class="btn btn-login" type="submit">Login</button>
                            </form>  
                            <div class="text-center">
                                <p class="devide-pera">Don't have an account? <a href="{{ url('sign-up') }}">Sign Up</a></p>
                            </div>                 
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(e) {
  $("#loginFrm").validate({
    ignore: [],
    debug: false,
    rules: {
        login_username_email: "required",
        login_password : "required"
    },
    messages: {
        login_username_email: "Please provide username / email",
        login_password : "Please provide password"
    }
  });
});
</script>
@endsection