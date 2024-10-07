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
                                            <th>Event</th>
                                            <th>Tanggal</th>
                                            <th>Lokasi</th>
                                            <th>Private</th>
                                            <th>Deskripsi</th>
                                            <th class="hidden-sm">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($eventAll as $eventItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>
                                                    {{ $eventItem->event }}
                                                </td>

                                                <td>{{ \Carbon\Carbon::parse($eventItem->tanggal)->translatedFormat('d F Y') }}
                                                </td>


                                                <td data-lokasi="{{ $eventItem->lokasi }}">
                                                </td>

                                                <td>
                                                    @if($eventItem->is_private == 1)
                                                        <span class="badge bg-success">Ya</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak</span>
                                                    @endif
                                                </td>
                                                

                                                <td>
                                                    {{ $eventItem->deskripsi }}
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i class="mdi mdi-pencil"></i></a>
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
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const locationCells = document.querySelectorAll('td[data-lokasi]');

            locationCells.forEach(async (cell) => {
                const lokasi = cell.getAttribute('data-lokasi');
                const [lat, lon] = lokasi.split(','); // Memisahkan latitude dan longitude

                const location = await reverseGeocode(lat.trim(), lon
            .trim()); // Fungsi reverse geocode dari Nominatim
                cell.textContent = location; // Update the cell content with the resolved location
            });
        });

        async function reverseGeocode(lat, lon) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data && data.address) {
                    const {
                        city,
                        county,
                        state
                    } = data.address;
                    return `${city || county || ''}, ${state || ''}`;
                } else {
                    return "Unknown Location";
                }
            } catch (error) {
                console.error('Error fetching location:', error);
                return "Error fetching location";
            }
        }
    </script>
@endpush
