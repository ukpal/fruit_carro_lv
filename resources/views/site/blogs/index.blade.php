@extends('layouts.site')

@section('content')
<div class="container">
    <!-- container fluid -->
    <div class="container-fluid p_z">
        <!-- col-md-9 -->
        <div class="col-md-12 col-sm-6 p_l_z content-area">
            @if ($blogs)
            <div class="blog-listing">
                @foreach ($blogs as $blogs1)
                <article>
                    <div class="entry-cover">
                        @if (isset($blogs1->blog_image) && $blogs1->blog_image!= '')
                        <a title="entry-cover" href="{{ url('/').'/'.$blogs1->slug }}"><img src="{{ URL::asset('public/uploads/blogs/normal/').'/'.$blogs1->blog_image }}" alt="blog" /></a>
                        <i class="fa fa-image"></i>
                        @endif
                    </div>
                    <div class="entry-header">
                        <h3 class="entry-title"><a href="{{ url('/').'/'.$blogs1->slug }}" title="Blog Title">{{ html_entity_decode($blogs1->title) ?? '' }}</a></h3>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <a title="Blog Date" href="{{ url('/').'/'.$blogs1->slug }}"><i class="fa fa-clock-o"></i> Posted On {{ date('F d,Y', strtotime($blogs1->entry_date)) }}</a>
                            </span>
                            <span class="byline">
                                <i class="fa fa-user"></i><a title="Author" href="{{ url('/').'/'.$blogs1->slug }}">{{ $blogs1->first_name.' '.$blogs1->last_name }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="entry-content">
                        <p>{{ strip_tags(html_entity_decode($blogs1->short_content)) ?? '' }}</p>
                        <a href="{{ url('/').'/'.$blogs1->slug }}" title="Read more" class="read-more">Read More</a>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
        </div><!-- col-md-9 /- -->
        <!-- col-md-3 -->
    </div><!-- container fluid /- -->
</div><!-- container /- -->
@endsection