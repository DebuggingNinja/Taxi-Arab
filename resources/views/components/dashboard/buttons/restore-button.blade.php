<form class="d-none" id="RESTORE_{{$id }}" method="POST" action="{{ $route }}">
    @csrf
</form>

@php


if(isset($disabled))
if($disabled == true){
$tooltip = 'لا يمكن استعادة هذا العنصر الا باستعادة العنصر الام لهذا الهنصر';
$disabled = true;
}
else
$disabled = false;
else
$disabled = false ;

@endphp
@component('components.dashboard.buttons.button', [
'route'=> null,
'method'=>'RESTORE',
'cssClass' => 'btn-success restore-btn',
'data_id' => $id,
'disabled'=>$disabled,
'tooltip' => isset($tooltip) ? $tooltip : null,
'text' =>'استعادة'
])
@endcomponent