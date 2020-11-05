@extends('auth.authLayouts.main')
@section('title', 'Search')
@section('customcss')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Search</h1>
  </div>
  <form class="mr-md-3 my-2 my-md-0  navbar-search" id="searchForm">
    <!-- Content Row -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <select class="form-control" id="category">
            <option value="">-Select Category-</option>
            <option value="p">Pustak Pedhi</option>
            <option value="g">General Book</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <select class="form-control" id="searchBy">
            <option value="">-Search By-</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <input type="text" name="searchName" id="searchFor" class="form-control" placeholder="Search For..">
      </div>
      <div class="col-md-3">
        <button type="submit"  class="btn btn-primary">Search</button>
      </div>
    </div>
  </form>
  <div id="bookRecord" class="mt-5"></div>
</div>

@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('adminAsset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminAsset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('adminAsset/js/demo/datatables-demo.js') }}"></script>

<script>
$(document).ready(function(){
  $('#category').change(function(){
  if($(this).val() != '')
  {
    var value = $(this).val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
    url:"{{ route('admin.fetch') }}",
    method:"POST",
    data:{value:value, _token:_token},
    success:function(result)
    {
      $('#searchBy').html(result);
    }
    })
  }
})
});
</script>
<script>
$(function () {
  $('#searchForm').on('submit', function (e) {
    e.preventDefault();
    var category = $('#category').val();
    var searchBy = $('#searchBy').val();
    var searchFor = $('#searchFor').val();
    // alert(category);
    $.ajax({
      url:"{{ route('admin.searchBookDetails') }}",
      method:"GET",
      data: {category:category, searchBy:searchBy, searchFor:searchFor},
      success:function(data)
      {
        // console.log(data);
        $('#bookRecord').html(data);
      }
    })
  });
});
$(document).ready( function () {
    $('#dataTable').DataTable();
} );
</script>
@endsection