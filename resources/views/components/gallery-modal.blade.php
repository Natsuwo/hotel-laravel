@props(['id'])
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-height: 90%;">
        <div class="modal-content" style="max-height: 80vh; overflow-y: auto;">
            <section id="content"></section>
            <div class="modal-footer" style="z-index: 99; position: sticky; bottom: 0; background-color: inherit;">
                <button type="button" class="btn btn-success" onclick="chooseFile()"
                    data-dismiss="modal">Accept</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            loadGalleryModalContent();
        });

        function loadGalleryModalContent(page = 1) {
            $.ajax({
                url: '{{ route('admin.gallery.modal') }}',
                method: 'GET',
                data: {
                    page: page
                },
                success: function(response) {
                    if (response?.html) {
                        $('#{{ $id }} section#content').html(response.html);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading modal content:', xhr);
                }
            });
        }
    </script>
@endpush
