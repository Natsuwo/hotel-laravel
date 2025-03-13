@props(['errors'])
@if ($errors->any())
    <div class="col-md-12">
        <div class="alert alert-danger text-sm text-red-600 dark:text-red-400 space-y-1" role="alert">
            <ul class="mb-0 pl-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
