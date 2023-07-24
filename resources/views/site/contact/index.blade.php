@extends('layouts.site')

@section('content')
<section id="contact-us">
  <div class="contact">
    <div id="map"></div>
    <div class="container">
      <div class="row">
        
           <div class="col-md-4 hidden-xs">
           </div> 
           
           <div class="col-md-4 hidden-xs">
           </div> 
           
           <div class="col-md-4 col-sm-4 col-xs-12  contact-text">
           
            	<div class="agent-p-contact">
                	<div class="our-agent-box bottom30">
                        <h2>get in touch</h2>
                    </div>
                    <div class="agetn-contact-2 bottom30">
                      	 <p><i class="icon-telephone114"></i> {{ $siteSettings->contact_number }}</p>
                         <p><i class=" icon-icons142"></i> {{ $siteSettings->mailing_address }}</p>
                         <p><i class="icon-icons74"></i> {{ $siteSettings->address }}</p>
                      </div>
                    <ul class="social_share bottom20">
            <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i></a></li>
            <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i></a></li>
            <li><a href="javascript:void(0)" class="google"><i class="icon-google4"></i></a></li>
            <li><a href="javascript:void(0)" class="linkden"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i></a></li>
          </ul>
                </div>
            
            	<div class="agent-p-form">
                	<div class="our-agent-box bottom30">
                        <h2>Send us a message</h2>
                    </div>
                    
                    <div class="row">
                      <form action="{{ url('contact-us/store') }}" method="POST" id="contactUsFrm" enctype="multipart/form-data" class="callus">
                            {{ csrf_field() }}
                        <div class="col-md-12">
                          <div class="single-query form-group">
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" class="keyword-input">
                            </div>
                            <div class="single-query form-group">
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" class="keyword-input">
                          </div>
                          <div class="single-query form-group">
                            <input type="text" id="email" name="email" placeholder="Email Adress" class="keyword-input">
                          </div>
                          <div class="single-query form-group">
                            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="keyword-input">
                          </div>
                          <div class="single-query form-group">
                            <textarea rows="1" id="message" name="message" placeholder="Massege" class="form-control"></textarea>
                          </div>
                          <input type="submit" value="submit now" class="btn-blue">
                          </div>
                      </form>
                      
                    </div>
                	
                </div>
                
            </div>
            
        </div>
    </div>
  </div>
</section>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> 
<script src="{{ URL::asset('public/assets/site/js/gmaps.js.js') }}"></script>
<script src="{{ URL::asset('public/assets/site/js/contact.js') }}"></script>
<script src="{{ URL::asset('public/assets/site/js/google-map.js') }}"></script> 
<script>
$(document).ready(function(e) {
  $("#contactUsFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      first_name: "required",
      last_name : "required",
      email: {
         required: true,
         email: true          
        }
    },
    messages: {
      first_name: "Please provide first name",
      last_name : "Please provide last name",
      email: {
         required: "Please provide email",
         email: "Please provide valid email"          
        }
    },
    submitHandler: function(form) {
        $.blockUI({ message:  '<img src="{{ URL::asset("public/assets/img/preloading-white.gif") }}" alt="" class="img-loader-cls"/>',css: { 
            border: 'none', 
            padding: '0px', 
            backgroundColor: 'transparent', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            color: '#fff' 
        } }); 
      var formData = new FormData(form);
      formData.append("_token", "{{ csrf_token() }}");
      var gotourl="{{ url('contact-us/store') }}";
      $.ajax({
          type:'POST',
          url: gotourl,
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data) {
            var jsonObj = JSON.parse(data);
            if(jsonObj.errorCode == 'Success') {
                $(form)[0].reset();
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
          },
          error: function(data){
              console.log("error");
              console.log(data);
          }
      });
    }
  });
});
</script>
@endsection