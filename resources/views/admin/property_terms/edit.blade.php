@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/property-terms/store') }}" method="POST" id="propertyTermFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $propertyTerm->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Title *</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $propertyTerm->title ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Slug </label>
              <div class="row">
                <div class="col-12">
                  <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ $propertyTerm->slug ?? '' }}">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Value *</label>
              <input type="text" class="form-control" name="value" id="value" placeholder="Value" value="{{ $propertyTerm->value ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Value Type</label>
              <input type="radio" name="value_type" value="Day" {{ ($propertyTerm->value_type == 'Day' || $propertyTerm->value_type == '') ? 'checked' : '' }}>&nbsp;Day&nbsp;&nbsp;<input type="radio" name="value_type" value="Month" {{ ($propertyTerm->status == 'Month') ? 'checked' : '' }}>&nbsp;Month&nbsp;&nbsp;<input type="radio" name="value_type" value="Year" {{ ($propertyTerm->status == 'Year') ? 'checked' : '' }}>&nbsp;Year
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($propertyTerm->status == 'Active' || $propertyTerm->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($propertyTerm->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/property-types') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
  $("#propertyTermFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      title: "required",
      value: "required"
    },
    messages: {
      title: "Please provide title",
      value: "Please provide value"
    },
    submitHandler: function(form) {
      var title = $("#title").val();
      var id = $("#id").val();
      var slug = $("#slug").val();
      var token = "{{ csrf_token() }}";
      var gotourl="{{ url('admin/property-terms') }}"+'/get-slug-url';
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
      var gotourl="{{ url('admin/property-terms') }}"+'/get-slug-url';
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
      var gotourl="{{ url('admin/property-terms') }}"+'/get-slug-url';
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