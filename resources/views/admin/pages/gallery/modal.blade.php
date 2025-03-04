<div id="custom-toast" class="toast"
    style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; min-width: 300px;">
    <div class="toast-header bg-success text-white">
        <strong class="mr-auto">Notification</strong>
    </div>
    <div class="toast-body bg-success text-white">
        <span id="toast-message"></span>
    </div>
    <style>
        .toast {
            transition: opacity 0.5s ease-in-out;
        }

        .toast.showing {
            opacity: 1;
        }

        .toast.hide {
            opacity: 0;
        }
    </style>
</div>
<style>
    .gallery {
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
    }

    .gallery img {
        margin: 10px;
        width: 200px;
        height: 200px;
        object-fit: cover;
    }

    .dropzone {
        border: 2px dashed #007bff;
        padding: 50px;
        text-align: center;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column
    }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Gallery</h1>
    <div class="dropzone" id="dropzone">
        Drag & Drop Images Here or Click to Upload
        <span style="font-size: 50px;">
            <i class="mdi mdi-file-upload"></i>
        </span>
    </div>
    <div id="preview-container" class="mt-4 position-relative d-flex" style="max-width: 75px; gap:10px;">
        <div class="progress mt-2 position-absolute d-none" style="bottom:0;width:100%;height: 5px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div class="search-bar mb-4 mt-2">
        <input type="text" id="search-input" class="form-control" placeholder="Search images..."
            style="width: 350px; margin: 0 auto;">
    </div>
    <div class="gallery mt-4" id="gallery">
        @foreach ($records as $image)
            @php
                $url = Cache::remember("image_url_{$image->id}", now()->addMinutes(5), function () use ($image) {
                    return Storage::disk('r2')->temporaryUrl($image->path, now()->addMinutes(5));
                });
                $isChoose = $isChoose ?? false;
            @endphp

            <x-gallery-card :image="$image" :url="$url" :isChoose="$isChoose" :selectable="$isChoose" />
        @endforeach
    </div>

    <div class="mt-4">
        @if ($isModel ?? true)
            <div id="pagination-links">
                {{ $records->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div id="pagination-links">
                <ul class="pagination">
                    <li class="page-item {{ $records->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0);"
                            onclick="loadGalleryModalContent({{ $records->currentPage() - 1 }})" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $records->lastPage(); $i++)
                        <li class="page-item {{ $i == $records->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="javascript:void(0);"
                                onclick="loadGalleryModalContent({{ $i }})">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $records->currentPage() == $records->lastPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0);"
                            onclick="loadGalleryModalContent({{ $records->currentPage() + 1 }})" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</div>


@if (isset($isChoose) && $isChoose)
    <script>
        const isChoose = true;
    </script>
    @include('admin.pages.gallery.script')
@else
    <script>
        const isChoose = false;
    </script>
@endif
