@extends('layout.user')

@push('header')
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pemesanan</a></li>
                                <li class="breadcrumb-item active">Pesanan List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pesanan</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('user.download') }}"
                                class="btn btn-sm btn-blue waves-effect waves-light float-end">
                                <i class="mdi mdi-download"></i> Download FotoMu
                            </a>
                            <h4 class="header-title mb-4">Pesanan Anda</h4>

                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100"
                                    id="tickets-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>Invoice</th>
                                            <th>Total Harga</th>
                                            <th>Catatan</th>
                                            <th>Status</th>
                                            <th class="hidden-sm">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($pesanan as $pesananItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>
                                                    #0000{{ $pesananItem->id }}
                                                </td>

                                                <td>{{ 'Rp. ' . number_format($pesananItem->totalharga, 0, ',', '.') }}</td>


                                                <td>
                                                    {{ $pesananItem->catatan }}
                                                </td>
                                                @if ($pesananItem->status == 'Selesai')
                                                    <td>
                                                        <span class="badge bg-success">{{ $pesananItem->status }}</span>
                                                    </td>
                                                @elseif ($pesananItem->status == 'Menunggu Pembayaran')
                                                    <td>
                                                        <span class="badge bg-warning">{{ $pesananItem->status }}</span>
                                                    </td>
                                                @elseif ($pesananItem->status == 'Dibatalkan')
                                                    <td>
                                                        <span class="badge bg-danger">{{ $pesananItem->status }}</span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <span class="badge bg-warning">{{ $pesananItem->status }}</span>
                                                    </td>
                                                @endif
                                                @switch($pesananItem->status)
                                                    @case('Diproses')
                                                        <td>
                                                            <a class="dropdown-item"
                                                            href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"><i
                                                                class="mdi mdi-bank-transfer me-2 text-muted font-18 vertical-middle"></i>Bayar
                                                            Sekarang</a>
                                                        </td>
                                                    @break

                                                    @case('Menunggu Pembayaran')
                                                        <td>
                                                            <div class="btn-group dropdown">
                                                                <a href="javascript: void(0);"
                                                                    class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"><i
                                                                            class="mdi mdi-bank-transfer me-2 text-muted font-18 vertical-middle"></i>Bayar
                                                                        Sekarang</a>
                                                                    <a class="dropdown-item btn-cancel-order" href="#"
                                                                        data-order-id="{{ $pesananItem->id }}">
                                                                        <i
                                                                            class="mdi mdi-cancel me-2 text-muted font-18 vertical-middle"></i>Batalkan
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @break

                                                    @case('Selesai')
                                                        <td> 
                                                            <a href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}" class="action-icon">
                                                                <i class="mdi mdi-file-document-outline"></i>
                                                            </a> 
                                                        </td>
                                                    @break

                                                    @case('Dibatalkan')
                                                        <td> 
                                                            <a href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}" class="action-icon">
                                                            <i class="mdi mdi-file-document-outline"></i>
                                                        </a> </td>
                                                    @break
                                                @endswitch
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/pages/tickets.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    // Delegasikan event untuk menangkap klik tombol pembatalan
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.btn-cancel-order')) { // Tangkap elemen dengan class btn-cancel-order
            e.preventDefault();

            const button = e.target.closest('.btn-cancel-order'); // Elemen tombol yang diklik
            const orderId = button.getAttribute('data-order-id'); // Ambil data-order-id

            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pesanan akan dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request pembatalan
                    fetch(`/pelanggan/pesanan/dibatalkan/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Dibatalkan!',
                                'Pesanan berhasil dibatalkan.',
                                'success'
                            );
                            // Reload halaman atau lakukan tindakan lain
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire(
                                'Gagal!',
                                data.message || 'Gagal membatalkan pesanan.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Terjadi Kesalahan!',
                            'Tidak dapat membatalkan pesanan.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
                }
            });
        }
    });
});

    </script>
@endpush
