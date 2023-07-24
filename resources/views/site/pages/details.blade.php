@extends('layouts.site')

@section('content')
<div id="contact-detail" class="contact-detail">
    <div class="container">
    @php echo html_entity_decode($pageDetails->content); @endphp
    </div><!-- container /- -->
</div><!-- contact-detail /- -->
@endsection