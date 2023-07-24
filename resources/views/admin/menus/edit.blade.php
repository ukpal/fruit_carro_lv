@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/menus/store') }}" method="POST" id="menuFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $menu->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Title *</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $menu->title ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Slug </label>
              <div class="row">
                <div class="col-12">
                  <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ $menu->slug ?? '' }}">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Parent Menu *</label>
              <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Select Menu</option>
@if ($parentMenus)
  @foreach ($parentMenus as $parentMenus1)
                <option value="{{ $parentMenus1->id }}" {{ ($parentMenus1->id == $menu->parent_id) ? 'selected' : '' }}>{{ $parentMenus1->title }}</option>
  @endforeach
@endif
              </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Page *</label>
              <select name="page_id" id="page_id" class="form-control">
                <option value="">Select Page</option>
@if ($pages)
  @foreach ($pages as $pages1)
                <option value="{{ $pages1->id }}" {{ ($pages1->id == $menu->page_id) ? 'selected' : '' }}>{{ $pages1->title }}</option>
  @endforeach
@endif
              </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($menu->status == 'Active' || $menu->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($menu->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/menus') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
  $("#menuFrm").validate({
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
      var gotourl="{{ url('admin/menus') }}"+'/get-slug-url';
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
    if(title != '') {
      var gotourl="{{ url('admin/menus') }}"+'/get-slug-url';
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
    if(title != '') {
      var gotourl="{{ url('admin/menus') }}"+'/get-slug-url';
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