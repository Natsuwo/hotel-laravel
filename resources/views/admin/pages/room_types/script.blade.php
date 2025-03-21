<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeFroalaEditor();
    });

    function initializeFroalaEditor() {
        new FroalaEditor('#room_description', {
            theme: 'dark',
        });
    }

    function chooseFile() {
        // clear previewContainer
        const previewContainer = $('#image_preview_container');
        previewContainer.html('');
        gallerySelected.forEach((image) => {
            if (!image.id) return;
            var input = $('<input>').attr('type', 'hidden').attr('name', 'images[]').val(image.id);
            $('#drop-area').append(input);
            previewContainer.append(
                `<div class="p-2" style="flex: 0 0 50%;"><img src="${image.url}" style="max-width: 100%; margin: 10px; display: block;"></div>`
            );
        });
    }
</script>
