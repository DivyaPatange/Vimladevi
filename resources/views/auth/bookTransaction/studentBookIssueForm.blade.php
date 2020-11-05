@extends('auth.authLayouts.main')
@section('title', 'Student Book Issue')
@section('customcss')
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
  <h1 class="h3 mb-4 text-gray-800">Student Book Issue</h1>
  <div class="row">
    <div class="col-md-6">
    <div class="card shadow mb-4">
            <div class="card-header">
              Student Profile
            </div>
            <div class="card-body"
      <p><b>Student Name:- </b>{{ $studentBT->name }}</p>
      <?php 
        $class = DB::table('courses')->where('id', $studentBT->class)->first();
        $department = DB::table('departments')->where('id', $studentBT->department)->first();
      ?>
      <p><b>Class:- </b>{{ $class->course_name }}</p>
      <p><b>Class Year:- </b>{{ $studentBT->class_year }}</p>
      <p><b>Department:- </b>{{ $department->department }}</p>
      </div>
      </div>
    </div>
    <div class="col-md-6">
          <!-- Basic Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header">
              Issue Book
            </div>
            <div class="card-body">
              <form method="post" action="{{ route('admin.studentBookIssueForm.submit') }}">
              @csrf 
              <div class="form-group ">
                  <label>Category</label>
                  <select class="form-control form-control-user @error('category') is-invalid @enderror" name="category" id="category" onchange="myFunction()">
                    <option value="">-Select Category-</option>
                    <option value="p">Pustak Pedhi</option>
                    <option value="g">General Book</option>
                  </select>
                  @error('book_code')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group ">
                  <label>Book Code</label>
                  <input type="text" class="form-control book_code form-control-user @error('book_code') is-invalid @enderror" name="book_code" placeholder="Enter Book Code" value="{{ old('book_code') }}">
                  @error('book_code')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group book_name">
                </div>
                <input type="hidden" name="BT_id" value="{{ $BT_no->id }}">
                <input type="hidden" name="BT_no" value="{{ $BT_no->BT_no }}">
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Add
                </button>
              </form>
            </div>
          </div>
        </div>
  </div>
  <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pustak Pedhi</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">General Book</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <section class="py-5">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <input type="number" class="form-control form-control-user" id="search_book_no" placeholder="Search Book No.">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <input type="text" class="form-control form-control-user" id="search_book_name" placeholder="Search Book Name">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <input type="text" class="form-control form-control-user" id="search_author_name" placeholder="Search Author Name">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <input type="text" class="form-control form-control-user" id="search_publication" placeholder="Search Publication">
          </div>
        </div>
      </div>
    </section>
      
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Book Issue List</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Issue Date/
                  Expected Return Date</th>
                  <th>Actual Return Date</th>
                  <th>Book Condition</th>
                  <th>Action</th>
                  <th>Penalty</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Issue Date/
                  Expected Return Date</th>
                  <th>Actual Return Date</th>
                  <th>Book Condition</th>
                  <th>Action</th>
                  <th>Penalty</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($issueBook as $key => $book)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $book->book_no }}</td>
                  <?php
                      $book_name = DB::table('library_books')->where('book_no', $book->book_no)->first();
                      $issueDates = DB::table('student_book_issue_dates')->where('student_book_issue_id', $book->id)->orderBy('id', 'ASC')->get();
                  ?>
                  <td>
                  
                  @if(isset($book_name) && !empty($book_name))
                      {{ $book_name->book_name }}
                  @endif
                  </td>
                  <td class="p-0">
                    <table width="100%">
                      @foreach($issueDates as $i)
                      <tr>
                        <td>{{ $i->issue_date }}</td>
                        <td>{{ $i->expected_return_date
                        }}
                      </tr>
                    @endforeach
                    </table>
                  </td>
                  <td>
                    @if(!$book->actual_return_date)
                    <input type="date" class="form-control form-control-user end_date" name="actual_return_date">
                    @else
                    <input type="date" class="form-control form-control-user end_date" name="actual_return_date" value="{{ $book->actual_return_date }}">
                    @endif
                  </td>
                  <td>
                    @if(!$book->book_status)

                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="good">Good
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="average">Average
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="poor">Poor
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="missing">Missing
                        </label>
                      </div>
                      @else
                      <?php
                      $explode = explode(",", $book->book_status);
                      ?>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="good" {{ in_array("good", $explode)?  'checked' :  '' }}>Good
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="average" {{ in_array("average", $explode)?  'checked' :  '' }}>Average
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="poor" {{ in_array("poor", $explode)?  'checked' :  '' }}>Poor
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="missing" {{ in_array("missing", $explode)?  'checked' :  '' }}>Missing
                        </label>
                      </div>
                      @endif
                    </td>
                    <td>
                    <button class="btn btn-warning btn-circle update" data-id="{{ $book->id }}">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-info btn-circle @if(count($issueDates) == 4) @elseif(!$book->actual_return_date) renew  @endif"  data-id="{{ $book->id }}"  >
                        <i class="fas fa-book"></i>
                      </button>
                    </td>
                    <td>
                      {{ $book->penalty }}
                    </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
          <!-- Basic Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header">
              Issue Book
            </div>
            <div class="card-body">
              <form method="post" action="{{ route('admin.studentBookIssueForm.submit') }}">
              @csrf 
                <div class="form-group ">
                <label>Book Code</label>
                <input type="text" class="form-control form-control-user @error('book_code') is-invalid @enderror" name="book_code" id="general_book_code" placeholder="Enter Book Code" value="{{ old('book_code') }}">
                @error('book_code')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
                <div class="form-group" id="general_book_name">
                    
                </div>
                <input type="hidden" name="category" value="g">
                <input type="hidden" name="BT_id" value="{{ $BT_no->id }}">
                <input type="hidden" name="BT_no" value="{{ $BT_no->BT_no }}">

                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Add
                </button>
              </form>
            </div>
          </div>

        </div>
      </div>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Book Issue List</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Issue Date/
                  Expected Return Date</th>
                  <th>Actual Return Date</th>
                  <th>Book Condition</th>
                  <th>Action</th>
                  <th>Penalty</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Issue Date/
                  Expected Return Date</th>
                  <th>Actual Return Date</th>
                  <th>Book Condition</th>
                  <th>Action</th>
                  <th>Penalty</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($generalBook as $key => $book)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $book->book_no }}</td>
                  <?php
                      $book_name = DB::table('student_books')->where('book_no', $book->book_no)->first();
                      $issueDates = DB::table('student_book_issue_dates')->where('student_book_issue_id', $book->id)->orderBy('id', 'ASC')->get();
                  ?>
                  <td>
                  
                  @if(isset($book_name) && !empty($book_name))
                      {{ $book_name->book_name }}
                  @endif
                  </td>
                  <td class="p-0">
                    <table width="100%">
                      @foreach($issueDates as $i)
                      <tr>
                        <td>{{ $i->issue_date }}</td>
                        <td>{{ $i->expected_return_date
                        }}
                      </tr>
                    @endforeach
                    </table>
                  </td>
                  <td>
                    @if(!$book->actual_return_date)
                    <input type="date" class="form-control form-control-user end_date" name="actual_return_date">
                    @else
                    <input type="date" class="form-control form-control-user end_date" name="actual_return_date" value="{{ $book->actual_return_date }}">
                    @endif
                  </td>
                  <td>
                    @if(!$book->book_status)

                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="good">Good
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="average">Average
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="poor">Poor
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="missing">Missing
                        </label>
                      </div>
                      @else
                      <?php
                      $explode = explode(",", $book->book_status);
                      ?>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="good" {{ in_array("good", $explode)?  'checked' :  '' }}>Good
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input type="checkbox" name="book_status" class="form-check-input" value="average" {{ in_array("average", $explode)?  'checked' :  '' }}>Average
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="poor" {{ in_array("poor", $explode)?  'checked' :  '' }}>Poor
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" name="book_status" class="form-check-input" value="missing" {{ in_array("missing", $explode)?  'checked' :  '' }}>Missing
                        </label>
                      </div>
                      @endif
                    </td>
                    <td>
                    <button class="btn btn-warning btn-circle update" data-id="{{ $book->id }}">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-info btn-circle @if(count($issueDates) == 4) @elseif(!$book->actual_return_date) renew  @endif"  data-id="{{ $book->id }}"  >
                        <i class="fas fa-book"></i>
                      </button>
                    </td>
                    <td>
                      {{ $book->penalty }}
                    </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
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
$(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>
<script>
function myFunction(){
        // the text typed in the input field is assigned to a variable 
        var query = document.getElementById("category").value;
        // alert(query);
        if(query == "p")
        {
          document.getElementByClassName("book_code").setAttribute("id", "book_code");
          document.getElementByClassName("book_name").setAttribute("id", "book_name");
        }
        if(query == "g")
        {
          document.getElementsByClassName("book_code").setAttribute("id", "general_book_code");
          document.getElementsByClassName("book_name").setAttribute("id", "general_book_name");
        }
}
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#book_code').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('admin.searchBookCode') }}",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'book_code':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#book_name').html(data);
            }
        })
        // end of ajax call
    });
})
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#general_book_code').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // alert(query);
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('admin.searchGeneralBookCode') }}",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'general_book_code':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#general_book_name').html(data);
            }
        })
        // end of ajax call
    });
})
</script>
<script>
   $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
<script>
$(document).on('click', '.update', function(){
    var $row = $(this).closest("tr");
		var issueID = $row.find(".update").data('id');
		var return_date = $row.find(".end_date").val();
    // alert(return_date);
    var book_status = [];
		// Initializing array with Checkbox checked values
		$row.find("input[name='book_status']:checked").each(function(){
			book_status.push(this.value);
		});
    
			// alert(book_status);
    if(issueID != ''){
		$.ajax({
			url: "{{ route('admin.studentBookIssue.update') }}",
			method: "POST",
			data: {issueID:issueID, return_date:return_date, book_status:book_status},
			success: function(data){
        Swal.fire(
          'Book Returned Successfully!',
          )
        setTimeout(() => {
            location.reload();
        }, 1000);
			}
		});
		}
});
</script>
<script>
$(document).on('click', '.renew', function(){
    var $row = $(this).closest("tr");
    // $row.find(".nr").
		var issueID = $row.find(".renew").data('id');
    // alert(issueID);
    if(issueID != ''){
		$.ajax({
			url: "{{ route('admin.studentBookIssue.renew') }}",
			method: "POST",
			data: {issueID:issueID},
			success: function(data){
        Swal.fire(
          'Book Renew Successfully!',
          )
          setTimeout(() => {
              location.reload();
          }, 2000);
			}
		});
		}
});
</script>
@endsection