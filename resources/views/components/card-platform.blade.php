@props(['title', 'value'])

<div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
    <div class="text-md-center text-xl-left">
        <h6 class="mb-1">{{ $title }}</h6>
    </div>
    <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
        <h6 class="font-weight-bold mb-0">{{ $value }}</h6>
    </div>
</div>
