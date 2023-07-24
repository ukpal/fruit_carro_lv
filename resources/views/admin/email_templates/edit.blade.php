@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/email-templates/store') }}" method="POST" id="emailTemplateFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $emailTemplate->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Title</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $emailTemplate->title ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Content</label>
              <textarea class="form-control ckeditor" name="content" id="content">{{ html_entity_decode($emailTemplate->content) ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($emailTemplate->status == 'Active' || $emailTemplate->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($emailTemplate->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/email-templates') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
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
  $("#emailTemplateFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      title: "required"
    },
    messages: {
      title: "Please provide title"
    }
  });
});
</script>
@endsection