<!DOCTYPE html>
<html lang="en" data-layout="horizontal" data-topbar-color="dark">

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <script src="{{ asset('js/head.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    @stack('header')
</head>

<body>
    <div id="wrapper">
        @include('partials.sidebar')

        <div class="content-page">

            @include('partials.header')

            @yield('main')

            @include('partials.footer')
        </div>

    </div>

    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Display SweetAlert using Swal.fire() if toast_error exists in session
        @if (session('toast_error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('toast_error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        document.documentElement.setAttribute('data-bs-theme', 'light');
        document.documentElement.setAttribute('data-topbar-color', 'light');
        document.documentElement.setAttribute('data-layout', 'vertical');
    </script>
     <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: `
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                `,
                showConfirmButton: true,
            });
        @endif
    </script>
    @stack('footer')
</body>

</html>

