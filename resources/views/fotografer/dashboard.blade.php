@extends('layout.foto')

@push('header')
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('main')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                        <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                    <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                        <i class="fe-heart font-22 avatar-title text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span
                                                data-plugin="counterup">{{ $jumlahFotoTerjual }}</span> Foto</h3>
                                        <p class="text-muted mb-1 text-truncate">Terjual</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                        <i class="fe-shopping-cart font-22 avatar-title text-success"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span>Rp
                                                {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                        </h3>
                                        <p class="text-muted mb-1 text-truncate">Penghasilan</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                        <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $eventCount }}</span>
                                            Event</h3>
                                        <p class="text-muted mb-1 text-truncate">Kontribusi Event</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                        <i class="fe-eye font-22 avatar-title text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span
                                                data-plugin="counterup">{{ $jumlahFotoDiunggah }}</span> Foto</h3>
                                        <p class="text-muted mb-1 text-truncate">Kontribusi</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>

                            <h4 class="header-title mb-0">Total Revenue</h4>

                            <div class="widget-chart text-center" dir="ltr">

                                <div id="total-revenue" class="mt-0" data-colors="#f1556c"></div>

                                <h5 class="text-muted mt-0">Total sales made today</h5>
                                <h2>Rp {{ number_format($totalPendapatanHarian, 0, ',', '.') }}</h2><br>

                                <p class="text-muted w-75 mx-auto sp-line-2">Traditional heading elements are
                                    designed to work best in the meat of your page content.</p><br>

                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col-->

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body pb-2">
                            <div class="float-end d-none d-md-inline-block">
                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-xs btn-light">Today</button>
                                    <button type="button" class="btn btn-xs btn-light">Weekly</button>
                                    <button type="button" class="btn btn-xs btn-secondary">Monthly</button>
                                </div>
                            </div>

                            <h4 class="header-title mb-3">Sales Analytics</h4>

                            <div dir="ltr">
                                <div id="sales-analytics1" class="mt-4" data-colors="#1abc9c,#4a81d4">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col-->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>

                            <h4 class="header-title mb-3">Top 5 Users Balances</h4>

                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr class="table-light">
                                            <th>No. </th>
                                            <th>ID Pesanan (Invoice)</th>
                                            <th>Event</th>
                                            <th>Pendapatan (Setelah Pajak)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailPesanan as $pesanan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>#0000{{ $pesanan['id_pesanan'] }}</td>
                                            <td>{{ $pesanan['event'] }}</td>
                                            <td>Rp {{ number_format($pesanan['pendapatan'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>

                            <h4 class="header-title mb-3">Revenue History</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Marketplaces</th>
                                            <th>Date</th>
                                            <th>Payouts</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">Themes Market</h5>
                                            </td>

                                            <td>
                                                Oct 15, 2018
                                            </td>

                                            <td>
                                                $5848.68
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-warning text-warning">Upcoming</span>
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                        class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">Freelance</h5>
                                            </td>

                                            <td>
                                                Oct 12, 2018
                                            </td>

                                            <td>
                                                $1247.25
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-success text-success">Paid</span>
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                        class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">Share Holding</h5>
                                            </td>

                                            <td>
                                                Oct 10, 2018
                                            </td>

                                            <td>
                                                $815.89
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-success text-success">Paid</span>
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                        class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">Envato's Affiliates</h5>
                                            </td>

                                            <td>
                                                Oct 03, 2018
                                            </td>

                                            <td>
                                                $248.75
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-danger text-danger">Overdue</span>
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                        class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">Marketing Revenue</h5>
                                            </td>

                                            <td>
                                                Sep 21, 2018
                                            </td>

                                            <td>
                                                $978.21
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-warning text-warning">Upcoming</span>
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                        class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">Advertise Revenue</h5>
                                            </td>

                                            <td>
                                                Sep 15, 2018
                                            </td>

                                            <td>
                                                $358.10
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-success text-success">Paid</span>
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                        class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('libs/selectize/js/standalone/selectize.min.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Script is running");

            var days = {!! json_encode($days) !!};
            var revenues = {!! json_encode($revenueData) !!}; // Convert to numbers
            var sales = {!! json_encode($salesData) !!}; // Convert to numbers

            console.log("Revenues after conversion:", revenues);

            var chartElement = document.querySelector("#sales-analytics1");
            if (!chartElement) {
                console.error("Element #sales-analytics tidak ditemukan di halaman.");
                return;
            }

            var options = {
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: false
                },
                stroke: {
                    width: [0, 2],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                colors: ['#1abc9c', '#4a81d4'],
                series: [{
                    name: 'Revenue',
                    type: 'column',
                    data: revenues,
                }, {
                    name: 'Sales',
                    type: 'line',
                    data: sales,
                }],
                xaxis: {
                    categories: days,
                },
                yaxis: [{
                    title: {
                        text: 'Revenue'
                    },
                    labels: {
                        formatter: function(val) {
                            return "Rp " + val.toLocaleString();
                        }
                    }
                }, {
                    opposite: true,
                    title: {
                        text: 'Sales'
                    }
                }],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(val, {
                            seriesIndex
                        }) {
                            return seriesIndex === 0 ?
                                "Rp " + val.toLocaleString() :
                                val + " transactions";
                        }
                    }
                }
            };

            var chart = new ApexCharts(chartElement, options);
            chart.render().catch(err => {
                console.error("ApexCharts render error:", err);
            });
        });
    </script>
@endpush
