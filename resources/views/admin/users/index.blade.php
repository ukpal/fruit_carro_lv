@extends('layouts.admin')

@section('content')
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    
    <div class="table-container">
      <div class="t-header"><a href="{{ url('admin/users/edit') }}"><button type="button" class="btn btn-danger btn-rounded">Add</button></a></div>
      <div class="table-responsive">
        <table id="basicExample" class="table custom-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Username</th>
              <th>User Type</th>
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
			document.location.href="{{ url('admin/users/delete/') }}"+'/'+deleteId;
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
          'url':"{{ url('admin/users/ajax-table-data/') }}",
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
         { data: 'username' },
         { data: 'user_type' },
         { data: 'status' },
         { 
            orderable : false,
            mRender: function (data, type, row) {
                var linkEdit = "{{ url('admin/users/edit/') }}/"+row.id;
                linkEdit = '<a href="'+linkEdit+'"><span class="icon-edit"></span></a>';
                var linkDelete = '<a href="javascript:void(0)" onclick="javascript:deleteData('+row.id+');"><span class="icon-delete"></span></a>';
                return linkEdit + linkDelete;
            }
        }
      ]
   });
});
</script>
@endsection