@extends('auth.authLayouts.main')
@section('title', 'Search')
@section('customcss')


@endsection
@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Search</h1>
  </div>
  <form class="mr-md-3 my-2 my-md-0  navbar-search">
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
        <input type="text" name="searchName" class="form-control" placeholder="Search For..">
      </div>
      <div class="col-md-3">
        <button type="button" class="btn btn-primary">Search</button>
      </div>
    </div>
  </form>
</div>

@endsection
@section('customjs')
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
@endsection