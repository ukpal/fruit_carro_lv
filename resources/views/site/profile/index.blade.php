@extends('layouts.site')

@section('content')

<section class="main-wrap">
    <div class="container">
        <div class="row">
@include('layouts.site_profile_menu')
            <div class="col-sm-9">
                <div class="rt-sec">
                    <div class="details-hdr">
                        <h2>Personal Info</h2>
                        <a href="#" class="btn-edit">Edit</a>
                    </div>
                    <div class="row">
                        <div class="custom-fld col-sm-6">
                            <h4>First Name <span>{{ $userDetails->first_name ?? '' }}</span></h4>
                        </div>
                        <div class="custom-fld col-sm-6">
                            <h4>Last Name <span>{{ $userDetails->last_name ?? '' }}</span></h4>
                        </div>
                        <div class="custom-fld col-sm-6">
                            <h4>Date of birth <span>{{ $userDetails->date_of_birth ?? '' }}</span></h4>
                        </div>
                    </div>
                    <div class="devider"></div>
                    <div class="details-hdr">
                        <h2>Contact Info</h2>
                        <a href="#" class="btn-edit">Edit</a>
                    </div>
                    <div class="row">
                        <div class="custom-fld col-sm-6">
                            <h4>Contact Number <span>{{ $userDetails->phone_number ?? '' }}</span></h4>
                        </div>
                        <div class="custom-fld col-sm-6">
                            <h4>Contact Email ID <span>{{ $userDetails->email ?? '' }}</span></h4>
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