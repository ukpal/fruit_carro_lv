@extends('layouts.site')

@section('content')

<section class="main-wrap">
    <div class="container">
        <input type="hidden" name="step_1_hid_val" id="step_1_hid_val" value="">
        <input type="hidden" name="step_2_hid_val" id="step_2_hid_val" value="">
        <input type="hidden" name="step_3_hid_val" id="step_3_hid_val" value="">

        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="mar-top sw-main sw-theme-arrows">
                    <ul class="nav nav-tabs step-anchor">
                        <li class="done" id="personalDetailsList">
                            <a href="javascript:void(0)" onclick="javascript:personalDetails();"><i class="fa fa-user"></i> <span>Personal Details</span></a>
                        </li>
                        <li id="packagesList">
                            <a href="javascript:void(0)"onclick="javascript:packages();"><i class="fa fa-cubes"></i> <span>Packages</span></a>
                        </li>
                        <li id="paymentList">
                            <a href="javascript:void(0)" onclick="javascript:payment();"><i class="fa fa-money"></i> <span>Payment</span></a>
                        </li>
                    </ul>
                    
                    <div class="sw-container tab-content" style="height: 500px;">
                        <div id="step-1" class="step-content" style="display: block;">
                            <div class="step-bdy">
                                <h2>Personal Details</h2>
                                <span id="personalDetailsSpan">
                                    <form action="{{ url('sign-up/save-user') }}" method="POST" id="signupFrm" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>First Name:</label>
                                            <input type="text" name="signup_first_name" id="signup_first_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name:</label>
                                            <input type="text" name="signup_last_name" id="signup_last_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Username:</label>
                                            <input type="text" name="signup_username" id="signup_username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" name="signup_email" id="signup_email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" name="signup_password" id="signup_password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Retype Password:</label>
                                            <input type="password" name="signup_retype_password" id="signup_retype_password" class="form-control">
                                        </div>
                                        <input class="btn btn-success" type="submit" value="Sabmit">
                                    </form>
                                </span>
                            </div>     
                        </div>
                        
                        <div id="step-2" class="step-content" style="display: none;">
                            <div class="step-bdy">
                                <h2>Packages</h2>
                                <div class="row mar-top-30">
                                    @if ($packages)
                                        @foreach ($packages as $packages1)
                                    <div class="col-md-4">
                                        <div class="pricing-grid" onclick="javascript:setPackage('{{ $packages1->slug }}')">
                                            <div class="price-value">
                                                <h4>{{ $packages1->title }}</h4>
                                                <h2><span>$</span>{{ $packages1->price }}</h2>
                                            </div>
                                            <div class="price-bg">
                                            {{ strip_tags(html_entity_decode($packages1->content)) ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input class="btn btn-success" type="button" value="Sabmit" onclick="javascript:selectPackage();">
                            </div>
                        </div>
                        
                        <div id="step-3" class="step-content" style="display: none;">
                            <div class="step-bdy">
                                <h2>Payments</h2>
                                
                                <div class="payment-option-box-inner">
                                    <div class="payment-top-box">
                                        <div class="radio-box">
                                        <input type="radio" id="paypal1" value="paypal" name="payment_type1" ></div>  
                                        <div class="paypal-box">
                                        <div class="paypal-top"> <img src="{{ URL::asset('public/assets/site/images/paypal-img.png') }}" alt="Electro"> </div>
                                        <div class="paypal-img"> <img src="{{ URL::asset('public/assets/site/images/payment-method.png') }}" alt="Electro"> </div>
                                        </div>
                                    </div>
                                    <p>If you Don't have CCAvenue Account, it doesn,t matter. You can also pay via CCAvenue with you credit card or bank debit card</p>
                                    <p>Payment can be submitted in any currency.</p>
                                </div>
                                <input class="btn btn-success" type="submit" value="Payment">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="abt-txt mar-top"> 
            <h4>Lorem ipsum dolor sit amet, <span>consectetur adipiscing elit.</span></h4>
            <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis facilisis odio.</strong></p>
            <p>Donec sit amet euismod massa, in ultricies lectus. Nulla facilisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel elementum leo, vel suscipit magna. Praesent metus orci, finibus non quam non, faucibus pharetra neque. Integer hendrerit ut magna eget egestas. Curabitur mollis elit ut efficitur aliquam. Vivamus eu elementum urna, eu porta libero. Nulla efficitur lacus et maximus aliquet. Duis quis odio vitae felis pretium condimentum. Donec in lectus arcu. Maecenas congue ut magna id posuere. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis facilisis odio. Duis ac lectus vitae velit gravida volutpat ac id nibh. In vitae tellus nisl. Fusce nec faucibus ante. Vestibulum a venenatis magna. Maecenas sed nisl vel ipsum elementum hendrerit et ac velit. Praesent feugiat metus a tellus placerat auctor. Donec iaculis porttitor quam.</p>
            <h4>Lorem ipsum dolor sit amet, <span>consectetur adipiscing elit.</span></h4>
            <ul>
                <li>Nullam efficitur nunc vel consequat iaculis.</li>
                <li>Duis ac leo at ex mollis pellentesque.</li>
                <li>Nam nec ligula id diam tincidunt consectetur vel sed turpis.</li>
                <li>Integer ornare ante quis imperdiet efficitur.</li>
                <li>Curabitur nec diam auctor, ullamcorper nisl ac, dapibus dolor.</li>
                <li>Mauris semper arcu ut sapien sollicitudin, et sagittis ipsum molestie.</li>
                <li>Duis non nulla nec magna accumsan consectetur.</li>
                <li>Vivamus sit amet libero eu nibh cursus mattis.</li>
            </ul>
        </div>
    </div>
</section>
<script>
$(document).ready(function(e) {
  $("#signupFrm").validate({
    ignore: [],
    debug: false,
    rules: {
        signup_first_name: "required",
        signup_last_name : "required",
        signup_username: {
            required: true,
            remote: {
                url: "{{ url('sign-up/check-username') }}",
                type: "post",
                data: {
                    signup_username: function(){ return $("#signup_username").val(); },
                    _token: function(){ return "{{ csrf_token() }}"; }
                }
            }
        },
        signup_email: {
            required: true,
            email: true,
            remote: {
                url: "{{ url('sign-up/check-email') }}",
                type: "post",
                data: {
                    signup_email: function(){ return $("#signup_email").val(); },
                    _token: function(){ return "{{ csrf_token() }}"; }
                }
            }        
        },
        signup_password : "required",
        signup_retype_password : {
            required: true,
            equalTo: "#signup_password"
        }
    },
    messages: {
        signup_first_name: "Please provide first name",
        signup_last_name : "Please provide last name",
        signup_username : {
            required: "Please provide username",
            remote: "Username is already exist"
        },
        signup_email: {
            required: "Please provide email",
            email: "Please provide valid email",
            remote: "Email is already exist"     
        },
        signup_password : "Please provide password",
        signup_retype_password : {
            required: "Please retype password",
            equalTo: "Password and retype password are not same"
        }
    }
  });                     
               
    $(".pricing-grid").click(function () {
        $(".pricing-grid").removeClass("active");
        $(this).addClass("active");   
    });
});

function personalDetails() {
    $("#personalDetailsList").addClass('done');
    $("#step-1").show();
    $("#packagesList").removeClass('done');
    $("#step-2").hide();
    $("#paymentList").removeClass('done');
    $("#step-3").hide();
}
function packages() {
    if($('#step_1_hid_val').val() != '') {
        $("#personalDetailsList").addClass('done');
        $("#step-1").hide();
        $("#packagesList").addClass('done');
        $("#step-2").show();
        $("#paymentList").removeClass('done');
        $("#step-3").hide();
    } else {
        swal(
            'Error!',
            "Please complete Step 1",
            'error'
        );
    }
}
function payment() {
    if($('#step_2_hid_val').val() != '') {
        $("#personalDetailsList").addClass('done');
        $("#step-1").hide();
        $("#packagesList").addClass('done');
        $("#step-2").hide();
        $("#paymentList").addClass('done');
        $("#step-3").show();
    } else {
        swal(
            'Error!',
            "Please complete Step 2",
            'error'
        );
    }
}
function setPackage(packageSlug) {
    $("#step_2_hid_val").val(packageSlug);
}
function selectPackage() {
    var packageSlug = $("#step_2_hid_val").val();
    $.blockUI({ message:  '<img src="{{ URL::asset("public/assets/img/preloading-white.gif") }}" alt="" class="img-loader-cls"/>',css: { 
        border: 'none', 
        padding: '0px', 
        backgroundColor: 'transparent', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        color: '#fff' 
    } }); 
    var token = "{{ csrf_token() }}";
    var gotourl="{{ url('subscribe') }}"+'/select-package';
    $.ajax({
            type: "POST",
            url: gotourl,
            data: { _token: token, package_slug : packageSlug },
            dataType: "text",
            cache:false,
            success:
                function(data){
                    var jsonObj = JSON.parse(data);
                    if(jsonObj.errorCode == 'Success') {
                        $("#personalDetailsList").addClass('done');
                        $("#step-1").hide();
                        $("#packagesList").addClass('done');
                        $("#step-2").hide();
                        $("#paymentList").addClass('done');
                        $("#step-3").show();
                        swal(
                            'Success!',
                            ""+jsonObj.message+"",
                            'success'
                        );
                    } else {
                        swal(
                            'Error!',
                            ""+jsonObj.message+"",
                            'error'
                        );
                    }
                    $.unblockUI();
                }
    });
}
</script>

@endsection