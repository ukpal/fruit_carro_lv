@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/pages/store') }}" method="POST" id="pageFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $page->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Title *</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $page->title ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Slug </label>
              <div class="row">
                <div class="col-12">
                  <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ $page->slug ?? '' }}">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Content</label>
              <textarea class="form-control ckeditor" name="content" id="content">{{ html_entity_decode($page->content) ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($page->status == 'Active' || $page->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($page->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/pages') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
<script>
$(document).ready(function(e) {
  $("#pageFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      title: "required"
    },
    messages: {
      title: "Please provide title"
    },
    submitHandler: function(form) {
      var title = $("#title").val();
      var id = $("#id").val();
      var slug = $("#slug").val();
      var token = "{{ csrf_token() }}";
      var gotourl="{{ url('admin/pages') }}"+'/get-slug-url';
      $.ajax({
             type: "POST",
             url: gotourl,
             data: { _token: token, title : title,slug : slug, id : id },
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    $("#slug").val(data);
                    $(form)[0].submit();
              }
      });
      return false;
    }
  });

  $('#title').donetyping(function(){
    var title = $("#title").val();
    var id = $("#id").val();
    var token = "{{ csrf_token() }}";
    if(slug != '') {
      var gotourl="{{ url('admin/pages') }}"+'/get-slug-url';
      $.ajax({
             type: "POST",
             url: gotourl,
             data: { _token: token, title : title, id : id },
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    $("#slug").val(data);
              }
      });
    } else {
      $("#slug").val('');
    }
  });

  $('#slug').donetyping(function(){
    var title = $("#slug").val();
    var id = $("#id").val();
    var token = "{{ csrf_token() }}";
    if(slug != '') {
      var gotourl="{{ url('admin/pages') }}"+'/get-slug-url';
      $.ajax({
             type: "POST",
             url: gotourl,
             data: { _token: token, title : title, id : id },
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    $("#slug").val(data);
              }
      });
    } else {
      $("#slug").val('');
    }
  });
});
</script>
@endsection