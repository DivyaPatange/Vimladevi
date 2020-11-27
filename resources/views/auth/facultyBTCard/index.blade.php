@extends('auth.authLayouts.main')
@section('title', 'Faculty BT Card')
@section('customcss')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block mt-4">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
    </div>
    @endif
    @if ($message = Session::get('danger'))
    <div class="alert alert-danger alert-block mt-4">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
    </div>
    @endif
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Faculty BT Card</h1>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    Add Faculty BT Card
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.faculty-bt-card.store') }}">
                    @csrf 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>BT Card No.</label>
                                    <input type="text" class="form-control form-control-user @error('BT_no') is-invalid @enderror" name="BT_no" id="exampleInputName" placeholder="Enter BT Card No." value="{{ old('BT_no') }}">
                                    @error('BT_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Name</label>
                                    <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" id="exampleInputName" placeholder="Enter Name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Department</label>
                                    <select class="form-control form-control-user @error('department') is-invalid @enderror" name="department" id="exampleInputName">
                                        <option value="">- Select Department -</option>
                                        @foreach($department as $d)
                                        <option value="{{ $d->id }}">{{ $d->department }}</option>
                                        @endforeach
                                    </select>
                                    @error('session')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Designation</label>
                                    <input type="text" class="form-control form-control-user @error('designation') is-invalid @enderror" name="designation" id="designation" placeholder="Enter Designation" value="{{ old('designation') }}">
                                    @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-user">
                                Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
    <div class="row">
        <div class="col-md-8">
          <h6 class="m-0 font-weight-bold text-primary">Faculty BT Card List</h6>
        </div>
        <div class="col-md-4">
          <select class="form-control form-control-user @error('department') is-invalid @enderror" id="department">
            <option value="">- Select Department -</option>
            @foreach($department as $d)
            <option value="{{ $d->id }}">{{ $d->department }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="data_table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>BT Card No.</th>
              <th>Name</th>
              <th>Department</th>
              <th>Designation</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Sr. No.</th>
              <th>BT Card No.</th>
              <th>Name</th>
              <th>Department</th>
              <th>Designation</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
         
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('adminAsset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('adminAsset/js/demo/datatables-demo.js') }}"></script>
<script>
$(document).ready(function(){
  fetch_data();
  function fetch_data(department = '')
  {
    // alert(academic_year = '');
    $('#data_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('admin.faculty-bt-card.index') }}",
      data: {department:department}
    },
    columns: [
    { data: 'id', name: 'id' },
    { data: 'BT_no', name: 'BT_no' },
    { data: 'name', name: 'name' },
    { data: 'department', name: 'department' },
    { data: 'designation', name: 'designation' },
    {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'asc']],
    });
  }
  $('#department').change(function(){
  var department_id = $('#department').val();
//  alert(academic_id);

  $('#data_table').DataTable().destroy();
 
  fetch_data(department_id);
 });
  
});
</script>
@endsection
