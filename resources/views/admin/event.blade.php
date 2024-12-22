@extends('layout.admin')

@push('header')
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map {
            width: 100%;
            height: 400px;
        }

        .hidden {
            display: none;
        }
    </style>
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fotomu</a></li>
                                <li class="breadcrumb-item active">Event</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Event</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Event Aktif</h4>

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
                                                <td>{{ $eventItem->event }}</td>
                                                <td>{{ \Carbon\Carbon::parse($eventItem->tanggal)->translatedFormat('d F Y') }}
                                                </td>
                                                <td data-lokasi="{{ $eventItem->lokasi }}"></td>
                                                <td>
                                                    @if ($eventItem->is_private == 1)
                                                        <span class="badge bg-success">Ya</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ implode(' ', array_slice(explode(' ', $eventItem->deskripsi), 0, 5)) }}
                                                    ...
                                                </td>
                                                <td class="d-flex justify-content-start align-items-center gap-1">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit-modal-{{ $eventItem->id }}"
                                                        class="btn btn-xs btn-light edit-event-btn"
                                                        data-id="{{ $eventItem->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.event-delete', $eventItem->id) }}"
                                                        method="POST" class="m-0">
                                                        @csrf
                                                        @method('put')
                                                        <button class="btn btn-xs btn-danger edit-event-btn"
                                                            id="delete-event-btn-{{ $eventItem->id }}"
                                                            data-id="{{ $eventItem->id }}">
                                                            <i class="mdi mdi-trash-can-outline"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal untuk setiap event -->
                                            <div id="edit-modal-{{ $eventItem->id }}" class="modal fade" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title">Edit Event</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.event-update', $eventItem->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="event" class="form-label">Nama
                                                                                Event</label>
                                                                            <input class="form-control" name="event"
                                                                                type="text"
                                                                                value="{{ $eventItem->event }}"
                                                                                required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="tanggal"
                                                                                class="form-label">Date</label>
                                                                            <input class="form-control" id="tanggal"
                                                                                name="tanggal" type="date"
                                                                                value="{{ \Carbon\Carbon::parse($eventItem->tanggal)->format('Y-m-d') }}">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="is_private" value="0"
                                                                                id="customradio-public-{{ $eventItem->id }}"
                                                                                {{ $eventItem->is_private == 0 ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="customradio-public-{{ $eventItem->id }}">Public</label>

                                                                            <input class="form-check-input" type="radio"
                                                                                name="is_private" value="1"
                                                                                id="customradio-private-{{ $eventItem->id }}"
                                                                                {{ $eventItem->is_private == 1 ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="customradio-private-{{ $eventItem->id }}">Private</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">

                                                                        <div class="mb-3"
                                                                            id="password-section-{{ $eventItem->id }}"
                                                                            style="{{ $eventItem->is_private == 0 ? 'display: none;' : '' }}">
                                                                            <label for="password"
                                                                                class="form-label">Password</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input type="password" id="password"
                                                                                    class="form-control"
                                                                                    placeholder="Enter your password"
                                                                                    name="password">
                                                                                <div class="input-group-text"
                                                                                    data-password="false">
                                                                                    <span class="password-eye"
                                                                                        onclick="togglePassword()"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Deskripsi</label>
                                                                            <textarea class="form-control" name="deskripsi" rows="9">{{ $eventItem->deskripsi }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Foto Cover</label>
                                                                            <div class="">
                                                                                <input type="file" name="foto_cover"
                                                                                    accept=".jpeg,.jpg,.png" />
                                                                            </div>
                                                                            <img class="mt-2"
                                                                                src="{{ Storage::url($eventItem->foto_cover) }}"
                                                                                alt="" width="160">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Map container with unique ID for each event -->
                                                                <div id="map-{{ $eventItem->id }}"
                                                                    style="height: 300px;"></div>
                                                                <input type="hidden" name="lokasi"
                                                                    id="lokasi-{{ $eventItem->id }}"
                                                                    value="{{ $eventItem->lokasi }}">
                                                                <div class="mb-2 text-center">
                                                                    <button class="btn rounded-pill btn-primary"
                                                                        type="submit">Update Event</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/pages/tickets.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.querySelectorAll('[id^="delete-event-btn-"]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Menghentikan form untuk submit langsung

                const eventId = this.getAttribute('data-id'); // Mengambil ID event
                const form = this.closest('form'); // Mendapatkan form terdekat

                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Event ini beserta foto terkaitnya akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user memilih konfirmasi, kirim form
                        form.submit();
                    }
                });
            });
        });
    </script>
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
    <script>
        // Fungsi untuk menangani perubahan radio button dan menampilkan/menyembunyikan password
        function handleRadioChange(modalId) {
            const passwordSection = document.querySelector(`#edit-modal-${modalId} #password-section-${modalId}`);
            const publicRadio = document.querySelector(`#edit-modal-${modalId} #customradio-public-${modalId}`);
            const privateRadio = document.querySelector(`#edit-modal-${modalId} #customradio-private-${modalId}`);

            if (publicRadio && privateRadio && passwordSection) {
                if (publicRadio.checked) {
                    passwordSection.style.display = 'none'; // Sembunyikan input password jika event Public
                } else if (privateRadio.checked) {
                    passwordSection.style.display = 'block'; // Tampilkan input password jika event Private
                }
            }
        }

        // Menambahkan event listener ke radio button setiap kali modal dibuka
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-event-btn');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-id');
                    handleRadioChange(modalId);

                    const publicRadio = document.querySelector(
                        `#edit-modal-${modalId} #customradio-public-${modalId}`);
                    const privateRadio = document.querySelector(
                        `#edit-modal-${modalId} #customradio-private-${modalId}`);

                    if (publicRadio && privateRadio) {
                        publicRadio.addEventListener('change', () => handleRadioChange(modalId));
                        privateRadio.addEventListener('change', () => handleRadioChange(modalId));
                    }
                });
            });
        });

        // Fungsi untuk menampilkan atau menyembunyikan password
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordEye = document.querySelector('.password-eye');

            if (passwordField && passwordEye) {
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordEye.parentElement.classList.add('show-password');
                } else {
                    passwordField.type = 'password';
                    passwordEye.parentElement.classList.remove('show-password');
                }
            }
        }
    </script>
    <script>
        let maps = {};

        function initMap(modalId, location) {
            const mapContainer = `map-${modalId}`;
            const lokasiInput = document.getElementById(`lokasi-${modalId}`);
            const coordinates = location ? location.split(',').map(coord => parseFloat(coord)) : [51.505, -0.09];

            if (maps[modalId]) {
                // Jika peta sudah ada, atur ulang posisinya
                maps[modalId].setView(coordinates, 13);
                if (maps[modalId].userMarker) {
                    maps[modalId].userMarker.setLatLng(coordinates).openPopup();
                } else {
                    maps[modalId].userMarker = L.marker(coordinates, {
                            draggable: true
                        })
                        .addTo(maps[modalId])
                        .bindPopup(`Location: ${coordinates[0]}, ${coordinates[1]}`).openPopup();
                }
            } else {
                // Jika peta belum ada, buat peta baru
                maps[modalId] = L.map(mapContainer).setView(coordinates, 13);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(maps[modalId]);

                maps[modalId].userMarker = L.marker(coordinates, {
                        draggable: true
                    })
                    .addTo(maps[modalId])
                    .bindPopup(`Location: ${coordinates[0]}, ${coordinates[1]}`).openPopup();
            }

            // Update lokasi saat marker dipindahkan
            maps[modalId].userMarker.on('dragend', function() {
                const newLatLng = maps[modalId].userMarker.getLatLng();
                lokasiInput.value = `${newLatLng.lat},${newLatLng.lng}`;
            });

            // Tambahkan event listener untuk klik pada peta
            maps[modalId].on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                maps[modalId].userMarker.setLatLng(e.latlng).openPopup();
                lokasiInput.value = `${lat},${lng}`;
            });
        }

        document.querySelectorAll('.edit-event-btn').forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-id');
                const lokasiValue = document.getElementById(`lokasi-${modalId}`).value;

                initMap(modalId, lokasiValue);
            });
        });
    </script>
@endpush
