@php($modal_id = uniqid())
<button type="button" class="{{$button_class ?? "btn me-2"}}" data-bs-toggle="modal" data-bs-target="#{{$modal_id}}">
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
                        <div class="row justify-content-center">
                            @foreach($inputs as $input)
                                <div class="col-md-{{ $col_size ?? "6" }} align-right">
                                    <br>
                                    <div class="form-group">
                                        @if(($input['type'] ?? "text") == "textarea")
                                            <label class="form-label" style="text-align: right"  for="{{$input['name']}}">{{$input['label'] ?? $input['name']}}</label>
                                            <textarea id="{{$input['name']}}" name="{{$input['name']}}"
                                                      class="form-control">{{$input['value'] ?? ""}}</textarea>
                                        @elseif(($input['type'] ?? "text") == "hidden")
                                            <input id="{{$input['name']}}" type="hidden"
                                                   name="{{$input['name']}}" value="{{$input['value'] ?? ""}}">
                                        @else
                                            <label class="form-label" style="text-align: right"
                                                   for="{{$input['name']}}">{{$input['label'] ?? $input['name']}}</label>
                                            <input id="{{$input['name']}}" type="{{$input['type'] ?? "text"}}"
                                                   name="{{$input['name']}}" class="form-control" value="{{$input['value'] ?? ""}}">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-{{ $col_size ?? "6" }}">
                                <br>
                                <button class="{{$save_button_class ?? "btn btn-primary"}} w-100">
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
