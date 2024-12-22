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
                                <li class="breadcrumb-item"><a href="{{ route('user.produk') }}">FotoMu</a>
                                </li>
                                <li class="breadcrumb-item active">Konten Terhapus</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Konten Terhapus</h4>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="home-b2">
                    <div class="row">
                        @if ($foto->isEmpty())
                            <div class="col-12 text-center mt-5">
                                <img src="{{ asset('iconrobot/ROBOT OPTIMISTIC.png') }}" alt="No photos found"
                                    class="img-fluid mb-3" style="max-width: 200px;" />
                                <h3><strong>Tidak ada konten FotoMu yang terhapus</strong></h3><br>
                                <a href="{{ route('user.produk') }}" class="btn btn-primary">Kembali</a>
                            </div>
                        @else
                            @foreach ($foto as $similiar)
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
                                                    <button type="button"
                                                        class="btn btn-success waves-effect waves-light btn-pulihkan"
                                                        id="btn-pulihkan-{{ $similiar->id }}"
                                                        data-foto-id="{{ $similiar->id }}">Pulihkan</button>
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
                            {{ $foto->appends(['active_tab' => 'home-b2', 'similar_page' => request()->get('similar_page')])->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach click event listeners to all buttons dynamically
            document.querySelectorAll('.btn-pulihkan').forEach(function(button) {
                button.addEventListener('click', function() {
                    var fotoId = $(this).data('foto-id'); // Get foto_id from data attributes

                    // CSRF token (required for Laravel)
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');

                    // Send AJAX request
                    $.ajax({
                        url: '/pelanggan/similar-foto/pulihkan', // Route to the PulihkanSimilar method
                        type: 'POST',
                        data: {
                            foto_id: fotoId,
                            _token: token // Include CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success message using SweetAlert2
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'FotoMu berhasil dipulihkan.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location
                                    .reload(); // Reload the page if needed
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                alert(xhr.responseJSON.error);
                            } else {
                                alert('An error occurred.');
                            }
                        }
                    });
                });
            });
        });
    </script>
@endpush
