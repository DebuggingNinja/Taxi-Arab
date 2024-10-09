<form action="{{$route}}" method="POST" class="btn {{ $deleted ? " btn-success":"btn-danger" }} p-0">
    @method("DELETE")
    @csrf
    @if($deleted)
    <button onclick="return confirmRestore();" type="submit" class="btn btn-success" tabindex="0" data-toggle="tooltip"
        title="Restore"><i class="fas fa-undo"></i></button>
    @else
    <button type="submit" onclick="return confirmDelete();" class="btn btn-danger" tabindex="0" data-toggle="tooltip"
        title="Delete"><i class="fas fa-trash"></i></button>
    @endif
</form>