@php($modal_id = uniqid())
<button type="button" class="btn me-2" data-bs-toggle="modal" data-bs-target="#{{$modal_id}}">
    {{$button_text}}
</button>
<div class="modal modal-blur fade" id="{{ $modal_id }}" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{$submit_route}}">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="{{$input_type ?? "text"}}" name="{{$input_name}}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary">
                                    {{$save_button_text ?? "save"}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{ $close_button_text }}</button>
            </div>
        </div>
    </div>
</div>
