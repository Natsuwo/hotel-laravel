<script>
    function deleteFile(id) {
        if (confirm('Are you sure you want to delete this image?')) {
            $.ajax({
                url: '{{ route('admin.gallery.delete') }}',
                type: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response?.message) {
                        $('#toast-message').text(response.message);
                        $('#custom-toast').addClass('showing');
                        setTimeout(function() {
                            $('#custom-toast').removeClass('showing').addClass('hide');
                        }, 5000);
                    }
                    $('[data-id="' + id + '"]').parent().remove();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Delete failed:', textStatus, errorThrown);
                }
            });
        }
    }

    $(document).ready(function() {
        var dropzone = $('#dropzone');

        dropzone.on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragging');
        });

        dropzone.on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragging');
        });

        dropzone.on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragging');
            var files = e.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        dropzone.on('click', function() {
            $('<input type="file" multiple>').on('change', function(e) {
                var files = e.target.files;
                handleFiles(files);
            }).click();
        });

        function showPreview(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = $('<img width="75" style="object-fit:contain;">').attr('src', e.target.result);
                var progress = $('.progress').first().clone().removeClass('d-none').find('.progress-bar')
                    .css('width', '0%').end();
                var previewContainer = $(
                    '<div class="position-relative d-flex" style="max-width: 75px; gap:10px;"></div>');
                previewContainer.append(img).append(progress);
                $('#preview-container').append(previewContainer);
            }
            reader.readAsDataURL(file);
        }

        function uploadFile(file) {
            var formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            if (isChoose) {
                formData.append('isChoose', true);
            }

            $.ajax({
                url: '{{ route('admin.gallery.upload') }}', // Change this to your upload URL
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percentComplete = (e.loaded / e.total) * 100;
                            $('#preview-container .progress').removeClass('d-none');
                            $('#preview-container .progress-bar')
                                .css('width', percentComplete + '%')
                                .attr('aria-valuenow', percentComplete);
                            console.log('Upload progress: ' + percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                success: function(response) {
                    $('#gallery').prepend(response?.html);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Upload failed:', textStatus, errorThrown);
                }
            });
        }

        function handleFiles(files) {
            for (var i = 0; i < files.length; i++) {
                showPreview(files[i]);
                uploadFile(files[i]);
            }
        }

        $('#search-input').on('input', function() {
            var search = $(this).val();
            $.ajax({
                url: '{{ route('admin.gallery.search') }}',
                type: 'GET',
                data: {
                    search: search
                },
                success: function(response) {
                    if (response?.result) {
                        $('#gallery').html(response?.result);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Search failed:', textStatus, errorThrown);
                }
            });
        });
    });
</script>
