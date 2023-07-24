@extends('layouts.site')

@section('content')
<div class="container">
    <!-- container fluid -->
    <div class="container-fluid p_z">
        <!-- col-md-9 -->
        <div class="col-md-9 col-sm-6 p_l_z content-area">
            <div class="blog-listing single-post col-md-12 p_z">
                <article>
                    @if (isset($blogDetails->blog_image) && $blogDetails->blog_image!= '')
                    <div class="entry-cover">
                        <img src="{{ URL::asset('public/uploads/blogs/normal/').'/'.$blogDetails->blog_image }}" alt="blog" />
                        <i class="fa fa-image"></i>
                    </div>
                    @endif
                    <div class="entry-header">
                        <h3 class="entry-title">{{ html_entity_decode($blogDetails->title) ?? '' }}</h3>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <a title="Blog Date"><i class="fa fa-clock-o"></i> Posted On {{ date('F d,Y', strtotime($blogDetails->entry_date)) }}</a>
                            </span>
                            <span class="byline">
                                <i class="fa fa-user"></i><a title="Author">{{ $blogDetails->first_name.' '.$blogDetails->last_name }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="entry-content">
                    {{ html_entity_decode($blogDetails->long_content) ?? '' }}
                    </div>
                </article>               
            </div>
        </div><!-- col-md-9 /- -->
        <!-- col-md-3 -->
        <div class="col-md-3 col-sm-6 p_r_z blog-sidebar widget-area">
           <!-- Widget Popular Post -->
            <aside class="widget widget-property-featured">
                <h2 class="widget-title">Popular<span>Post</span></h2>
                @if ($popularBlogs)
                    @foreach ($popularBlogs as $popularBlogs1)
                <div class="property-featured-inner">
                    @if (isset($popularBlogs1->blog_image) && $popularBlogs1->blog_image!= '')
                    <div class="col-md-4 col-sm-3 col-xs-2 p_z">
                        <a title="Popular Post" href="{{ url('/').'/'.$popularBlogs1->slug }}"><img src="{{ URL::asset('public/uploads/blogs/normal/').'/'.$popularBlogs1->blog_image }}" alt="feacture1"></a>
                    </div>
                    @endif
                    <div class="col-md-8 col-sm-9 col-xs-10 featured-content">
                        <a title="Popular Post" href="{{ url('/').'/'.$popularBlogs1->slug }}">{{ html_entity_decode($popularBlogs1->title) ?? '' }}</a>
                        <span><i class="fa fa-clock-o"></i> {{ date('F d,Y', strtotime($popularBlogs1->entry_date)) }}</span>
                    </div>
                </div>
                    @endforeach
                @endif
            </aside><!-- Widget Popular Post /- -->
            
            <!-- Widget Featured Property -->
            <aside class="widget widget-property-featured">
                <h2 class="widget-title">featured<span>property</span></h2>
                @if ($featureProperties)
                    @foreach ($featureProperties as $featureProperties1)
                <div class="property-featured-inner">
                    @if (isset($featureProperties1->property_image) && $featureProperties1->property_image!= '')
                    <div class="col-md-4 col-sm-3 col-xs-2 p_z">
                        <a title="Featured Post" href="{{ url('/').'/'.$featureProperties1->slug }}"><img src="{{ URL::asset('public/uploads/property_files/images/normal/').'/'.$featureProperties1->property_image }}" alt="feacture1"></a>
                    </div>
                    @endif
                    <div class="col-md-8 col-sm-9 col-xs-10 featured-content">
                        <a title="Featured Post" href="{{ url('/').'/'.$featureProperties1->slug }}">{{ $featureProperties1->street_address.' '.$featureProperties1->unit_number }}</a>
                        <h3>&dollar;{{ $featureProperties1->rent_amount ?? '' }}</h3>
                    </div>
                </div>
                    @endforeach
                @endif
            </aside><!-- Widget Featured Property /- -->
        </div><!-- col-md-3 /- -->
    </div><!-- container fluid /- -->
</div><!-- container /- -->
@endsection