<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeFroalaEditor();
        loadGalleryModalContent();
    });

    function initializeFroalaEditor() {
        new FroalaEditor('#room_description', {
            theme: 'dark',
        });
    }

    function loadGalleryModalContent() {
        $.ajax({
            url: '{{ route('admin.gallery.modal') }}',
            method: 'GET',
            success: function(response) {
                if (response?.html) {
                    $('#galleryModal .modal-content').prepend(response.html);
                }
            },
            error: function(xhr) {
                console.error('Error loading modal content:', xhr);
            }
        });
    }

    function chooseFile() {
        gallerySelected.forEach((image) => {
            if (!image.id) return;

            var previewContainer = $('#image_preview_container');
            var input = $('<input>').attr('type', 'hidden').attr('name', 'images[]').val(image.id);
            $('#drop-area').append(input);
            previewContainer.append(
                `<div class="p-2" style="flex: 0 0 50%;"><img src="${image.url}" style="max-width: 100%; margin: 10px; display: block;"></div>`
            );
        });
    }
</script>
