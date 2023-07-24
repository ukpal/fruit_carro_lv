@extends('layouts.site')

@section('content')
<div id="property-listing" class="property-listing">
    <div class="container">
        <div class="property-left col-md-12 col-sm-6 p_l_z content-area">
            <div class="section-header p_l_z">
                <div class="col-md-10 col-sm-10 p_l_z">
                    <p>property</p>
                    <h3>listing</h3>
                </div>
            </div>
            @if ($properties)
            <div class="property-listing-row row">
                @php
                    $i = 0;
                @endphp
                @foreach ($properties as $properties1)
                <!-- Col-md-4 -->
                <div class="col-md-4 col-sm-12 rent-block">
                    <!-- Property Main Box -->
                    <div class="property-main-box">
                        @if (isset($properties1->property_image) && $properties1->property_image!= '')
                        <div class="property-images-box">
                            <span>R</span>
                            <a title="Property Image" href="{{ url('/').'/'.$properties1->slug }}"><img src="{{ URL::asset('public/uploads/property_files/images/normal/').'/'.$properties1->property_image }}" alt="featured" /></a>
                            <h4>&dollar;{{ $properties1->rent_amount ?? '' }}</h4>
                        </div>
                        @endif
                        <div class="clearfix"></div>
                        <div class="property-details">
                            <a title="Property Title" href="{{ url('/').'/'.$properties1->slug }}">{{ $properties1->street_address ?? '' }}</a>
                            <ul>
                                <li><i class="fa fa-expand"></i>{{ $properties1->unit_number ?? '' }}</li>
                            </ul>
                        </div>
                    </div><!-- Property Main Box /- -->
                </div><!-- Col-md-4 /- -->
                @php
                    $i++;
                @endphp
                @endforeach
                <!-- Col-md-4 -->
            </div>
            @endif	
        </div>
    </div>
</div><!-- Property Listing Section /- -->
@endsection