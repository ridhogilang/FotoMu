@extends('layout.user')

@push('header')
    <style>
        .bg-light {
            position: relative;
            /* Agar overlay bisa diposisikan absolut di dalamnya */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparan hitam */
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .bg-light:hover .overlay {
            opacity: 2;
            /* Tampilkan overlay saat hover */
        }

        .overlay img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            opacity: 0.8;
            /* Sesuaikan sesuai kebutuhan */
        }
    </style>
@endpush

@section('main')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a>
                                </li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Products</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <form class="d-flex flex-wrap align-items-center">
                                        <label for="inputPassword2" class="visually-hidden">Search</label>
                                        <div class="me-3">
                                            <input type="search" class="form-control my-1 my-lg-0" id="inputPassword2"
                                                placeholder="Search...">
                                        </div>
                                        <label for="status-select" class="me-2">Sort By</label>
                                        <div class="me-sm-3">
                                            <select class="form-select my-1 my-lg-0" id="status-select">
                                                <option selected="">All</option>
                                                <option value="1">Popular</option>
                                                <option value="2">Price Low</option>
                                                <option value="3">Price High</option>
                                                <option value="4">Sold Out</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <div class="text-lg-end my-1 my-lg-0">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#login-modal"
                                            class="btn btn-success waves-effect waves-light me-1"><i
                                                class="mdi mdi-cog"></i></button>
                                        <a href="ecommerce-product-edit.html"
                                            class="btn btn-danger waves-effect waves-light"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add New</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <ul class="nav nav-tabs nav-bordered nav-justified mb-2">
                                    <li class="nav-item">
                                        <a href="#home-b2" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                            FotoMu
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#profile-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Galeri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#messages-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            Messages
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="home-b2">
                    <div class="row">
                        @foreach ($similarPhotos as $similiar)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card product-box">
                                    <div class="card-body">
                                        <div class="bg-light">
                                            <img src="{{ Storage::url($similiar->fotowatermark) }}" alt="product-pic"
                                                class="img-fluid" />
                                        </div>
                                        <div class="product-info">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="font-16 mt-0 sp-line-1"><a
                                                            href="ecommerce-product-detail.html" class="text-dark"><i
                                                                class="fas fa-map-marker-alt"></i>
                                                            {{ $similiar->event->event }}</a></h5>
                                                    <h5 class="m-0"> <span class="text-muted"> Fotografer :
                                                            {{ $similiar->user->name }}</span>
                                                    </h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="product-price-tag">
                                                        {{ number_format($similiar->harga / 1000, 0, ',', '.') . 'K' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <button class="btn btn-danger waves-effect waves-light"><i
                                                                    class="mdi mdi-close-circle"></i></button>
                                                        </div>
                                                        <div>
                                                            <button
                                                                class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">Beli
                                                                Sekarang</button>
                                                            <button type="button"
                                                                class="btn {{ in_array($similiar->id, $cartItemIds) ? 'btn-success' : 'btn-outline-success' }} waves-effect waves-light add-to-cart"
                                                                data-foto-id="{{ $similiar->id }}">
                                                                <i class="mdi mdi-cart"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul class="pagination pagination-rounded justify-content-end mb-3">
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- end col-->
                    </div>
                </div>
                <div class="tab-pane" id="profile-b2">
                    <div class="row">
                        @foreach ($event as $eventItem)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card product-box">
                                    <div class="card-body">
                                        <div class="bg-light">
                                            <img src="{{ asset('images/products/product-1.png') }}" alt="product-pic"
                                                class="img-fluid" />

                                            @if ($eventItem->is_private)
                                                <div class="overlay">
                                                    <img src="{{ asset('foto/overlay-gembok.png') }}" alt="Overlay Image">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="product-info">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="font-16 mt-0 sp-line-1">
                                                        @if ($eventItem->is_private)
                                                            <a href="#" class="text-dark" data-bs-toggle="modal"
                                                                data-bs-target="#login-modal"
                                                                data-event-id="{{ $eventItem->id }}">{{ $eventItem->event }}</a>
                                                        @else
                                                            <a href="{{ route('user.event', ['id' => Crypt::encryptString($eventItem->id)]) }}"
                                                                class="text-dark">{{ $eventItem->event }}</a>
                                                        @endif
                                                    </h5>
                                                    <div class="text-warning mb-2 font-13">
                                                        <p>{{ $eventItem->deskripsi }}</p>
                                                    </div>
                                                    <h5 class="m-0"> <span class="text-muted"> Jumlah :
                                                            {{ $eventItem->foto_count }} Foto</span>
                                                    </h5>
                                                </div>
                                                <div class="col-auto">
                                                    <svg height="30" viewBox="0 0 64 64" width="30"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g id="camera_shop-video_camera-location-pin-map"
                                                            data-name="camera shop-video camera-location-pin-map">
                                                            <ellipse cx="32" cy="57" fill="#ebe5dd"
                                                                rx="10" ry="4" />
                                                            <path
                                                                d="m42 57c0 2.21-4.48 4-10 4-.68 0-1.35-.03-1.99-.08 4.56-.37 7.99-1.99 7.99-3.92s-3.43-3.55-7.99-3.92c.64-.05 1.31-.08 1.99-.08 5.52 0 10 1.79 10 4z"
                                                                fill="#c0ab91" />
                                                            <path
                                                                d="m52 23c0 10.94-10.64 24.01-16.4 30.28-2.14 2.33-3.6 3.72-3.6 3.72s-1.46-1.39-3.6-3.72c-5.76-6.27-16.4-19.34-16.4-30.28a20 20 0 0 1 40 0z"
                                                                fill="#fd7777" />
                                                            <path
                                                                d="m52 23c0 10.94-10.64 24.01-16.4 30.28-2.14 2.33-3.6 3.72-3.6 3.72s-.76-.73-2-2.01c.46-.49 1.01-1.07 1.6-1.71 5.76-6.27 16.4-19.34 16.4-30.28a20 20 0 0 0 -18-19.9 18.862 18.862 0 0 1 2-.1 19.994 19.994 0 0 1 20 20z"
                                                                fill="#ff3051" />
                                                            <circle cx="32" cy="23" fill="#fee9ab"
                                                                r="16" />
                                                            <path
                                                                d="m48 23a16 16 0 0 1 -16 16 16.524 16.524 0 0 1 -2-.12 16 16 0 0 0 0-31.75 14.713 14.713 0 0 1 2-.13 16 16 0 0 1 16 16z"
                                                                fill="#ffde55" />
                                                            <path d="m22 17h20v12h-20z" fill="#a78966" />
                                                            <circle cx="32" cy="23" fill="#898890" r="6" />
                                                            <path
                                                                d="m38 23a6 6 0 0 1 -6 6 5.8 5.8 0 0 1 -2-.35 5.99 5.99 0 0 0 0-11.3 5.8 5.8 0 0 1 2-.35 6 6 0 0 1 6 6z"
                                                                fill="#57565c" />
                                                            <path d="m29 13h6v4h-6z" fill="#c6c5ca" />
                                                            <circle cx="32" cy="23" fill="#ff3051" r="2" />
                                                            <path
                                                                d="m34 23a2 2 0 0 1 -3 1.73 2 2 0 0 0 0-3.46 2 2 0 0 1 3 1.73z"
                                                                fill="#cd2a00" />
                                                            <path d="m32 13h3v4h-3z" fill="#898890" />
                                                            <path d="m38 17h4v12h-4z" fill="#806749" />
                                                            <path
                                                                d="m32 6a17 17 0 1 0 17 17 17.024 17.024 0 0 0 -17-17zm0 32a15 15 0 1 1 15-15 15.018 15.018 0 0 1 -15 15z" />
                                                            <path
                                                                d="m37.54 52.65c6.02-6.75 15.46-19.03 15.46-29.65a21 21 0 0 0 -42 0c0 10.62 9.44 22.9 15.46 29.65-3.41.84-5.46 2.44-5.46 4.35 0 3.25 5.67 5 11 5s11-1.75 11-5c0-1.91-2.05-3.51-5.46-4.35zm-24.54-29.65a19 19 0 0 1 38 0c0 12.84-15.51 29.1-19 32.6-3.49-3.5-19-19.76-19-32.6zm19 37c-5.49 0-9-1.78-9-3 0-.74 1.58-2.01 5.03-2.63 1.81 1.94 3.08 3.17 3.28 3.35a.99.99 0 0 0 1.38 0c.2-.18 1.47-1.41 3.28-3.35 3.45.62 5.03 1.89 5.03 2.63 0 1.22-3.51 3-9 3z" />
                                                            <path
                                                                d="m35.73 48.65c-.99 1.15-2 2.28-3 3.34a1.007 1.007 0 0 1 -.73.32 1.024 1.024 0 0 1 -.73-.32c-1-1.07-2.01-2.2-2.99-3.34l1.52-1.3c.4.46.8.9 1.2 1.35v-2.7h2v2.71c.4-.45.81-.9 1.21-1.36z" />
                                                            <path
                                                                d="m42 16h-1v-2h-2v2h-3v-3a1 1 0 0 0 -1-1h-6a1 1 0 0 0 -1 1v3h-3v-2h-2v2h-1a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1v-12a1 1 0 0 0 -1-1zm-12-2h4v2h-4zm-7 14v-10h4.11a6.979 6.979 0 0 0 0 10zm9 0a5 5 0 1 1 5-5 5 5 0 0 1 -5 5zm9 0h-4.11a6.979 6.979 0 0 0 0-10h4.11z" />
                                                            <path d="m31 42h2v2h-2z" />
                                                            <path
                                                                d="m32 20a3 3 0 1 0 3 3 3 3 0 0 0 -3-3zm0 4a1 1 0 1 1 1-1 1 1 0 0 1 -1 1z" />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div> <!-- end row -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="login-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="{{ route('event.check-password', ['id' => $eventItem->id]) }}"
                                                method="POST" class="px-3">
                                                @csrf
                                                <div class="mb-3 mt-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="password" class="form-control"
                                                            placeholder="Masukkan password event" name="password">
                                                        <div class="input-group-text" data-password="false">
                                                            <span class="password-eye" onclick="togglePassword()"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-2 text-center">
                                                    <button class="btn rounded-pill btn-primary" type="submit">Masuk ke
                                                        Event</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul class="pagination pagination-rounded justify-content-end mb-3">
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- end col-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{ asset('js/pages/authentication.init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let loginModal = document.getElementById('login-modal');
            loginModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let eventId = button.getAttribute('data-event-id');
                let form = loginModal.querySelector('form');

                form.setAttribute('action', `/pelanggan/event/${eventId}/check-password`);
            });
        });

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordEye = document.querySelector('.password-eye');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordEye.parentElement.classList.add('show-password');
            } else {
                passwordField.type = 'password';
                passwordEye.parentElement.classList.remove('show-password');
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var button = $(this);
                var fotoId = button.data('foto-id');
                $.ajax({
                    url: '{{ route('cart.toggle') }}',
                    type: 'POST',
                    data: {
                        foto_id: fotoId,
                        _token: '{{ csrf_token() }}' // Laravel CSRF token untuk keamanan
                    },
                    success: function(response) {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            backdrop: false,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        }).fire({
                            icon: 'success',
                            title: response.success
                        });

                        // Toggle class button
                        if (response.status === 'added') {
                            button.removeClass('btn-outline-success').addClass('btn-success');
                        } else if (response.status === 'removed') {
                            button.removeClass('btn-success').addClass('btn-outline-success');
                        }

                        setTimeout(function() {
                            location.reload(); // Reload the page after 3 seconds
                        }, 1000);
                    },
                    error: function(xhr) {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            backdrop: false,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        }).fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat memproses cart'
                        });
                    }
                });
            });
        });
    </script>
@endpush
