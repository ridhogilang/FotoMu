@extends('layout.user')

@push('header')
<link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tickets</a></li>
                            <li class="breadcrumb-item active">Ticket List</li>
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
                        <button type="button"
                            class="btn btn-sm btn-blue waves-effect waves-light float-end">
                            <i class="mdi mdi-plus-circle"></i> Add Ticket
                        </button>
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
                                            #0000{{ $pesananItem->id}}
                                        </td>

                                        <td>{{ 'Rp. ' . number_format($pesananItem->totalharga, 0, ',', '.') }}</td>


                                        <td>
                                           {{ $pesananItem->catatan }}
                                        </td>

                                        <td>
                                            <span class="badge bg-success">{{ $pesananItem->status}}</span>
                                        </td>

                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);"
                                                    class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"><i
                                                            class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>Bayar Sekarang</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="mdi mdi-check-all me-2 text-muted font-18 vertical-middle"></i>Batalkan</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>Download</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="mdi mdi-star me-2 font-18 text-muted vertical-middle"></i>Invoice</a>
                                                </div>
                                            </div>
                                        </td>
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