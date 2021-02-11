@extends('auth.authLayouts.main')
@section('title', 'Department Library')
@section('customcss')

<link href="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
$(document).ready(function(){
  $("#searchButton").click(function(){
    $("#searchForm").toggle();
  });
});
</script>
<style>
#searchForm{
  display:none;
}
</style>
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
  <div class="row">
    <div class="col-md-6">
      <h1 class="h3 mb-2 text-gray-800">{{ $department->department }} Department</h1>
    </div>
    <div class="col-md-6">
      <button class="btn btn-secondary float-md-right float-sm-left" id="searchButton">
        Search Book
      </button>
    </div>
  </div>
  <div id="searchForm">
  <section class="py-5" >
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <select class="form-control form-control-user" id="search_category">
            <option value="">-Select Category-</option>
            <option value="p">Pustak Pedhi</option>
            <option value="g">General Book</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <div class="input-group">
            <input type="number" class="form-control form-control-user" id="search_book_no" placeholder="Search Book No.">
            <div class="input-group-append">
              <span class="input-group-text" id="book_no_search"><i class="fas fa-search fa-sm"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control form-control-user" id="search_book_name" placeholder="Search Book Name">
            <div class="input-group-append">
              <span class="input-group-text" id="book_name_search"><i class="fas fa-search fa-sm"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control form-control-user" id="search_author_name" placeholder="Search Author Name">
            <div class="input-group-append">
              <span class="input-group-text" id="author_name_search"><i class="fas fa-search fa-sm"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div id="bookRecord"></div>
  </section>
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
      <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
          <!-- Basic Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header">
              Add Book 
            </div>
            <div class="card-body">
              <form method="post" id="form-submit">
                
                <div class="form-group ">
                  <label>Book Code<span style="color:red;">*</span><span  style="color:red" id="book_code_err"> </span></label>
                  <input type="text" class="form-control form-control-user @error('book_code') is-invalid @enderror" name="book_code" id="book_code" placeholder="Enter Book Code" value="{{ old('book_code') }}">
                  @error('book_code')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group" id="book_name">
                </div>
                <input type="hidden" name="category" value="p" id="category">
                <input type="hidden" name="department_id" id="department_id" value="{{ $department->id }}">
                <button type="button" id="submitForm" class="btn btn-primary btn-user btn-block">
                  Add
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ $department->department }} Department Books</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Allocation Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Allocation Date</th>
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
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
          <!-- Basic Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header">
              Add Book 
            </div>
            <div class="card-body">
              <form method="post" id="form-submit1">
                
                <div class="form-group ">
                  <label>Book Code<span style="color:red;">*</span><span  style="color:red" id="general_book_code_err"> </span></label>
                  <input type="text" class="form-control form-control-user @error('book_code') is-invalid @enderror" name="book_code" id="general_book_code" placeholder="Enter Book Code" value="{{ old('book_code') }}">
                  @error('book_code')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group" id="general_book_name">
                </div>
                <input type="hidden" name="category" id="category1" value="g">
                <input type="hidden" name="department_id" id="department_id1" value="{{ $department->id }}">
                <button type="button" id="submitForm1" class="btn btn-primary btn-user btn-block">
                  Add
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ $department->department }} Department Books</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Allocation Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Sr. No.</th>
                  <th>Book No.</th>
                  <th>Book Name</th>
                  <th>Allocation Date</th>
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
  </div>
</div>
<!-- /.container-fluid -->

<!-- General Book Model -->
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="POST" id="editForm">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group ">
          <label>Book Code<span style="color:red;">*</span><span  style="color:red" id="edit_gb_err"> </span></label>
          <input type="text" class="form-control form-control-user @error('book_code') is-invalid @enderror" name="book_code" id="edit_general_book_code" placeholder="Enter Book Code" value="{{ old('book_code') }}">
          @error('book_code')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group" id="edit_general_book_name">
        </div>
        <div class="form-group">
          <label for="">Allocation Date<span style="color:red;">*</span><span  style="color:red" id="allocation_date_err"> </span></label>
          <input type="date" name="allocation_date" class="form-control" id="allocation_date">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="general_book_id">
        <button type="button" class="btn btn-primary" onclick="return checkSubmit()" id="editButton">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>

    </div>
  </div>
</div>

<!-- Pustak Pedhi Modal -->
<!-- The Modal -->
<div class="modal" id="myModal1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="POST" id="editForm1">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group ">
          <label>Book Code<span style="color:red;">*</span><span  style="color:red" id="edit_pb_err"> </span></label>
          <input type="text" class="form-control form-control-user @error('book_code') is-invalid @enderror" name="book_code" id="edit_book_code" placeholder="Enter Book Code" value="{{ old('book_code') }}">
          @error('book_code')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group" id="edit_book_name">
        </div>
        <div class="form-group">
          <label for="">Allocation Date<span style="color:red;">*</span><span  style="color:red" id="edit_ad_err"> </span></label>
          <input type="date" name="allocation_date" class="form-control" id="allocation_date1">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="pustak_book_id">
        <button type="button" class="btn btn-primary" onclick="return checkSubmit1()" id="editButton1">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>

    </div>
  </div>
</div>
@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('adminAsset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('adminAsset/js/demo/datatables-demo.js') }}"></script>
<script>
// $(document).ready(function() {
//   $('#dataTable').DataTable();
// });
// $(document).ready(function() {
//   $('#dataTable1').DataTable();
// });

var SITEURL = '{{ route('admin.viewDepartmentBook', $department->id) }}';
var category = "g";
var category1 = "p";
$('#dataTable1').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    data: {category:category},
    },
    columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'book_no', name: 'book_no' },
            { data: 'book_name', name: 'book_name' },
            { data: 'allocation_date', name: 'allocation_date' },
            {data: 'action', name: 'action', orderable: false},
        ],
    order: [[0, 'desc']]
});
$('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    data: {category1:category1},
    },
    columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'book_no', name: 'book_no' },
            { data: 'book_name', name: 'book_name' },
            { data: 'allocation_date', name: 'allocation_date' },
            {data: 'action', name: 'action', orderable: false},
        ],
    order: [[0, 'desc']]
});
</script>
<script>
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
    $('#edit_book_code').on('keyup',function() {
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
                $('#edit_book_name').html(data);
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
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#edit_general_book_code').on('keyup',function() {
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
                $('#edit_general_book_name').html(data);
            }
        })
        // end of ajax call
    });
})
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#book_no_search').on('click',function() {
      // the text typed in the input field is assigned to a variable 
      var query = $("#search_book_no").val();
      var category = $("#search_category").val();
      if(query != ''){
        $.ajax({
          url:"{{ route('admin.searchBookNo') }}",
          method: "GET",
          data:{"search_book_no":query, category:category},
          success:function(data)
          {
            $('#bookRecord').html(data);
          }
        })
      }
    })
});

$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#book_name_search').on('click',function() {
      // the text typed in the input field is assigned to a variable 
      var query = $("#search_book_name").val();
      var category = $("#search_category").val();
      // alert(category);
      if(query != ''){
        $.ajax({
          url:"{{ route('admin.searchBookName') }}",
          method: "GET",
          data:{"search_book_name":query, category:category},
          success:function(data)
          {
            $('#bookRecord').html(data);
          }
        })
      }
    })
});
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#author_name_search').on('click',function() {
      // the text typed in the input field is assigned to a variable 
      var query = $("#search_author_name").val();
      var category = $("#search_category").val();
      if(query != ''){
        $.ajax({
          url:"{{ route('admin.searchAuthorName') }}",
          method: "GET",
          data:{"search_author_name":query, category:category},
          success:function(data)
          {
            $('#bookRecord').html(data);
          }
        })
      }
    })
});
</script>
<script>
   $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('body').on('click', '#submitForm', function () {
    var book_code = $("#book_code").val();
    var category = $("#category").val();
    var department_id = $("#department_id").val();
    if (book_code=="") {
        $("#book_code_err").fadeIn().html("Required");
        setTimeout(function(){ $("#book_code_err").fadeOut(); }, 3000);
        $("#book_code").focus();
        return false;
    }
    else
    { 
        var datastring="book_code="+book_code+"&category="+category+"&department_id="+department_id;
        // alert(datastring);
        $.ajax({
            type:"POST",
            url:"{{ route('admin.departmentLibrary.store') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
                document.getElementById("form-submit").reset();
                var oTable = $('#dataTable').dataTable(); 
                oTable.fnDraw(false);
                if(returndata.success){
                toastr.success(returndata.success);
                }
                else{
                  // $("#book_name").hide();
                toastr.error(returndata.error)
                }
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
$('body').on('click', '#submitForm1', function () {
    var book_code = $("#general_book_code").val();
    var category = $("#category1").val();
    var department_id = $("#department_id1").val();
    if (book_code=="") {
        $("#general_book_code_err").fadeIn().html("Required");
        setTimeout(function(){ $("#general_book_code_err").fadeOut(); }, 3000);
        $("#general_book_code").focus();
        return false;
    }
    else
    { 
        var datastring="book_code="+book_code+"&category="+category+"&department_id="+department_id;
        // alert(datastring);
        $.ajax({
            type:"POST",
            url:"{{ route('admin.departmentLibrary.store') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
                document.getElementById("form-submit1").reset();
                var oTable = $('#dataTable1').dataTable(); 
                oTable.fnDraw(false);
                if(returndata.success){
                toastr.success(returndata.success);
                }
                else{
                  // $("#book_name").hide();
                toastr.error(returndata.error)
                }
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
function EditModel(obj,bid)
{
    var datastring="bid="+bid;
    // alert(datastring);
    $.ajax({
        type:"POST",
        url:"{{ route('admin.get.general-book') }}",
        data:datastring,
        cache:false,        
        success:function(returndata)
        {
            // alert(returndata);
          if (returndata!="0") {
            
            var json = JSON.parse(returndata);
            $("#myModal").modal('show');
            $("#general_book_id").val(json.id);
            $("#edit_general_book_code").val(json.book_no);
            $("#allocation_date").val(json.allocation_date);
          }
        }
    });
}
function EditModel1(obj,bid)
{
    var datastring="bid="+bid;
    // alert(datastring);
    $.ajax({
        type:"POST",
        url:"{{ route('admin.get.pustak-book') }}",
        data:datastring,
        cache:false,        
        success:function(returndata)
        {
            // alert(returndata);
          if (returndata!="0") {
            
            var json = JSON.parse(returndata);
            $("#myModal1").modal('show');
            $("#pustak_book_id").val(json.id);
            $("#edit_book_code").val(json.book_no);
            $("#allocation_date1").val(json.allocation_date);
          }
        }
    });
}
function checkSubmit()
{
    var book_no = $("#edit_general_book_code").val();
    var allocation_date = $("#allocation_date").val();
    var id = $("#general_book_id").val().trim();
    if (book_no=="") {
        $("#edit_gb_err").fadeIn().html("Required");
        setTimeout(function(){ $("#edit_gb_err").fadeOut(); }, 3000);
        $("#edit_general_book_code").focus();
        return false;
    }
    if (allocation_date=="") {
        $("#allocation_date_err").fadeIn().html("Required");
        setTimeout(function(){ $("#allocation_date_err").fadeOut(); }, 3000);
        $("#allocation_date").focus();
        return false;
    }
    else
    { 
        $('#editButton').attr('disabled',true);
        var datastring="book_no="+book_no+"&allocation_date="+allocation_date+"&id="+id;
        // alert(datastring);
        $.ajax({
            type:"POST",
            url:"{{ url('/admin/general-book/update') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
              console.log(returndata.success);
            $('#editButton').attr('disabled',false);
            $("#myModal").modal('hide');
            var oTable = $('#dataTable1').dataTable(); 
            oTable.fnDraw(false);
            if(returndata.success){
            toastr.success(returndata.success);
            }
            else{
              toastr.error(returndata.error);
            }
            
            }
        });
    }
}
function checkSubmit1()
{
  var book_no = $("#edit_book_code").val();
  var allocation_date = $("#allocation_date1").val();
  var id = $("#pustak_book_id").val().trim();
  if (book_no=="") {
    $("#edit_pb_err").fadeIn().html("Required");
    setTimeout(function(){ $("#edit_pb_err").fadeOut(); }, 3000);
    $("#edit_book_code").focus();
    return false;
  }
  if (allocation_date=="") {
    $("#edit_ad_err").fadeIn().html("Required");
    setTimeout(function(){ $("#edit_ad_err").fadeOut(); }, 3000);
    $("#allocation_dat1e").focus();
    return false;
  }
  else
  { 
    $('#editButton1').attr('disabled',true);
    var datastring="book_no="+book_no+"&allocation_date="+allocation_date+"&id="+id;
    // alert(datastring);
    $.ajax({
      type:"POST",
      url:"{{ url('/admin/pustak-book/update') }}",
      data:datastring,
      cache:false,        
      success:function(returndata)
      {
        console.log(returndata.success);
        $('#editButton1').attr('disabled',false);
        $("#myModal1").modal('hide');
        var oTable = $('#dataTable').dataTable(); 
        oTable.fnDraw(false);
        if(returndata.success){
        toastr.success(returndata.success);
        }
        else{
          toastr.error(returndata.error);
        }
        
      }
    });
  }
}
$('body').on('click', '#delete', function () {
  var id = $(this).data("id");
  if(confirm("Are You sure want to delete !")){
    $.ajax({
      type: "delete",
      url: "{{ url('admin/book') }}"+'/'+id,
      success: function (data) {
      var oTable = $('#dataTable1').dataTable(); 
      oTable.fnDraw(false);
      toastr.success(data.success);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
});
$('body').on('click', '#delete1', function () {
  var id = $(this).data("id");
  if(confirm("Are You sure want to delete !")){
    $.ajax({
      type: "delete",
      url: "{{ url('admin/book') }}"+'/'+id,
      success: function (data) {
      var oTable = $('#dataTable').dataTable(); 
      oTable.fnDraw(false);
      toastr.success(data.success);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
});
</script>
@endsection