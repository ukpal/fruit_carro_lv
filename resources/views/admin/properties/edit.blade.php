@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/properties/store') }}" method="POST" id="propertyFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $property->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName"> Landlord *</label>
              <select name="user_id" id="user_id" class="form-control">
                <option value="">Select Landlord</option>
@if ($users)
  @foreach ($users as $users1)
                <option value="{{ $users1->id }}" {{ ($users1->id == $property->user_id) ? 'selected' : '' }}>@php echo $users1->first_name.' '.$users1->last_name; @endphp</option>
  @endforeach
@endif
              </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Property Type *</label>
              <select name="property_type_id" id="property_type_id" class="form-control">
                <option value="">Select Property Type</option>
@if ($propertyTypes)
  @foreach ($propertyTypes as $propertyTypes1)
                <option value="{{ $propertyTypes1->id }}" {{ ($propertyTypes1->id == $property->property_type_id) ? 'selected' : '' }}>{{ $propertyTypes1->title }}</option>
  @endforeach
@endif
              </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Title *</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $property->title ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Slug </label>
              <div class="row">
                <div class="col-12">
                  <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ $property->slug ?? '' }}">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Price *</label>
              <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="{{ $property->price ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Area </label>
              <input type="text" class="form-control" name="area" id="area" placeholder="Area" value="{{ $property->area ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Bedrooms</label>
              <input type="text" class="form-control" name="bedrooms" id="bedrooms" placeholder="Bedrooms" value="{{ $property->bedrooms ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Bathrooms</label>
              <input type="text" class="form-control" name="bathrooms" id="bathrooms" placeholder="Bathrooms" value="{{ $property->bathrooms ?? '' }}">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Rent Term *</label>
              <select name="rent_term" id="rent_term" class="form-control">
                <option value="">Select</option>
@if ($propertyTerms)
  @foreach ($propertyTerms as $propertyTerms1)
                <option value="{{ $propertyTerms1->id }}" {{ ($propertyTerms1->id == $property->rent_term) ? 'selected' : '' }}>{{ $propertyTerms1->title }}</option>
  @endforeach
@endif
              </select>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Short Content</label>
              <textarea class="form-control" name="short_content" id="short_content">{{ html_entity_decode($property->short_content) ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="fullName">Long Content</label>
              <textarea class="form-control ckeditor" name="long_content" id="long_content">{{ html_entity_decode($property->long_content) ?? '' }}</textarea>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Property Image</label>
              <div class="row">
                <div class="col-10">
                <input type="file" class="form-control" name="property_image" id="property_image">
                </div>
                <div class="col-2" id="property_image_div">
                @if (isset($property->property_image) && $property->property_image!= '')
                <img src="{{ URL::asset('public/uploads/property_files/images/thumb/').'/'.$property->property_image }}">
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="eMail">Gallery Images</label>
              <div class="row">
                <div class="col-12">
                  <div class="form-group row" id="div_gallery">
                      <div class="col-sm-12">
                        <input type="file" name="file[]" id="file" multiple>
                        <!-- Drag and Drop container-->
                        <div class="upload-area"  id="uploadfile">
                            <h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group" id="postGallery">
@if ($propertyGalleries)
<div class="container">
  <div class="card-columns">
  @foreach ($propertyGalleries as $propertyGalleries1)
          <div class="card">
              <span class="close" onclick="javascript:deleteGallery('{{ $propertyGalleries1->id }}')">&times;</span>

    @if ($propertyGalleries1->file_type == 'Image' && isset($propertyGalleries1->file_name) && $propertyGalleries1->file_name != '')
              <img src="{{ URL::asset('public/uploads/property_files/images/normal/').'/'.$propertyGalleries1->file_name }}" class="card-img-top">
    @endif
          </div>
  @endforeach
  </div>
</div>
@endif

            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label for="phone">Status</label>
              <input type="radio" name="status" value="Active" {{ ($property->status == 'Active' || $property->status == '') ? 'checked' : '' }}>&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" value="Inactive" {{ ($property->status == 'Inactive') ? 'checked' : '' }}>&nbsp;Inactive
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <button type="submit" name="site_settings" class="btn btn-primary">Submit</button>
              <a href="{{ url('admin/properties') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
<script>
function readURL(input,getVal) {
  if (input.files && input.files[0]) {
    var extension=$('#'+getVal).val().replace(/^.*\./, '');
    if(extension.toLowerCase() == 'jpg' || extension.toLowerCase() == 'gif' ||extension.toLowerCase() == 'jpeg' || extension.toLowerCase() == 'png' || extension.toLowerCase() == 'ico') {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#'+getVal+"_div").html('<img src="'+e.target.result+'" alt="" height="150" width="150">');
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    } else {
      $('#'+getVal+"_div").html('');
    }
  }
}
function deleteGallery(fileId) {
  var token = "{{ csrf_token() }}";
  var gotourl="{{ url('admin/properties') }}/delete-gallery";
  $.ajax({
        type: "POST",
        url: gotourl,
        data: { _token: token,file_id : fileId},
        dataType: "text",
        cache:false,
        success:
              function(data){
                $("#postGallery").html(data);
          }
  });
}

// Sending AJAX request and upload file
function uploadData(formdata) {
    $.ajax({
        url: "{{ url('admin/properties') }}/upload-gallery-files",
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
            $('#uploadfile').unblock(); 
            console.log(response);
            if(response.length == 0) {
              swal(
                'Alert!',
                "Please upload a valid image",
                'error'
              );
            } else {
              for (var x = 0; x < response.length; x++) {
                addThumbnail(response[x]);
              }
            }
        }
    });
}

// Added thumbnail
function addThumbnail(data) {
    $("#uploadfile h1").remove();
    var len = $("#uploadfile div.thumbnail").length;

    var num = Number(len);
    num = num + 1;

    var name = data.name;
    var size = convertSize(data.size);
    var src = data.path;
    var file_type = data.file_type;

    // Creating an thumbnail
    $("#uploadfile").append('<div id="thumbnail_'+num+'" class="thumbnail" title="'+name+'"></div>');
    $("#thumbnail_"+num).click(false);
    if(file_type == 'Image') {
      $("#thumbnail_"+num).append('<img src="'+src+'" alt="'+name+'" id="image_'+num+'">');
    } else {
      $("#thumbnail_"+num).append('<video width="150" height="100" controls class="card-img-top"><source src="'+src+'" type="video/mp4">Your browser does not support the video tag.</video>');
    }
    $("#thumbnail_"+num).append('<div>'+size+'</div>');
    $("#thumbnail_"+num).append('<div><a href="javascript:void(0)" onclick="javascript:removeFile(\''+name+'\','+num+');">Remove</a></div>');
}

// Bytes conversion
function convertSize(size) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (size == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
    return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function removeFile(fileName,num) {
  var token = "{{ csrf_token() }}";
  $.ajax({
      url: "{{ url('admin/properties') }}/delete-gallery-files",
      type: "POST",
      data: { _token: token,file_name : fileName},
      dataType: "text",
      cache:false,
      success: function(response){
          if(response == 'Success') {
            $("#thumbnail_"+num).remove();
            if($("#uploadfile div.thumbnail").length == 0) {
              $("#uploadfile").html("<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>");
            }
          }
      }
  });
}

$(document).ready(function(e) {
  $("#propertyFrm").validate({
    ignore: [],
    debug: false,
    rules: {
      user_id: "required",
      property_type_id: "required",
      title: "required",
      price: "required",
      rent_term: "required"
    },
    messages: {
      user_id: "Please select landlord",
      property_type_id: "Please select property type",
      title: "Please provide title",
      price: "Please provide price",
      rent_term: "Please select rent term"
    },
    submitHandler: function(form) {
      var title = $("#title").val();
      var id = $("#id").val();
      var slug = $("#slug").val();
      var token = "{{ csrf_token() }}";
      var gotourl="{{ url('admin/properties') }}"+'/get-slug-url';
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
      var gotourl="{{ url('admin/properties') }}"+'/get-slug-url';
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
      var gotourl="{{ url('admin/properties') }}"+'/get-slug-url';
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

  // preventing page from redirecting
  $("html").on("dragover", function(e) {
      e.preventDefault();
      e.stopPropagation();
      $("h1").text("Drag here");
  });
  $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });
  // Drag enter
  $('.upload-area').on('dragenter', function (e) {
      e.stopPropagation();
      e.preventDefault();
      $("h1").text("Drop");
  });
  // Drag over
  $('.upload-area').on('dragover', function (e) {
      e.stopPropagation();
      e.preventDefault();
      $("h1").text("Drop");
  });
  // Drop
  $('.upload-area').on('drop', function (e) {
    $('#uploadfile').block({ message:  '<img src="{{ URL::asset("public/assets/img/preloading-white.gif") }}" alt="" class="img-loader-cls"/>',css: { 
          border: 'none', 
          padding: '0px', 
          backgroundColor: 'transparent', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          color: '#fff' 
      } });
      e.stopPropagation();
      e.preventDefault();
      $("h1").text("Upload");
      var file = e.originalEvent.dataTransfer.files;
      var fd = new FormData();
      for (var x = 0; x < file.length; x++) {
        fd.append('uploaded_files'+x,file[x]);
      }
      fd.append('fileCount', file.length);
      fd.append( "_token", "{{ csrf_token() }}" );
      uploadData(fd);
  });
  // Open file selector on div click
  $("#uploadfile").click(function(){
      $("#file").click();
  });
  // file selected
  $("#file").change(function(){
    $('#uploadfile').block({ message:  '<img src="{{ URL::asset("public/assets/img/preloading-white.gif") }}" alt="" class="img-loader-cls"/>',css: { 
          border: 'none', 
          padding: '0px', 
          backgroundColor: 'transparent', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          color: '#fff' 
      } });
      var fd = new FormData();
      for (var x = 0; x < $('#file')[0].files.length; x++) {
        fd.append('uploaded_files'+x,$('#file')[0].files[x]);
      }
      fd.append('fileCount', $('#file')[0].files.length);
      fd.append( "_token", "{{ csrf_token() }}" );
      uploadData(fd);
  });
});
</script>
@endsection