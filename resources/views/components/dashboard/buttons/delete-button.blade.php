<form class="d-none" id="DELETE_{{$id }}" method="POST" action="{{ $route }}">
    @csrf
    @method('DELETE')
</form>
@component('components.dashboard.buttons.button', [
'route'=> null,
'method'=>'DELETE',
'cssClass' => 'btn-danger delete-btn',
'data_id' => $id,
'text' =>'حذف'
])
@endcomponent