@extends('auth.authLayouts.main')
@section('title', 'Student BT Card')
@section('customcss')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
<link href="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
    <h1 class="h3 mb-2 text-gray-800">Student BT Card</h1>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    Add Student BT Card
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.student-bt-card.store') }}">
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
                                    <label>Class</label>
                                    <select class="form-control form-control-user @error('class') is-invalid @enderror" name="class" id="exampleInputName">
                                        <option value="">- Select Class -</option>
                                        @foreach($course as $c)
                                        <option value="{{ $c->id }}">{{ $c->course_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group ">
                                  <label>Class Year</label>
                                  <input type="text" class="form-control form-control-user @error('class_year') is-invalid @enderror" name="class_year" id="exampleInputName" placeholder="Enter Class Year" value="{{ old('class_year') }}">
                                  @error('class_year')
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
                                    @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Session</label>
                                    <select class="form-control form-control-user @error('session') is-invalid @enderror" name="session" id="exampleInputName">
                                        <option value="">- Select Session -</option>
                                        @foreach($academicYear as $a)
                                        <option value="{{ $a->id }}">({{ $a->from_academic_year }}) - ({{ $a->to_academic_year }})</option>
                                        @endforeach
                                    </select>
                                    @error('session')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-check">
                              <input type="checkbox" name="book_bank" class="form-check-input" id="exampleCheck1" value="1">
                              <label class="form-check-label" for="exampleCheck1">Book Bank</label>
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
          <h6 class="m-0 font-weight-bold text-primary">Student BT Card List</h6>
        </div>
        <div class="col-md-4">
          <?php
              $date = date('Y-m-d');
          ?>
          <select class="form-control form-control-user @error('academic_year') is-invalid @enderror" name="academic_year" id="academic_year">
            <option value="">- Select Academic Year -</option>
            @foreach($academicYear as $a)
            <option value="{{ $a->id }}" @if (($date >= $a->from_academic_year) && ($date <= $a->to_academic_year)) selected @endif
  >({{ $a->from_academic_year }}) - ({{ $a->to_academic_year }})</option>
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
              <th>Class</th>
              <th>Class Year</th>
              <th>Department</th>
              <th>Book Bank</th>
              <th>Session</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Sr. No.</th>
              <th>BT Card No.</th>
              <th>Name</th>
              <th>Class</th>
              <th>Class Year</th>
              <th>Department</th>
              <th>Book Bank</th>
              <th>Session</th>
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

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Promote BT Card</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" >
            <!-- Modal body -->
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group ">
                    <label>Class Year<span style="color:red;">*</span></label><span  style="color:red" id="year_err"> </span>
                    <input type="text" class="form-control form-control-user @error('class_year') is-invalid @enderror" name="class_year" id="class_year" placeholder="Enter Class Year">
                    @error('class_year')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group ">
                    <label>Session<span style="color:red;">*</span></label><span  style="color:red" id="session_err"> </span>
                    <select class="form-control form-control-user @error('session') is-invalid @enderror" name="session" id="session">
                        <option value="">- Select Session -</option>
                        @foreach($academicYear as $a)
                        <option value="{{ $a->id }}">({{ $a->from_academic_year }}) - ({{ $a->to_academic_year }})</option>
                        @endforeach
                    </select>
                    @error('session')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-check">
                    <input type="checkbox" name="book_bank" class="form-check-input" id="book_bank" value="1">
                    <label class="form-check-label" for="exampleCheck1">Book Bank<span style="color:red;">*</span></label><span  style="color:red" id="book_err"> </span>
                  </div>
                </div>
              </div>
            </div>
        
            <!-- Modal footer -->
            <div class="modal-footer">
              <input type="hidden" name="id" id="id" value="">
              <input type="hidden" name="BT_no" id="BT_no" value="">
              <input type="hidden" name="name" id="name" value="">
              <input type="hidden" name="class" id="classes" value="">
              <input type="hidden" name="department" id="department" value="">
            <button type="button" class="btn btn-success" id="editBrand" onclick="return checkSubmit()">Promote</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
        
      </div>
    </div>
</div>
@endsection
@section('customjs')
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
<!-- Page level plugins -->
<script src="{{ asset('adminAsset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('adminAsset/js/demo/datatables-demo.js') }}"></script>


<script>
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$(document).ready(function(){
  fetch_data();
  function fetch_data(academic = '')
  {
    // alert(academic_year = '');
    $('#data_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('admin.student-bt-card.index') }}",
      data: {academic:academic}
    },
    columns: [
    { data: 'id', name: 'id' },
    { data: 'BT_no', name: 'BT_no' },
    { data: 'name', name: 'name' },
    { data: 'class', name: 'class' },
    { data: 'class_year', name: 'class_year' },
    { data: 'department', name: 'department' },
    { data: 'book_bank', name: 'book_bank' },
    { data: 'session', name: 'session' },
    {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'asc']],
    });
  }
  $('#academic_year').change(function(){
  var academic_id = $('#academic_year').val();
//  alert(academic_id);

  $('#data_table').DataTable().destroy();
 
  fetch_data(academic_id);
 });
  
});

function Promote(obj,bid)
{
  var datastring="bid="+bid;
  // alert(datastring);
  $.ajax({
    type:"POST",
    url:"{{ route('admin.get.studentBT') }}",
    data:datastring,
    cache:false,        
    success:function(returndata)
    {
      if(returndata!="0") {
        $("#myModal").modal('show');
        var json = JSON.parse(returndata);
        $("#id").val(json.id);
        $("#BT_no").val(json.BT_no);
        $("#name").val(json.name);
        $("#classes").val(json.class);
        $("#department").val(json.department);
        // $("#adv_amt").val(json.advance_amt);
        // $("#total_amt").val(json.total_pay);
      }
    }
  });
}

function checkSubmit()
{
  var class_year = $("#class_year").val();
  var session = $("#session").val();
  var book_bank = $("input[name='book_bank']:checked").val();
  var id = $("#id").val().trim();
  var BT_no = $("#BT_no").val();
  var classes = $("#classes").val();
  var department = $("#department").val();
  var name = $("#name").val();
  alert(book_bank);
  if(book_bank == null)
  {
    book_bank = 0;
  }
  // alert(book_bank);
  if (class_year=="") {
    $("#year_err").fadeIn().html("Required");
    setTimeout(function(){ $("#year_err").fadeOut(); }, 3000);
    $("#class_year").focus();
    return false;
  }
  if (session=="") {
    $("#session_err").fadeIn().html("Required");
    setTimeout(function(){ $("#session_err").fadeOut(); }, 3000);
    $("#session").focus();
    return false;
  }
  else
  { 
    // alert(book_bank);
      $('#editBrand').attr('disabled',true);
      var datastring="class_year="+class_year+"&session="+session+"&id="+id+"&book_bank="+book_bank+"&BT_no="+BT_no+"&classes="+classes+"&department="+department+"&name="+name;
      alert(datastring);
      $.ajax({
          type:"POST",
          url:"{{ url('/admin/promote/BTCard') }}",
          data:datastring,
          cache:false,        
          success:function(returndata)
          {
            // alert(returndata);
          $('#editBrand').attr('disabled',false);
          $("#myModal").modal('hide');
          var oTable = $('#data_table').dataTable(); 
          oTable.fnDraw(false);
          toastr.success(returndata.success);
          
          // location.reload();
          // $("#pay").val("");
          }
      });
  }
}
</script>


@endsection