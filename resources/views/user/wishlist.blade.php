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
                            <a href="{{ route('user.produk') }}" class="btn btn-primary waves-effect waves-light"><i
                                    class="mdi mdi-arrow-left-bold me-1"></i> Kembali</a>
                        </div>
                        <h4 class="page-title">Wishlist</h4>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="profile-b3">
                    <div class="row">
                        @if ($semuaFoto->isEmpty())
                            <div class="col-12 text-center mt-5">
                                <img src="{{ asset('iconrobot/ROBOT SAD.png') }}" alt="No photos found"
                                    class="img-fluid mb-3" style="max-width: 200px;" />
                                <h3><strong>Anda belum mempunyai Wishlist di Konten FotoMu </strong></h3><br>
                                <a href="{{ route('user.produk') }}" class="btn btn-primary">Kembali</a>
                            </div>
                        @else
                            @foreach ($semuaFoto as $FotoAll)
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="card product-box">
                                        <div class="card-body">
                                            <div class="bg-light">
                                                <img src="{{ Storage::url($FotoAll->foto->fotowatermark) }}"
                                                    alt="product-pic" class="img-fluid" />
                                            </div>

                                            <div class="product-info">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h5 class="font-16 mt-0 sp-line-1"><a
                                                                href="ecommerce-product-detail.html" class="text-dark"><i
                                                                    class="fas fa-map-marker-alt"></i>
                                                                {{ $FotoAll->foto->event->event }}</a></h5>
                                                        <h5 class="m-0"> <span class="text-muted"> Fotografer :
                                                                {{ $FotoAll->foto->fotografer->nama }}</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="product-price-tag">
                                                            {{ number_format($FotoAll->foto->harga / 1000, 0, ',', '.') . 'K' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-3">
                                                    <div class="col-12">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                @php
                                                                    $inWishlist = in_array(
                                                                        $FotoAll->foto->id,
                                                                        $wishlist,
                                                                    );
                                                                @endphp
                                                                <button
                                                                    class="btn {{ $inWishlist ? 'btn-danger' : 'btn-outline-danger' }} waves-effect waves-light toggle-wishlist"
                                                                    data-foto-id="{{ $FotoAll->foto->id }}">
                                                                    <i class="mdi mdi-heart-outline"></i>
                                                                </button>
                                                            </div>
                                                            <div>
                                                                <form action="{{ route('cart.buyNow') }}" method="POST"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="foto_id"
                                                                        value="{{ $FotoAll->foto->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">
                                                                        Beli Sekarang
                                                                    </button>
                                                                </form>
                                                                <button type="button"
                                                                    class="btn {{ in_array($FotoAll->foto->id, $cartItemIds) ? 'btn-success' : 'btn-outline-success' }} waves-effect waves-light add-to-cart"
                                                                    data-foto-id="{{ $FotoAll->foto->id }}">
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
                            {{ $semuaFoto->appends(['active_tab' => 'profile-b3'])->links('pagination::custom-pagination') }}
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
            $('.toggle-wishlist').click(function() {
                var button = $(this);
                var fotoId = button.data('foto-id');
                $.ajax({
                    url: '/pelanggan/toggle-whishlist',
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
                            icon: response.added ? 'success' : 'success',
                            title: response.success
                        }).then(() => {
                            window.location.reload();
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
                        }).then(() => {
                            // Reload halaman setelah toast selesai
                            window.location.reload();
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
                    url: '/pelanggan/toggle-cart',
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
