@extends('layouts.site')

@section('content')
<div class="property-main-details">
    <!-- container -->
    <div class="container">
        <div class="property-header">
            <ul>
                <li>${{ $propertyDetails->rent_amount ?? '' }}</li>
                <li>{{ $propertyDetails->street_address ?? '' }}</li>
                <li><i class="fa fa-expand"></i>{{ $propertyDetails->unit_number ?? '' }}</li>
            </ul>
        </div>
        <div class="property-details-content container-fluid p_z">
            <!-- col-md-9 -->
            <div class="col-md-9 col-sm-6 p_z">
                <!-- Slider Section -->
                @if (isset($propertyDetails->property_image) && $propertyDetails->property_image!= '')
                <div id="property-detail1-slider" class="carousel slide property-detail1-slider" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div role="listbox">
                        <div class="item active">
                            <img src="{{ URL::asset('public/uploads/property_files/images/normal/').'/'.$propertyDetails->property_image }}" alt="Slide">
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#property-detail1-slider" role="button" data-slide="prev">
                        <span class="fa fa-long-arrow-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#property-detail1-slider" role="button" data-slide="next">
                        <span class="fa fa-long-arrow-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div><!-- Slider Section /- -->
                @endif
                <div class="single-property-details">
                    <h3>Description</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ullamcorper libero sed ante auctor vel gravida nunc placerat. Suspendisse molestie posuere sem, in viverra dolor venenatis sit amet. Aliquam gravida nibh quis justo pulvinar luctus. Phasellus a malesuada massa. Mauris elementum tempus nisi, vitae ullamcorper sem ultricies vitae. Nullam consectetur lacinia nisi, quis laoreet magna pulvinar in. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In hac habitasse platea dictumst. Cum sociis natoque penatibus et magnis.dis parturient montes, nascetur ridiculus mus.</p>
                </div>
                <div class="property-direction pull-left">
                    <h3>Get Direction</h3>
                    <div class="property-map">
                        <div id="gmap" class="mapping"></div>
                    </div>
                    <div class="property-map">
                        <h3>Share This Property :</h3>
                        <ul>
                            <li><a href="#" title="twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" title="facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" title="google-plus"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#" title="linkedin-square"><i class="fa fa-linkedin-square"></i></a></li>
                            <li><a href="#" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#" title="instagram"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- col-md-9 /- -->
            <div class="col-md-3 col-sm-6 p_z property-sidebar single-property-sidebar">
                <div class="agent-details">
                    <div class="agent-header">
                        <div class="agent-img"><img src="{{ URL::asset('public/uploads/profile_images/normal/').'/'.$propertyDetails->profile_image }}" alt="agent" /></div>
                        <div class="agent-name">
                            <h5>Landlord {{ $propertyDetails->first_name.' '.$propertyDetails->last_name }}</h5>
                        </div>
                        <p>Our Latest listed properties and check out the facilities on them test listed properties.</p>
                    </div>
                    <p><i class="fa fa-phone"></i>{{ $propertyDetails->phone_number ?? '' }}</p>
                    <p><i class="fa fa-envelope-o"></i><a href="mailto:{{ $propertyDetails->email ?? '' }}" title="mail">{{ $propertyDetails->email ?? '' }}</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- container /- -->
</div><!-- Property Detail Page /- -->
@endsection