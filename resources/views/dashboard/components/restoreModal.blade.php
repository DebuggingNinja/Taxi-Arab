<div class="modal modal-blur fade" id="modal-success" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-success"></div>
            <div class="modal-body text-center py-4">
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-success icon-lg" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 9v2m0 4v.01"></path>
                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75">
                    </path>
                </svg>
                <h3>متاكد ؟</h3>
                <div class="text-muted">هل تريد استعادة السجل؟</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                لا
                            </a></div>
                        <div class="col"><a href="#" class="btn btn-success w-100" data-bs-dismiss="modal"
                                id="confirm-restore">
                                استعادة
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on("click", ".restore-btn", function () {
     var ID = $(this).data('id');
     $("#confirm-restore").attr('data-id',ID) ;
});
$(document).on("click", "#confirm-restore", function () {
    var ID = $(this).data('id');
    $("#"+ID).submit();
});
</script>