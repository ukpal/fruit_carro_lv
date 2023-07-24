@extends('layouts.admin')

@section('content')
<form action="{{ url('admin/contacts/store') }}" method="POST" id="contactFrm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" id="id" value="{{ $contact->id ?? '' }}">
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
      <div class="card-body">
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">First Name : </div>
                <div class="col-sm-10">{{ $contact->first_name ?? '' }}</div>
              </div>            
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">Last Name : </div>
                <div class="col-sm-10">{{ $contact->last_name ?? '' }}</div>
              </div> 
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">Email : </div>
                <div class="col-sm-10">{{ $contact->email ?? '' }}</div>
              </div> 
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">Phone Number : </div>
                <div class="col-sm-10">{{ $contact->phone_number ?? '' }}</div>
              </div>               
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">Message : </div>
                <div class="col-sm-10">{{ $contact->message ?? '' }}</div>
              </div> 
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2">Contact Date :</div>
                <div class="col-sm-10">{{ $contact->entry_date ?? '' }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
              <a href="{{ url('admin/contacts') }}"><button type="button" name="cancel" class="btn btn-secondary">Cancel</button></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
@endsection