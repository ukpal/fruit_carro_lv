@extends('layouts.admin')

@section('content')
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    
    <div class="table-container">
      <div class="t-header"><a href="{{ url('admin/properties/edit') }}"><button type="button" class="btn btn-danger btn-rounded">Add</button></a></div>
      <div class="table-responsive">
      
      <table id="basicExample" class="table custom-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Price</th>
              <th>Property Type</th>
              <th>Entry Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

        </table>
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
			document.location.href="{{ url('admin/properties/delete/') }}"+'/'+deleteId;
		}
	});
}
$(document).ready(function(){
  var token = "{{ csrf_token() }}";
   $('#basicExample').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'type' : "POST",
          'url':"{{ url('admin/properties/ajax-table-data/') }}",
          'data': function ( d ) {
            return $.extend( {}, d, {
              "_token": token
            } );
          },
      },
      'columns': [
          { data: 'id' },
         { data: 'title' },
         { data: 'price' },
         { data: 'property_type_title' },
         { data: 'entry_date' },
         { data: 'status' },
         { 
            orderable : false,
            mRender: function (data, type, row) {
                var linkEdit = "{{ url('admin/properties/edit/') }}/"+row.id;
                linkEdit = '<a href="'+linkEdit+'"><i class="icon-edit"></i></a>';
                var linkDelete = '<a href="javascript:void(0)" onclick="javascript:deleteData('+row.id+');"><i class="icon-delete"></i></a>';
                return linkEdit + linkDelete;
            }
        }
      ]
   });

   var updateOutput = function(e) {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            console.log(list);
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