@extends('layout.user')

@push('header')
    <link href="{{ asset('libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                        <h4 class="page-title">FotoMu</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input class="form-control" id="event-search"
                                            placeholder="Search for an event..."></input>
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="home-b2">
                    <div class="row">
                        @if ($similarPhotos->isEmpty())
                            <div class="col-12 text-center mt-5">
                                <img src="{{ asset('iconrobot/ROBOT RESEARCH.png') }}" alt="No photos found"
                                    class="img-fluid" style="max-width: 200px;" />
                                <h3><strong>Jika foto belum ditemukan, coba tambahkan selfie di menu RoboMu 🤖</strong></h3>
                                <p>Kamu juga dapat menghubungi/menunggu fotografer untuk mengunggah fotomu. Jangan buat akun
                                    kedua.</p>
                                <a href="{{ route('user.retake') }}" class="btn btn-primary">Tambah Selfie</a>
                            </div>
                        @else
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
                                                        <h5 class="font-16 mt-0 sp-line-1">
                                                            <a href="ecommerce-product-detail.html" class="text-dark">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                {{ $similiar->event->event }}
                                                            </a>
                                                        </h5>
                                                        <h5 class="m-0">
                                                            <span class="text-muted">Fotografer:
                                                                {{ $similiar->fotografer->nama }}</span>
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
                                                                <span
                                                                    class="btn btn-danger waves-effect waves-light hapus-foto"
                                                                    title="Klik jika foto tidak sesuai denganMu!"
                                                                    tabindex="0" data-plugin="tippy"
                                                                    data-tippy-interactive="true"
                                                                    data-foto-id="{{ $similiar->id }}">
                                                                    <i class="mdi mdi-close-circle"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <form action="{{ route('cart.buyNow') }}" method="POST"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="foto_id"
                                                                        value="{{ $similiar->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">
                                                                        Beli Sekarang
                                                                    </button>
                                                                </form>
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
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ $similarPhotos->appends(['active_tab' => 'home-b2', 'similar_page' => request()->get('similar_page')])->links('pagination::custom-pagination') }}
                        </div>
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
                                                    <img src="{{ asset('foto/overlay-gembok.png') }}"
                                                        alt="Overlay Image">
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
                            {{ $event->appends(['active_tab' => 'profile-b2', 'event_page' => request()->get('event_page')])->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{ asset('js/pages/authentication.init.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectize@0.12.6/dist/css/selectize.default.css">
    <script src="https://cdn.jsdelivr.net/npm/selectize@0.12.6/dist/js/standalone/selectize.min.js"></script>
    {{-- Js untuk pagination --}}
    {{-- <script>
        $(document).ready(function() {
            // Save the active tab to local storage
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            // Check if active_tab parameter is present in the URL
            var activeTab = localStorage.getItem('activeTab');
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('active_tab')) {
                activeTab = '#' + urlParams.get('active_tab');
                localStorage.setItem('activeTab', activeTab); // Update local storage
            }

            // If an active tab is found, activate it
            if (activeTab) {
                $('a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            // Simpan tab aktif hanya di halaman /foto
            var currentPath = window.location.pathname;

            if (currentPath === '/pelanggan/foto') {
                // Simpan tab aktif ke localStorage ketika tab berubah
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    localStorage.setItem('activeTab', $(e.target).attr('href'));
                });

                // Cek apakah ada parameter active_tab di URL
                var urlParams = new URLSearchParams(window.location.search);
                var activeTab = localStorage.getItem('activeTab');

                // Jika ada active_tab di URL (misalnya dari pagination), gunakan itu sebagai activeTab
                if (urlParams.has('active_tab')) {
                    activeTab = '#' + urlParams.get('active_tab');
                    localStorage.setItem('activeTab', activeTab); // Simpan di localStorage
                }

                // Set tab default ke #home-b2 jika tidak ada activeTab di localStorage atau URL
                if (!activeTab || activeTab === '#') {
                    activeTab = '#home-b2'; // Tab default adalah home-b2
                }

                // Aktifkan tab sesuai activeTab
                $('a[href="' + activeTab + '"]').tab('show');
            } else {
                // Hapus activeTab dari localStorage jika keluar dari halaman /foto
                localStorage.removeItem('activeTab');
            }
        });
    </script>
    {{-- JS untuk login ke event private --}}
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
    {{-- Js untuk cart --}}
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
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer);
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer);
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
                        var response = xhr.responseJSON;
                        var errorMessage =
                            'Terjadi kesalahan saat memproses cart'; // Default error message

                        if (xhr.status === 422 && response && response.error) {
                            // Show the specific error message if it exists
                            errorMessage = response.error;
                        }

                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            backdrop: false,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer);
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer);
                            }
                        }).fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            });
        });
    </script>
    {{-- JS untuk search event --}}
    <script>
        async function reverseGeocode(lat, lon) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data && data.address) {
                    const {
                        city,
                        county,
                        state
                    } = data.address;
                    return `${city || county || ''}, ${state || ''}`;
                } else {
                    return "Unknown Location";
                }
            } catch (error) {
                console.error('Error fetching location:', error);
                return "Error fetching location";
            }
        }

        $(document).ready(function() {
            $('#event-search').selectize({
                valueField: 'encrypted_id',
                labelField: 'event',
                searchField: ['event', 'lokasi'],
                placeholder: 'Search for an event...',
                load: function(query, callback) {
                    if (!query.length) return callback();
                    this.clearOptions();

                    // Fetch events from the server
                    $.ajax({
                        url: '/pelanggan/search-event',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            query: query
                        },
                        error: function() {
                            callback();
                        },
                        success: async function(res) {
                            // Perform reverse geocoding on each item in the response
                            for (let i = 0; i < res.length; i++) {
                                if (res[i].lokasi) {
                                    var lokasiParts = res[i].lokasi.split(',');
                                    var lat = parseFloat(lokasiParts[0]);
                                    var lon = parseFloat(lokasiParts[1]);
                                    // Fetch human-readable location synchronously before rendering
                                    res[i].lokasi = await reverseGeocode(lat, lon);
                                } else {
                                    res[i].lokasi = "Location unavailable";
                                }
                            }
                            const uniqueResults = [];
                            const ids = new Set(); // Untuk menyimpan ID yang unik

                            res.forEach(function(item) {
                                if (!ids.has(item
                                    .id)) { // Jika ID belum ada, tambahkan ke hasil unik
                                    ids.add(item.id);
                                    uniqueResults.push(item);
                                }
                            });

                            callback(uniqueResults);
                        }
                    });
                },
                render: {
                    option: function(item, escape) {
                        // Now render the human-readable location directly
                        return '<div style="display: flex; align-items: center;">' +
                            '<img src="path_to_image/' + escape(item.image) +
                            '" alt="" style="width: 40px; height: 40px; margin-right: 10px;"/>' +
                            // Add margin for spacing
                            '<div style="display: flex; flex-direction: column;">' +
                            // Stack text vertically
                            '<span class="title" style="font-weight: bold;">' + escape(item.event) +
                            '</span>' + // Event name
                            '<span class="description" style="color: #666;">' + escape(item.lokasi) +
                            '</span>' + // Location below event
                            '</div>' +
                            '</div>';
                    }
                },
                onItemAdd: function(value, $item) {
                    var encryptedId = value;
                    var itemData = this.options[encryptedId];
                    var plainId = itemData.plain_id; // Get the plain ID
                    var isPrivate = itemData.is_private;

                    if (isPrivate) {
                        // Buat modal secara dinamis
                        var modalHtml = `
                        <div id="login-modal-search" class="modal js-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                <form action="/pelanggan/event/${plainId}/check-password" method="POST" class="px-3">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <div class="mb-3 mt-3">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" class="form-control"
                                                        placeholder="Masukkan password event" name="password">
                                                    <div class="input-group-text" data-password="false">
                                                        <span class="password-eye" onclick="togglePassword1(this)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2 text-center">
                                                <button class="btn rounded-pill btn-primary" type="submit">Masuk ke Event</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        // Hapus modal sebelumnya jika ada
                        $('#login-modal-search').remove();

                        // Tambahkan modal ke body
                        $('body').append(modalHtml);

                        // Tampilkan modal
                        var modal = new bootstrap.Modal(document.getElementById('login-modal-search'));
                        modal.show();
                    } else {
                        // Redirect ke halaman event
                        var url = '/pelanggan/foto/event/' + encryptedId;
                        window.location.href = url;
                    }

                    // Hapus item dari input setelah diklik
                    this.clear();
                },
                onDropdownClose: function($dropdown) {
                    this
                        .clear(); // Bersihkan input ketika dropdown ditutup untuk memastikan tidak ada teks yang tersisa
                },
                selectOnTab: false,
                create: false
            });
        });

        function togglePassword1(element) {
            const passwordField = element.closest('.input-group').querySelector(
                'input[type="password"], input[type="text"]');
            const passwordEye = element;

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordEye.parentElement.classList.add('show-password');
            } else {
                passwordField.type = 'password';
                passwordEye.parentElement.classList.remove('show-password');
            }
        }
    </script>
    {{-- <script>
        $(document).ready(function() {
            // Inisialisasi selectize untuk pencarian event
            var selectize = $('#event-search').selectize({
                valueField: 'encrypted_id',
                labelField: 'event',
                searchField: ['event', 'lokasi'],
                placeholder: 'Search for an event...',
                load: function(query, callback) {
                    if (!query.length) {
                        callback(); // Jangan muat jika query kosong
                        return;
                    }

                    // Bersihkan hasil pencarian sebelumnya dari dropdown
                    this.clearOptions();

                    $.ajax({
                        url: '/pelanggan/search-event',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            query: query
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            // Hapus duplikat berdasarkan 'id' event
                            const uniqueResults = [];
                            const ids = new Set(); // Untuk menyimpan ID yang unik

                            res.forEach(function(item) {
                                if (!ids.has(item
                                    .id)) { // Jika ID belum ada, tambahkan ke hasil unik
                                    ids.add(item.id);
                                    uniqueResults.push(item);
                                }
                            });

                            callback(uniqueResults); // Kirim hasil unik ke selectize
                        }
                    });
                },
                render: {
                    option: function(item, escape) {
                        // Render item dalam dropdown
                        return '<div>' +
                            '<img src="path_to_image/' + escape(item.image) +
                            '" alt="" style="width: 40px; height: 40px;"/>' +
                            '<span class="title"><strong>' + escape(item.event) +
                            '</strong></span><br>' +
                            '<span class="description">' + escape(item.lokasi) + '</span>' +
                            '</div>';
                    }
                },
                onItemAdd: function(value, $item) {
                    // Ambil ID dan data dari item yang ditambahkan
                    var encryptedId = value;
                    var itemData = this.options[encryptedId];
                    var plainId = itemData.plain_id; // ID event biasa
                    var isPrivate = itemData.is_private;

                    if (isPrivate) {
                        // Buat modal jika event bersifat private
                        var modalHtml = `
                        <div id="login-modal-search" class="modal js-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="/pelanggan/event/${plainId}/check-password" method="POST" class="px-3">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <div class="mb-3 mt-3">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" class="form-control"
                                                        placeholder="Masukkan password event" name="password">
                                                    <div class="input-group-text" data-password="false">
                                                        <span class="password-eye" onclick="togglePassword1(this)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2 text-center">
                                                <button class="btn rounded-pill btn-primary" type="submit">Masuk ke Event</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        // Hapus modal sebelumnya jika ada
                        $('#login-modal-search').remove();

                        // Tambahkan modal ke body
                        $('body').append(modalHtml);

                        // Tampilkan modal
                        var modal = new bootstrap.Modal(document.getElementById('login-modal-search'));
                        modal.show();
                    } else {
                        // Redirect ke halaman event jika bukan event private
                        var url = '/pelanggan/foto/event/' + encryptedId;
                        window.location.href = url;
                    }

                    // Hapus item dari input setelah diklik
                    this.clear();
                },
                onDropdownClose: function($dropdown) {
                    // Bersihkan input ketika dropdown ditutup
                    this.clear();
                    this.clearOptions(); // Bersihkan opsi yang ada di dropdown
                },
                selectOnTab: false,
                create: false
            });

            // Fungsi untuk menampilkan/menyembunyikan password
            function togglePassword1(element) {
                const passwordField = element.closest('.input-group').querySelector(
                    'input[type="password"], input[type="text"]');
                const passwordEye = element;

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordEye.parentElement.classList.add('show-password');
                } else {
                    passwordField.type = 'password';
                    passwordEye.parentElement.classList.remove('show-password');
                }
            }
        });
    </script> --}}

    {{-- JS hapus similar foto --}}
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                backdrop: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            $('.hapus-foto').click(function() {
                var button = $(this);
                var fotoId = button.data('foto-id');

                $.ajax({
                    url: '{{ route('similar-foto.hapus') }}', // Route ke updateHapus
                    type: 'POST',
                    data: {
                        foto_id: fotoId,
                        _token: '{{ csrf_token() }}' // Laravel CSRF token untuk keamanan
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.success
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: xhr.responseJSON ? xhr.responseJSON.error :
                                'Kesalahan tidak diketahui'
                        });
                    }
                });
            });
        });
    </script>
@endpush
