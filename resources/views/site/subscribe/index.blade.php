@extends('layouts.site')

@section('content')

<section class="main-wrap">
    <div class="container">

        <input type="hidden" name="step_1_hid_val" id="step_1_hid_val" value="Completed">
        <input type="hidden" name="step_2_hid_val" id="step_2_hid_val" value="{{ $userPackageDetails->slug ?? '' }}">
        <input type="hidden" name="step_3_hid_val" id="step_3_hid_val" value="">

        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="mar-top sw-main sw-theme-arrows">
                    <ul class="nav nav-tabs step-anchor">
                        <li class="done" id="personalDetailsList">
                            <a href="javascript:void(0)" onclick="javascript:personalDetails();"><i class="fa fa-user"></i> <span>Personal Details</span></a>
                        </li>
                        <li class="done" id="packagesList">
                            <a href="javascript:void(0)"onclick="javascript:packages();"><i class="fa fa-cubes"></i> <span>Packages</span></a>
                        </li>
                        <li id="paymentList" @php if($userPackageDetails->slug != '') { @endphp class="done" @php } @endphp >
                            <a href="javascript:void(0)" onclick="javascript:payment();"><i class="fa fa-money"></i> <span>Payment</span></a>
                        </li>
                    </ul>
                    
                    <div class="sw-container tab-content" style="height: 500px;">
                        <div id="step-1" class="step-content" style="display: none;">
                            <div class="step-bdy">
                                <h2>Personal Details</h2>
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <?php echo $userDetails->first_name; ?>
                                </div>
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <?php echo $userDetails->last_name; ?>
                                </div>
                                <div class="form-group">
                                    <label>Username:</label>
                                    <?php echo $userDetails->username; ?>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <?php echo $userDetails->email; ?>
                                </div>
                            </div>     
                        </div>
                        
                        <div id="step-2" class="step-content" @php if($userPackageDetails->slug != '') { @endphp style="display: none;" @php } else { @endphp style="display: block;" @php } @endphp>
                            <div class="step-bdy">
                                <h2>Packages</h2>
                                <div class="row mar-top-30">
                                    @if ($packages)
                                        @foreach ($packages as $packages1)
                                    <div class="col-md-4">
                                        <div @php if($userPackageDetails->slug != '' && $userPackageDetails->slug == $packages1->slug) { @endphp class="pricing-grid active" @php } else { @endphp class="pricing-grid" @php } @endphp  onclick="javascript:setPackage('{{ $packages1->slug }}')">
                                            <div class="price-value">
                                                <h4>{{ $packages1->title }}</h4>
                                                <h2><span>$</span>{{ $packages1->price }}</h2>
                                            </div>
                                            <div class="price-bg">
                                            @php echo html_entity_decode($packages1->content) @endphp
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input class="btn btn-success" type="button" value="Next" onclick="javascript:selectPackage();">
                            </div>
                        </div>
                        
                        <div id="step-3" class="step-content" @php if($userPackageDetails->slug != '') { @endphp style="display: block;" @php } else { @endphp style="display: none;" @php } @endphp >
                            <div class="step-bdy">
                                <h2>Payments</h2>
                                
                                <div class="payment-option-box-inner">
                                    <div class="payment-top-box">
                                        <div class="radio-box">
                                        <input type="radio" id="payment_method" value="Paypal" name="payment_method" ></div>  
                                        <div class="paypal-box">
                                        <div class="paypal-top"> <img src="{{ URL::asset('public/assets/site/images/paypal-img.png') }}" alt="Electro"> </div>
                                        <div class="paypal-img"> <img src="{{ URL::asset('public/assets/site/images/payment-method.png') }}" alt="Electro"> </div>
                                        </div>
                                    </div>
                                    <p>If you Don't have Paypal Account, it doesn,t matter. You can also pay via Paypal with you credit card or bank debit card</p>
                                    <p>Payment can be submitted in any currency.</p>
                                </div>
                                <input class="btn btn-success" type="button" value="Payment" onclick="javascript:getPaymentDetails();">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="abt-txt"> 
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
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" id="paypalFrm" method="post" target="_top">
        <input type='hidden' name='business' id="business" value=''> 
        <input type='hidden' name='item_name' id="item_name" value=''> 
        <input type='hidden' name='item_number' id="item_number" value=''>
        <input type='hidden' name='amount' id="amount" value=''>
        <input type='hidden' name='no_shipping' value='1'>
        <input type='hidden' name='currency_code' value='USD'>
        <input type='hidden' name='notify_url' value="{{ url('subscribe/paypal-notify') }}">
        <input type='hidden' name='cancel_return' value="{{ url('subscribe/paypal-cancel') }}">
        <input type='hidden' name='return' value="{{ url('subscribe/paypal-return') }}">
        <input type="hidden" name="cmd" value="_xclick">
    </form>
</section>
<script>
$(document).ready(function(e) {                       
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
function getPaymentDetails() {
    if($("#payment_method").prop('checked') == true){
        $.blockUI({ message:  '<img src="{{ URL::asset("public/assets/img/preloading-white.gif") }}" alt="" class="img-loader-cls"/>',css: { 
            border: 'none', 
            padding: '0px', 
            backgroundColor: 'transparent', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            color: '#fff' 
        } });
        var token = "{{ csrf_token() }}";
        var gotourl="{{ url('subscribe') }}"+'/get-payment-details';
        $.ajax({
                type: "POST",
                url: gotourl,
                data: { _token: token,payment_method : $('#payment_method:checked').val() },
                dataType: "text",
                cache:false,
                success:
                    function(data){
                        $.unblockUI();
                        var jsonObj = JSON.parse(data);
                        if(jsonObj.errorCode == 'Success') {
                            $("#business").val(jsonObj.business);
                            $("#item_name").val(jsonObj.item_name);
                            $("#item_number").val(jsonObj.item_number);
                            $("#amount").val(jsonObj.amount);
                            $("#paypalFrm").submit();
                        } else {
                            swal(
                                'Error!',
                                ""+jsonObj.message+"",
                                'error'
                            );
                        }
                    }
        });
    } else {
        swal(
            'Error!',
            "Please select atleast one payment method",
            'error'
        );
    }
}
</script>

@endsection