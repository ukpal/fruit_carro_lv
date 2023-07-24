@extends('layouts.admin')

@section('content')
<style>

</style>
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    
    <div class="table-container">
      <div class="t-header"><a href="{{ url('admin/menus/edit') }}"><button type="button" class="btn btn-danger btn-rounded">Add</button></a></div>
      <div class="table-responsive">
        <div class="cf nestable-lists">
          <div class="dd" id="nestable">
                <ol class="dd-list" id="ddList">
                    @php echo $allMenus @endphp
                </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function deleteData(deleteId) {
	swal({
      title: "Are you sure?",
      text: "Do you want to delete data?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
		if (willDelete) {
			document.location.href="{{ url('admin/menus/delete/') }}"+'/'+deleteId;
		}
	});
}
$(document).ready(function(){
   var updateOutput = function(e) {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
          $.blockUI({ message:  '<img src="{{ URL::asset("public/assets/img/preloading-white.gif") }}" alt="" class="img-loader-cls"/>',css: { 
              border: 'none', 
              padding: '0px', 
              backgroundColor: 'transparent', 
              '-webkit-border-radius': '10px', 
              '-moz-border-radius': '10px', 
              color: '#fff' 
          } }); 
          var token = "{{ csrf_token() }}";
          var gotourl="{{ url('admin/menus') }}"+'/update-serialize-menus';
          $.ajax({
                type: "POST",
                url: gotourl,
                data: { _token: token, serialize_data : window.JSON.stringify(list.nestable('serialize')) },
                dataType: "text",
                cache:false,
                success:
                      function(data){
                        $("#ddList").html(data);
                        $.unblockUI(); 
                  }
          });
            //alert(window.JSON.stringify(list.nestable('serialize')));
            //output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    $('#nestable3').nestable();
});
</script>
@endsection