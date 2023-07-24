@extends('layouts.site')

@section('content')

<section class="main-wrap">
    <div class="container">
        <div class="row">
@include('layouts.site_profile_menu')
            <div class="col-sm-9">
                <div class="rt-sec">
                    <div class="details-hdr">
                        <h2>Change Password</h2>
                    </div>
                    <div class="row mar-top">
                        <div class="col-md-offset-1 col-md-10">
                            <form class="form-horizontal" role="form"> 
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Email Id :</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Old Password :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-sm-3">New Password :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>                             
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-login">Submit</button>
                                    </div>
                                </div>                 
                            </form>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</section>
<script>

</script>
@endsection