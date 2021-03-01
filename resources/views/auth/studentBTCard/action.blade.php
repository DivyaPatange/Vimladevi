
<a href="{{ route('admin.student-bt-card.edit', $id) }}" class="btn btn-warning btn-circle">
    <i class="fas fa-edit"></i>
</a>
<a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger btn-circle">
    <i class="fas fa-trash"></i>
</a>
@if($bt_id != $id)
<button class="btn btn-info btn-circle" onclick="Promote(this, {{ $id }})"><i class="fas fa-plus"></i></button>
@endif
<form action="{{ route('admin.student-bt-card.destroy', $id) }}" method="post">
    @method('DELETE')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>