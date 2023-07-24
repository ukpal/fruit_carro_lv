@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/packages/store') }}" method="POST" id="packageFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $package->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Title *</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $package->title ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Slug </label>
              <div class="row">
                <div class="col-12">
                  <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ $package->slug ?? '' }}">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Price *</label>
              <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="{{ $package->price ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Months *</label>
              <select name="months" id="months" class="form-control">
                <option value="">Select</option>
<?php
for($i = 1; $i <= 24; $i++) {
?>
        <option value="<?php echo $i; ?>" {{ (isset($package->months) &&$package->months == $i) ? 'selected' : '' }}><?php echo $i; ?></option>
<?php
}
?>
      </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Content</label>
              <textarea class="form-control ckeditor" name="content" id="content">{{ html_entity_decode($package->content) ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($package->status == 'Active' || $package->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($package->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/packages') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
  $("#packageFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      title: "required",
      price: {
        required: true,
        number: true
      },
      months: "required",
    },
    messages: {
      title: "Please provide title",
      price: {
        required: "Please provide price",
        number: "Please provide valid price"
      },
      months: "Please select months",
    }
  });

  $('#title').donetyping(function(){
    var title = $("#title").val();
    var id = $("#id").val();
    var token = "{{ csrf_token() }}";
    if(title != '') {
      var gotourl="{{ url('admin/packages') }}"+'/get-slug-url';
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
      var gotourl="{{ url('admin/packages') }}"+'/get-slug-url';
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