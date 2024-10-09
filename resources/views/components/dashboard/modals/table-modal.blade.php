<div class="modal modal-blur fade" id="{{ $modal_id }}" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @foreach($table_head as $head)
                                <th>{{$head}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($table_body as $body)
                        <tr>
                            @foreach($body as $item)
                                <td>{{$item}}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{ $close_button_text }}</button>
                @if($primary_button_text ?? false)
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ $primary_button_text
                    }}
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
