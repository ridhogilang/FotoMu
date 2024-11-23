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
                                <li class="breadcrumb-item active">Akumulasi Pemesanan User</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Akumulasi Pemesanan User</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Akumulasi Pemesanan</h4>

                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-centered nowrap w-100" id="tickets-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>Nama</th>
                                            <th>No. Whatsapp</th>
                                            <th>Jumlah Foto dibeli</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($akumulasi as $akumulasiItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>{{ $akumulasiItem->name }}</td>
                                                <td>{{ $akumulasiItem->nowa }} <a href="https://wa.me/{{ $akumulasiItem->nowa }}?text={{ urlencode('Halo, ' . $akumulasiItem->name . ' perkenalkan ini Admin dari FotoMu') }}"
                                                    target="_blank">
                                                    <i class="mdi mdi-whatsapp"></i>
                                                 </a></td>
                                                <td>{{ $akumulasiItem->jumlah_pesanan_selesai }} Foto</td>
                                                @if ($akumulasiItem->jumlah_pesanan_selesai >= 20)
                                                    <td>
                                                        <span class="badge label-table bg-primary">High-Value
                                                            Customer</span>
                                                    </td>
                                                @elseif ($akumulasiItem->jumlah_pesanan_selesai >= 5)
                                                    <td>
                                                        <span class="badge label-table bg-success">Potential
                                                            High-Value</span>
                                                    </td>
                                                @elseif ($akumulasiItem->jumlah_pesanan_selesai == 1)
                                                    <td>
                                                        <span class="badge label-table bg-danger">One-Time Buyer</span>
                                                    </td>
                                                @elseif ($akumulasiItem->jumlah_pesanan_selesai == 0)
                                                    <td>
                                                        <span class="badge label-table bg-danger">Need greating</span>
                                                    </td>
                                                @elseif ($akumulasiItem->jumlah_pesanan_selesai <= 5)
                                                    <td>
                                                        <span class="badge label-table bg-warning">Low-Value Customer</span>
                                                    </td>
                                                @endif
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
