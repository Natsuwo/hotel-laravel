@props(['image', 'url', 'isChoose' => false, 'selectable' => false])

<div class="image-container" onclick="toggleCheckbox(event, this, {{ json_encode($image) }})">
    <img src="{{ $url }}" alt="{{ $image->title }}" data-id="{{ $image->id }}" data-title="{{ $image->title }}"
        data-width="{{ $image->width }}" data-height="{{ $image->height }}" class="gallery-image">
    <div class="image-info">
        <div style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Title:
                {{ $image->title }}</div>
            <div>Width: {{ $image->width }}px</div>
            <div>Height: {{ $image->height }}px</div>
            <button class="btn btn-danger" onclick="deleteFile('{{ $image->id }}')" type="button"
                data-id="{{ $image->id }}">Delete</button>
        </div>
    </div>
    @if ($selectable)
        <input style="position: absolute; top:0;right:0;" type="checkbox" class="select-checkbox">
        <script>
            var gallerySelected = [];

            function toggleCheckbox(event, container, image) {
                if (event.target.tagName !== 'INPUT' && event.target.tagName !== 'BUTTON') {
                    const checkbox = container.querySelector('.select-checkbox');
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;

                        if (checkbox.checked) {
                            if (!image.id) {
                                return;
                            }
                            image.url = container.querySelector('img').src;
                            gallerySelected.push(image);
                        } else {
                            gallerySelected = gallerySelected.filter((item) => item.id !== image.id);
                        }
                    }
                }
            }
        </script>
    @endif
</div>




<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 5px;
    }

    .image-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px;
        display: none;
        width: 100%;
        height: 100%;
        text-align: center;
    }

    .image-info div div {
        margin: 5px 0;
        border-bottom: 1px solid #fafafa;
    }

    .image-container:hover .image-info {
        display: block;
    }

    .delete-btn {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-top: 5px;
    }
</style>
