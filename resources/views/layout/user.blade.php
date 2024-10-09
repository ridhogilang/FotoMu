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
        @include('partials.sidebar_user')

        <div class="content-page">

            @include('partials.header_user')

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
    </script>
    <script>
        $(document).on('click', '.noti-close-btn', function() {
            var cartId = $(this).data('id'); // Mengambil ID cart item dari atribut data-id
            var url = '/pelanggan/cart/' + cartId;

            const toastMixin = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                backdrop: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(`#cart-item-${cartId}`).remove();
                    toastMixin.fire({
                        icon: 'success',
                        title: response.success || 'Item has been deleted'
                    });

                    setTimeout(function() {
                        location.reload(); // Reload the page after 3 seconds
                    }, 1000);
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    toastMixin.fire({
                        icon: 'error',
                        title: 'There was a problem deleting your item.'
                    });
                }
            });
        });
    </script>

    @stack('footer')
</body>

</html>
