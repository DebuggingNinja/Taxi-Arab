<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">
        {{ $label }}
        <span class="text-danger fw-bold">
            {{ $is_mandatory ? '*' : '' }}
        </span>
    </label>
    <div class="col">
        @unless(isset($show) && $show)
        <input type="file" class="form-control" name="{{ $name }}{{ $multiple?'[]':'' }}" {{ $multiple?'multiple':'' }}
            accept="{{ $accepts }}">
        @endunless

        <small class="form-hint">{!! $hint !!}</small>
        <div class="preview-container">
            <div class="row" id="image-container-{{ $name }}" style="{{ isset($current) ? '':'display: none;' }}">
                <!-- Preview images will be displayed here -->
                @if(isset($current) && $current)
                <div class="col-2 mb-3">
                    <div class="card image-card justify-content-center p-2 align-items-center master-image">
                        <img src="{{ Storage::url($current) }}" alt="Current Image" class="card-img-top">
                    </div>
                </div>
                @endif
            </div>
            <button type="button" id="clear-images-{{ $name }}" class="btn btn-danger" style="display: none;">Clear
                All</button>
        </div>
    </div>
</div>
<style>
    .image-card {
        max-width: 100%;
        /* Fit the width of the container */
        height: 100px;
        /* Fixed height for proportional images */
        overflow: hidden;
        /* Add a transition for smooth animation */
    }

    .preview-container {
        background: #f4f4f4;
        margin: 5px;
        padding: 25px 10px 10px 10px;
        border: 1px dashed gray;
        border-radius: 25px;
    }

    .image-card img {
        width: fit-content;
        height: 100%;
    }

    .master-image {
        border: 2px dashed #FF5722;
    }
</style>
<script>
    // Initialize an array to store the uploaded image files
    var uploadedImages = [];

    // Add an event listener to the file input element
    $('input[name="{{ $name }}{{ $multiple?'[]':'' }}"]').on('change', function (e) {
        var input = this;

        // Clear the image container
        $('#image-container-{{ $name }}').html('');

        // Clear the uploadedImages array
        uploadedImages = [];

        // Check if files are selected
        if (input.files && input.files.length > 0) {
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                uploadedImages.push(input.files[i]);

                (function (currentIndex) {
                    reader.onload = function (e) {
                        // Create a card for each selected image
                        var isMasterImage = (currentIndex === 0); // Check if it's the first image
                        var imagePreview = `
                            <div class="col-2 mb-3">
                                <div class="card image-card justify-content-center p-2 align-items-center ${isMasterImage ? 'master-image' : ''}">
                                    <img src="${e.target.result}" alt="Image Preview" class="card-img-top">
                                </div>
                            </div>
                        `;

                        $('#image-container-{{ $name }}').append(imagePreview);
                    };
                })(i); // Create a closure to capture the value of i

                reader.readAsDataURL(input.files[i]);
            }

            // Show the "Clear All" button
            $('#clear-images-{{ $name }}').show(0);
            $('#image-container-{{ $name }}').show(0);
        }
    });

    // Add an event listener to the "Clear All" button
    $('#clear-images-{{ $name }}').on('click', function () {
        // Clear the image container
        $('#image-container-{{ $name }}').html('');

        // Clear the uploadedImages array
        uploadedImages = [];

        // Clear the file input
        $('input[name="{{ $name }}{{ $multiple?'[]':'' }}"]').val('');

        // Hide the "Clear All" button
        $('#clear-images-{{ $name }}').hide();
        $('#image-container-{{ $name }}').hide();
    });
</script>