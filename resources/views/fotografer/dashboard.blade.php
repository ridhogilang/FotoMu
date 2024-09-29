@extends('layout.foto')

@push('header')
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .btn {
            white-space: nowrap;
            /* Pastikan konten di dalam tombol tidak dipisahkan menjadi dua baris */
        }
    </style>
@endpush

@section('main')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form action="{{ route('foto.dashboardsearch') }}" method="GET"
                                class="d-flex align-items-center mb-3">
                                @csrf
                                @php
                                    $tanggalRequest = request('tanggal');
                                    if ($tanggalRequest) {
                                        // Memisahkan rentang tanggal berdasarkan " to "
                                        $dates = explode(' to ', $tanggalRequest);

                                        // Jika ada dua tanggal (rentang)
                                        if (count($dates) == 2) {
                                            $startDate = \Carbon\Carbon::parse($dates[0])->format('F j, y'); // Format ke 'MMMM D, YY'
                                            $endDate = \Carbon\Carbon::parse($dates[1])->format('F j, y'); // Format ke 'MMMM D, YY'
                                            $formattedDate = $startDate . ' to ' . $endDate;
                                        } else {
                                            // Jika hanya satu tanggal
                                            $formattedDate = \Carbon\Carbon::parse($dates[0])->format('F j, y');
                                        }
                                    } else {
                                        $formattedDate = '';
                                    }
                                @endphp

                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border" name="tanggal" value="{{ $formattedDate }}" id="dash-daterange"
                                         placeholder="Pilih Tanggal">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                        <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>

                                {{-- {{ dd($formattedDate) }} --}}


                                <button type="submit" class="btn btn-blue btn-sm ms-2 d-flex align-items-center">
                                    <i class="mdi mdi-filter-variant me-1"></i> Filter
                                </button>

                                <a href="{{ route('foto.dashboard') }}"
                                    class="btn btn-blue btn-sm ms-2 d-flex align-items-center">
                                    <i class="mdi mdi-find-replace me-1"></i> Hapus Filter
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
                                            <th>Tanggal</th>
                                            <th>ID Pesanan (Invoice)</th>
                                            <th>Event</th>
                                            <th>Pendapatan (Setelah Pajak)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailPesanan as $pesanan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pesanan['created_at'])->format('j M y') }}
                                                </td>
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
                                <a href="{{ route('foto.pembayaran') }}"
                                    class="btn btn-primary btn-sm waves-effect waves-light">Tarik Saldo</a>
                            </div>

                            <h4 class="header-title mb-3">Penarikan Saldo</h4>

                            <div class="table-responsive">
                                <table id="basic-datatable" class="table table-centered table-nowrap table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>No. </th>
                                            <th>Rekening</th>
                                            <th>Jumlah</th>
                                            <th>Saldo</th>
                                            <th>Status</th>
                                            <th>Pengajuan</th>
                                            <th style="width: 82px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawal as $penarikanItem)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $penarikanItem->rekening->nama }} -
                                                    {{ $penarikanItem->rekening->nama_bank }}</td>
                                                <td>Rp.
                                                    {{ number_format($penarikanItem->jumlah, 0, ',', '.') }}
                                                </td>
                                                <td>Rp.
                                                    {{ number_format($penarikanItem->saldo, 0, ',', '.') }}
                                                </td>
                                                @switch($penarikanItem->status)
                                                    @case('Pending')
                                                        <td><span
                                                                class="badge label-table bg-success">{{ $penarikanItem->status }}</span>
                                                        </td>
                                                    @break

                                                    @case('Approved')
                                                        <td><span
                                                                class="badge label-table bg-secondary text-light">{{ $penarikanItem->status }}</span>
                                                        </td>
                                                    @break

                                                    @default
                                                        <td><span
                                                                class="badge label-table bg-danger">{{ $penarikanItem->status }}</span>
                                                        </td>
                                                @endswitch
                                                <td>{{ \Carbon\Carbon::parse($penarikanItem->requested_at)->format('d, M y') }}
                                                </td>
                                                <td class="justify-content-center align-items-center">
                                                    @if ($penarikanItem->status === 'Pending')
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            onclick="confirmDelete({{ $penarikanItem->id }})">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
   <script>
    $(document).ready(function() {
        // Ambil tanggal dari request dan format
        var initialDate = "{{ request('tanggal') }}"; // Ambil dari request

        // Hanya jika ada tanggal dari request, disable interupsi dari skrip lain
        if (initialDate) {
            // Pisahkan jika ada rentang tanggal dengan " to "
            var dates = initialDate.split(' to ');

            if (dates.length === 2) {
                // Jika ada dua tanggal (rentang)
                var startDate = moment(dates[0], 'YYYY-MM-DD').format('MMMM D, YY');
                var endDate = moment(dates[1], 'YYYY-MM-DD').format('MMMM D, YY');

                // Set tanggal di daterangepicker tanpa memperbarui input otomatis
                $('#dash-daterange').daterangepicker({
                    startDate: moment(dates[0]),
                    endDate: moment(dates[1]),
                    locale: {
                        format: 'MMMM D, YY' // Pastikan format sesuai
                    },
                    autoUpdateInput: false // Jangan perbarui input otomatis
                });

                // Set input field manual dengan tanggal dari request
                $('#dash-daterange').val(startDate + ' to ' + endDate);
            } else {
                // Jika hanya satu tanggal
                var singleDate = moment(dates[0], 'YYYY-MM-DD').format('MMMM D, YY');

                // Set satu tanggal di daterangepicker
                $('#dash-daterange').daterangepicker({
                    startDate: moment(dates[0]),
                    endDate: moment(dates[0]),
                    locale: {
                        format: 'MMMM D, YY' // Format yang diinginkan
                    },
                    autoUpdateInput: false // Jangan perbarui input otomatis
                });

                // Tampilkan di input dengan format yang diinginkan
                $('#dash-daterange').val(singleDate);
            }
        } else {
            // Jika tidak ada request, set up daterangepicker seperti biasa
            $('#dash-daterange').daterangepicker({
                locale: {
                    format: 'MMMM D, YY', // Format yang diinginkan
                },
                autoUpdateInput: false, // Jangan perbarui input otomatis
                showDropdowns: true, // Menambahkan dropdown untuk memilih tahun dan bulan
            });
        }

        // Event saat user memilih rentang tanggal
        $('#dash-daterange').on('apply.daterangepicker', function(ev, picker) {
            if (picker.startDate.format('MMMM D, YY') === picker.endDate.format('MMMM D, YY')) {
                // Jika tanggal awal dan akhir sama, tampilkan hanya satu tanggal
                $(this).val(picker.startDate.format('MMMM D, YY'));
            } else {
                // Jika ada rentang, tampilkan "startDate to endDate"
                $(this).val(picker.startDate.format('MMMM D, YY') + ' to ' + picker.endDate.format(
                    'MMMM D, YY'));
            }
        });

        // Event saat user membatalkan pilihan tanggal
        $('#dash-daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val(''); // Kosongkan input jika user batal
        });
    });
</script>

@endpush
