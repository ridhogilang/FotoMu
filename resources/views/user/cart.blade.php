@extends('layout.user')

@push('header')
@endpush

@section('main')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pemesanan</a>
                                </li>
                                <li class="breadcrumb-item active">Cart List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Cart</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('user.pemesanan') }}" method="POST" class="row">
                                @csrf
                                <div class="col-lg-8">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-nowrap table-centered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Foto</th>
                                                    <th>Harga</th>
                                                    <th style="width: 50px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cart as $cartItem)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ Storage::url($cartItem->foto->fotowatermark) }}"
                                                                alt="contact-img" title="contact-img" class="rounded me-3"
                                                                height="48" />
                                                            <p class="m-0 d-inline-block align-middle font-16">
                                                                <a href="ecommerce-product-detail.php"
                                                                    class="text-reset font-family-secondary">{{ $cartItem->foto->event->event }}</a>
                                                                <br>
                                                                <small
                                                                    class="me-2"><b>{{ $cartItem->user->name }}</b></small>
                                                                <small><b>Resolusi :</b> {{ $cartItem->foto->resolusi }}
                                                                </small>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            Rp. {{ number_format($cartItem->foto->harga, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            <span class="action-icon hapus-cart"
                                                                id="close-btn-{{ $cartItem->id }}"
                                                                data-id="{{ $cartItem->id }}">
                                                                <i class="mdi mdi-delete"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <input type="hidden" name="foto_ids[]" value="{{ $cartItem->foto_id }}">
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                        
                                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="totalharga" id="totalharga" value="{{ $totalPayment }}">
                                        <div class="mt-3">
                                        <label for="example-textarea" class="form-label">Catatan :</label>
                                        <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Write some note.."></textarea>
                                    </div>

                                    <!-- action buttons-->
                                    <div class="row mt-4">
                                        <div class="col-sm-6">
                                            <a href="{{ url()->previous() }}"
                                                class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                <i class="mdi mdi-arrow-left"></i> Continue Shopping </a>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </div>
                                <!-- end col -->

                                <div class="col-lg-4">
                                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                                        <h4 class="header-title mb-3">Ringkasan Pembelian</h4>

                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Total :</td>
                                                        <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Biaya Admin :</td>
                                                        <td>Rp. {{ number_format($adminFee, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pajak :</td>
                                                        <td>Rp. {{ number_format($tax, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Pembayaran :</th>
                                                        <th>Rp. {{ number_format($totalPayment, 0, ',', '.') }}</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <div class="text-sm-end mt-2 mt-sm-0">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="mdi mdi-truck-fast me-1"></i> Proceed to Shipping </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->

                            </form> <!-- end row -->
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection

@push('footer')
    <script>
        $(document).on('click', '.hapus-cart', function() {
            var cartId = $(this).data('id'); // Mengambil ID cart item dari atribut data-id
            var url = '/pelanggan/cart/' + + cartId;

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

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda Yakin?',
                text: "Foto akan dihapus dari keranjang anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Corrected selector
                            $('#cart-item-' + cartId).remove();
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
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastMixin.fire({
                        icon: 'info',
                        title: 'Item deletion cancelled'
                    });
                }
            });
        });
    </script>
@endpush
