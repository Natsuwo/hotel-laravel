<!DOCTYPE html>
<html lang="en">

@include('admin.blocks.header')

<body>
    <style>
        select {
            color: #fff !important;
        }
    </style>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.blocks.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            @include('admin.blocks.navbar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <x-error-form :error="$errors"></x-alert>
                        <div class="flash">
                            @if (Session::has('success'))
                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @elseif (Session::has('error'))
                                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                            @endif
                        </div>
                        @yield('content')
                </div>
                @include('admin.blocks.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    @include('admin.blocks.script')
    @yield('my-script')
    @stack('scripts')
</body>

</html>
