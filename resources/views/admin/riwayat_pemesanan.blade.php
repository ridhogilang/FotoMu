@extends('layout.admin')

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
                                <li class="breadcrumb-item active">Riwayat Pemesanan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Riwayat Pemesanan List</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Riwayat Pemesanan</h4>

                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-centered nowrap w-100" id="tickets-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>Nama</th>
                                            <th>No. Whatsapp</th>
                                            <th>Harga</th>
                                            <th>Jumlah Foto</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($pemesanan as $pemesananItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>{{ $pemesananItem->user->name }}</td>
                                                <td>{{ $pemesananItem->user->nowa }}</td>
                                                <td>{{ 'Rp. ' . number_format($pemesananItem->totalharga, 0, ',', '.') }}
                                                </td>
                                                <td>{{ $pemesananItem->detail_pesanan_count }} Foto</td>
                                                @if ($pemesananItem->status == 'Diproses' || $pemesananItem->status == 'Menunggu Pembayaran')
                                                    <td>
                                                        <span
                                                            class="badge label-table bg-warning">{{ $pemesananItem->status }}</span>
                                                    </td>
                                                @elseif ($pemesananItem->status == 'Selesai')
                                                    <td>
                                                        <span
                                                            class="badge label-table bg-success">{{ $pemesananItem->status }}</span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <span
                                                            class="badge label-table bg-danger">{{ $pemesananItem->status }}</span>
                                                    </td>
                                                @endif
                                                <td>{{ $pemesananItem->updated_at->format('d M Y') }}</td>
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
@endpush
