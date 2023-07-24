@extends('layouts.admin')

@section('content')
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    
    <div class="table-container">
      <div class="table-responsive">
        <table id="basicExample" class="table custom-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last name</th>
              <th>Email</th>
              <th>Created Date</th>
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
			document.location.href="{{ url('admin/contacts/delete/') }}"+'/'+deleteId;
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
          'url':"{{ url('admin/contacts/ajax-table-data/') }}",
          'data': function ( d ) {
            return $.extend( {}, d, {
              "_token": token
            } );
          },
      },
      'columns': [
          { data: 'id' },
         { data: 'first_name' },
         { data: 'last_name' },
         { data: 'email' },
         { data: 'entry_date' },
         { 
            orderable : false,
            mRender: function (data, type, row) {
                var linkEdit = "{{ url('admin/contacts/details/') }}/"+row.id;
                linkEdit = '<a href="'+linkEdit+'"><span class="icon-assignment"></span></a>';
                var linkDelete = '<a href="javascript:void(0)" onclick="javascript:deleteData('+row.id+');"><span class="icon-delete"></span></a>';
                return linkEdit + linkDelete;
            }
        }
      ]
   });
});
</script>
@endsection