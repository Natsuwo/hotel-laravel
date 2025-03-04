@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="purchase_price">Purchase Price</label>
                                <input type="number" name="purchase_price" id="purchase_price" class="form-control"
                                    value="{{ old('purchase_price') }}" step="0.1">
                            </div>
                            <div class="form-group">
                                <label for="selling_price">Selling Price</label>
                                <input type="number" name="selling_price" id="selling_price" class="form-control"
                                    value="{{ old('selling_price') }}" step="0.1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-gallery-modal id="galleryModal"></x-gallery-modal>

                                <div class="form-group select-image">
                                    <label>Room Images</label>
                                    <div id="drop-area" class="drop-area"
                                        style="border: 2px dashed #ccc; padding: 20px; text-align: center;"
                                        onclick="$('#galleryModal').modal('show');">
                                        <p>Drag & Drop your files here or click to upload</p>
                                        <div id="input-area"></div>
                                        <div class="d-flex flex-wrap" id="image_preview_container"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="others" {{ old('category') == 'others' ? 'selected' : '' }}>Others
                                    </option>
                                    <option value="linen" {{ old('category') == 'linen' ? 'selected' : '' }}>Linen</option>
                                    <option value="toiletries" {{ old('category') == 'toiletries' ? 'selected' : '' }}>
                                        Toiletries</option>
                                    <option value="refreshments" {{ old('category') == 'refreshments' ? 'selected' : '' }}>
                                        Refreshments</option>
                                    <option value="housekeeping" {{ old('category') == 'housekeeping' ? 'selected' : '' }}>
                                        Housekeeping</option>
                                    <option value="food_and_beverage"
                                        {{ old('category') == 'food_and_beverage' ? 'selected' : '' }}>F&B</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stock_quantity">Stock Quantity</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                    value="{{ old('stock_quantity') }}">
                            </div>
                            <div class="form-group">
                                <label for="reorder_level">Reorder Level</label>
                                <input type="number" name="reorder_level" id="reorder_level" class="form-control"
                                    value="{{ old('reorder_level') }}">
                            </div>
                            <div class="form-group">
                                <label for="safety_stock">Safety Stock</label>
                                <input type="number" name="safety_stock" id="safety_stock" class="form-control"
                                    value="{{ old('safety_stock') }}">
                            </div>

                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('admin.blocks.froala_script')
@section('my-script')
    <script>
        new FroalaEditor('#description', {
            theme: 'dark',
        });

        function chooseFile() {
            // clear previewContainer
            const previewContainer = $('#image_preview_container');
            previewContainer.html('');
            gallerySelected.forEach((image) => {
                if (!image.id) return;
                var input = $('<input>').attr('type', 'hidden').attr('name', 'gallery_id').val(image.id);
                $('#input-area').html(input);
                previewContainer.html(
                    `<div class="p-2" style="flex: 0 0 50%;"><img src="${image.url}" style="max-width: 100%; margin: 10px; display: block;"></div>`
                );
            });
        }
    </script>
@endsection
