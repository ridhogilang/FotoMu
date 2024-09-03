@extends('layout.user')

@push('header')
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
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex align-self-center me-3 rounded-circle"
                                            src="{{ asset('images/companies/amazon.png') }}" alt="Generic placeholder image"
                                            height="64">
                                        <div class="w-100 ms-3">
                                            <h4 class="mt-0 mb-2 font-16">{{ $event->event }}</h4>
                                            <p class="mb-1"><b>Jumlah :</b> {{ $event->foto_count }} Foto</p>
                                            <p class="mb-0"><b>Tanggal :</b>
                                                {{ \Carbon\Carbon::parse($event->created_at)->translatedFormat('d F Y') }}
                                            </p>
                                        </div>
                                        <div class="w-100 ms-2">
                                            <p class="mb-1"><b>Deskripsi:</b> {{ $event->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <div class="text-lg-end my-1 my-lg-0">
                                        <button type="button" class="btn btn-success waves-effect waves-light me-1">
                                            <i class="mdi mdi-cog"></i>
                                        </button>
                                        <a href="ecommerce-product-edit.html"
                                            class="btn btn-danger waves-effect waves-light">
                                            <i class="mdi mdi-map-marker me-1"></i> Lihat Lokasi
                                        </a>
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
                        @foreach ($similarPhotos as $similar)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card product-box">
                                    <div class="card-body">
                                        <div class="bg-light">
                                            <img src="{{ Storage::url($similar->fotowatermark) }}" alt="product-pic"
                                                class="img-fluid" />
                                        </div>

                                        <div class="product-info">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="font-16 mt-0 sp-line-1"><a
                                                            href="ecommerce-product-detail.html" class="text-dark"><i
                                                                class="fas fa-map-marker-alt"></i>
                                                            {{ $similar->event->event }}</a></h5>
                                                    <h5 class="m-0"> <span class="text-muted"> Fotografer :
                                                            {{ $similar->fotografer->nama }}</span>
                                                    </h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="product-price-tag">
                                                        {{ number_format($similar->harga / 1000, 0, ',', '.') . 'K' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="btn btn-danger waves-effect waves-light hapus-foto" title="Klik jika foto tidak sesuai denganMu!" tabindex="0" data-plugin="tippy" data-tippy-interactive="true" data-foto-id="{{ $similar->id }}"><i
                                                                class="mdi mdi-close-circle"></i></span>
                                                        </div>
                                                        <div>
                                                            <form action="{{ route('cart.buyNow') }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="foto_id" value="{{ $similar->id }}">
                                                                <button type="submit" class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">
                                                                    Beli Sekarang
                                                                </button>
                                                            </form>
                                                            <button type="button"
                                                                class="btn {{ in_array($similar->id, $cartItemIds) ? 'btn-success' : 'btn-outline-success' }} waves-effect waves-light add-to-cart"
                                                                data-foto-id="{{ $similar->id }}">
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
                            {{ $similarPhotos->appends(['active_tab' => 'home-b2'])->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-b2">
                    <div class="row">
                        @foreach ($semuaFoto as $FotoAll)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card product-box">
                                    <div class="card-body">
                                        <div class="bg-light">
                                            <img src="{{ Storage::url($FotoAll->fotowatermark) }}" alt="product-pic"
                                                class="img-fluid" />
                                        </div>

                                        <div class="product-info">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="font-16 mt-0 sp-line-1"><a
                                                            href="ecommerce-product-detail.html" class="text-dark"><i
                                                                class="fas fa-map-marker-alt"></i>
                                                            {{ $FotoAll->event->event }}</a></h5>
                                                    <h5 class="m-0"> <span class="text-muted"> Fotografer :
                                                            {{ $FotoAll->fotografer->name }}</span>
                                                    </h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="product-price-tag">
                                                        {{ number_format($FotoAll->harga / 1000, 0, ',', '.') . 'K' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            @php
                                                                $inWishlist = in_array($FotoAll->id, $wishlist);
                                                            @endphp
                                                            <button
                                                                class="btn {{ $inWishlist ? 'btn-danger' : 'btn-outline-danger' }} waves-effect waves-light toggle-wishlist"
                                                                data-foto-id="{{ $FotoAll->id }}">
                                                                <i class="mdi mdi-heart-outline"></i>
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <form action="{{ route('cart.buyNow') }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="foto_id" value="{{ $FotoAll->id }}">
                                                                <button type="submit" class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">
                                                                    Beli Sekarang
                                                                </button>
                                                            </form>
                                                            <button type="button"
                                                                class="btn {{ in_array($FotoAll->id, $cartItemIds) ? 'btn-success' : 'btn-outline-success' }} waves-effect waves-light add-to-cart"
                                                                data-foto-id="{{ $FotoAll->id }}">
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
                            {{ $semuaFoto->appends(['active_tab' => 'profile-b2'])->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
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
    </script>
    <script>
        $(document).ready(function() {
            $('.toggle-wishlist').click(function() {
                var button = $(this);
                var fotoId = button.data('foto-id');
                $.ajax({
                    url: '{{ route('wishlist.toggle') }}',
                    type: 'POST',
                    data: {
                        foto_id: fotoId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var countElement = $('#wishlist-count');
                        var currentCount = parseInt(countElement.text());

                        if (response.added) {
                            button.removeClass('btn-outline-danger').addClass('btn-danger');
                            button.find('i').removeClass('mdi-heart-outline').addClass(
                                'mdi-heart');
                            countElement.text(currentCount + 1); // Tambah 1 ke jumlah wishlist
                        } else {
                            button.removeClass('btn-danger').addClass('btn-outline-danger');
                            button.find('i').removeClass('mdi-heart').addClass(
                                'mdi-heart-outline');
                            countElement.text(currentCount -
                                1); // Kurangi 1 dari jumlah wishlist
                        }

                        // Periksa jumlah wishlist setelah di-update
                        currentCount = parseInt(countElement.text());
                        if (currentCount > 0) {
                            countElement.show();
                        } else {
                            countElement.hide();
                        }

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
                            icon: response.added ? 'success' : 'info',
                            title: response.success
                        });
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
                            title: 'Terjadi kesalahan saat mengubah wishlist'
                        });
                    }
                });
            });
        });
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
