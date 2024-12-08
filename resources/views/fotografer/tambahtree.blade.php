@extends('layout.foto')

@push('header')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        .harga-details {
            background-color: #f8f9fa;
        }

        .detail-harga {
            font-size: 14px;
            color: #6c757d;
        }

        .text-primary {
            color: #6f42c1;
        }

        .text-muted {
            color: #6c757d;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Profil</a>
                                </li>
                                <li class="breadcrumb-item active">Tambah Tree</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tambah Tree</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Foto</h5>

                            <form action="{{ route('event.store') }}" class="px-3" method="POST"
                                enctype="multipart/form-data" id="login-modal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="event" class="form-label">Nama Event</label>
                                            <input class="form-control" name="event" type="text" required
                                                placeholder="Masukkan nama acara/event">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Date</label>
                                            <input class="form-control" id="tanggal" name="tanggal" type="date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                value="false" id="customradio-public" checked>
                                            <label class="form-check-label" for="customradio-public"
                                                style="margin-right: 10px;">Public</label>
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                value="true" id="customradio-private">
                                            <label class="form-check-label" for="customradio-private"
                                                style="margin-right: 10px;">Private</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="mb-3" id="password-section">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control"
                                                    placeholder="Enter your password" name="password">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye" onclick="togglePassword()"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" rows="9" placeholder="Deskripsikan eventmu"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Foto Cover</label>
                                            <div class="">
                                                <input type="file" name="foto_cover" data-plugins="dropify"
                                                    accept=".jpeg,.jpg,.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="map"></div>
                                <input type="hidden" name="lokasi" id="lokasi">

                                <br>
                                <div class="mb-2 text-center">
                                    <button class="btn rounded-pill btn-primary" type="submit">Tambah
                                        Event</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('js/pages/add-product.init.js') }}"></script>
    <script src="{{ asset('js/pages/authentication.init.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Function to handle the radio button change event
        function handleRadioChange() {
            const passwordSection = document.getElementById('password-section');
            const publicRadio = document.getElementById('customradio-public');
            const privateRadio = document.getElementById('customradio-private');

            if (publicRadio.checked) {
                passwordSection.classList.add('hidden');
            } else if (privateRadio.checked) {
                passwordSection.classList.remove('hidden');
            }
        }

        // Attach event listeners to radio buttons
        document.getElementById('customradio-public').addEventListener('change', handleRadioChange);
        document.getElementById('customradio-private').addEventListener('change', handleRadioChange);

        // Initial check when the page loads
        handleRadioChange();

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordEye = document.querySelector('.password-eye');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordEye.parentElement.classList.add('show-password');
            } else {
                passwordField.type = 'password';
                passwordEye.parentElement.classList.remove('show-password');
            }
        }
    </script>
    {{-- <script>
        let map;
        let userMarker;

        function initMap() {
            map = L.map('map').setView([51.505, -0.09], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            locateUser();
            addSearchControl();

            // Add click event listener to the map
            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                if (userMarker) {
                    userMarker.setLatLng(e.latlng).openPopup();
                } else {
                    userMarker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map)
                        .bindPopup(`You are here: ${lat}, ${lng}`).openPopup();
                }
                document.getElementById('lokasi').value = `${lat},${lng}`;
            });
        }

        function locateUser() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    userMarker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map)
                        .bindPopup(`You are here: ${lat}, ${lng}`).openPopup();
                    map.setView([lat, lng], 13);

                    document.getElementById('lokasi').value = `${lat},${lng}`;

                    userMarker.on('dragend', function() {
                        const newLatLng = userMarker.getLatLng();
                        document.getElementById('lokasi').value = `${newLatLng.lat},${newLatLng.lng}`;
                    });
                }, () => {
                    alert('Geolocation failed or permission denied.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        function addSearchControl() {
            if (L.Control.Geocoder) {
                L.Control.geocoder({
                    query: '',
                    placeholder: 'Search here...',
                    defaultMarkGeocode: false
                }).on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    map.setView(latlng, 13);
                }).addTo(map);
            } else {
                alert('Geocoder plugin is not loaded.');
            }
        }

        document.getElementById('login-modal').addEventListener('shown.bs.modal', function() {
            initMap();
        });
    </script> --}}
    <script>
        let map;
        let userMarker;

        function initMap() {
            // Initialize map and set default view
            map = L.map('map').setView([51.505, -0.09], 13);

            // Add tile layer from OpenStreetMap
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            locateUser(); // Locate user and add a marker
            addSearchControl(); // Add search functionality to the map

            // Add click event listener to the map
            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                if (userMarker) {
                    userMarker.setLatLng(e.latlng).openPopup();
                } else {
                    userMarker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map)
                        .bindPopup(`You are here: ${lat}, ${lng}`).openPopup();
                }
                // Update hidden input with location
                document.getElementById('lokasi').value = `${lat},${lng}`;
            });
        }

        function locateUser() {
            // Use browser's geolocation API
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Add a draggable marker at user's location
                    userMarker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map)
                        .bindPopup(`You are here: ${lat}, ${lng}`).openPopup();
                    map.setView([lat, lng], 13);

                    // Update hidden input with user's location
                    document.getElementById('lokasi').value = `${lat},${lng}`;

                    // Update hidden input when marker is dragged
                    userMarker.on('dragend', function() {
                        const newLatLng = userMarker.getLatLng();
                        document.getElementById('lokasi').value = `${newLatLng.lat},${newLatLng.lng}`;
                    });
                }, () => {
                    alert('Geolocation failed or permission denied.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        function addSearchControl() {
            // Add geocoder control to the map
            if (L.Control.Geocoder) {
                L.Control.geocoder({
                    query: '',
                    placeholder: 'Search here...',
                    defaultMarkGeocode: false
                }).on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    map.setView(latlng, 13);
                }).addTo(map);
            } else {
                alert('Geocoder plugin is not loaded.');
            }
        }

        // Initialize map when the document is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>

    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#myAwesomeDropzone", {
            url: "/fotografer/foto/upload", // Endpoint untuk upload sementara
            previewsContainer: "#file-previews",
            previewTemplate: document.querySelector('#uploadPreviewTemplate').innerHTML,
            autoProcessQueue: true, // Mengunggah file ke lokasi sementara saat ditambahkan
            parallelUploads: 10,
            maxFiles: 500,
            maxFilesize: 10,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            init: function() {
                var submitButton = document.querySelector("#save-button");
                var pagination = document.querySelector("#pagination");
                var files = [];
                var itemsPerPage = 7; // Number of items per page
                var tempFiles = []; // Menyimpan path file sementara

                // Menambahkan file ke daftar
                this.on("addedfile", function(file) {
                    files.push(file);
                    updatePagination();
                });

                // Menampilkan progress upload
                this.on("uploadprogress", function(file, progress) {
                    file.previewElement.querySelector("[data-dz-uploadprogress]").style.width =
                        progress + "%";
                    file.previewElement.querySelector("[data-dz-uploadprogress]").setAttribute(
                        "aria-valuenow", progress);
                });

                // Mengelola kesuksesan upload
                this.on("success", function(file, response) {
                    var progressBar = file.previewElement.querySelector("[data-dz-uploadprogress]");
                    var successMessage = file.previewElement.querySelector(".dz-success-message");
                    progressBar.style.display = "none";
                    successMessage.classList.remove("d-none");

                    // Tambahkan path file sementara dan ukuran file
                    tempFiles.push({
                        tempPath: response.tempPath,
                        size: file.size // Mengirim ukuran file
                    });
                });

                this.on("error", function(file, response) {
                    console.error("Error uploading file:", response);
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengunggah file.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });

                this.on("removedfile", function(file) {
                    files = files.filter(f => f !== file);
                    updatePagination();
                });

                // Aktifkan tombol Save setelah semua file berhasil diunggah
                this.on("queuecomplete", function() {
                    if (tempFiles.length > 0) {
                        submitButton.disabled = false; // Aktifkan tombol Save
                    }
                });

                // Fungsi untuk memperbarui pagination
                function updatePagination() {
                    pagination.innerHTML = "";
                    var pageCount = Math.ceil(files.length / itemsPerPage);

                    // Tambahkan tombol Previous
                    var previousLi = document.createElement("li");
                    previousLi.classList.add("page-item");
                    var previousA = document.createElement("a");
                    previousA.classList.add("page-link");
                    previousA.href = "javascript: void(0);";
                    previousA.setAttribute("aria-label", "Previous");
                    previousA.innerHTML = "<span aria-hidden='true'>&laquo;</span>";
                    previousA.addEventListener("click", function() {
                        var currentPage = parseInt(document.querySelector(
                            ".pagination .active .page-link").innerText);
                        if (currentPage > 1) {
                            showPage(currentPage - 2);
                        }
                    });
                    previousLi.appendChild(previousA);
                    pagination.appendChild(previousLi);

                    // Tambahkan halaman
                    for (var i = 0; i < pageCount; i++) {
                        var li = document.createElement("li");
                        li.classList.add("page-item");
                        if (i === 0) li.classList.add("active");
                        var a = document.createElement("a");
                        a.classList.add("page-link");
                        a.href = "javascript: void(0);";
                        a.innerText = i + 1;
                        a.addEventListener("click", (function(page) {
                            return function(event) {
                                event.preventDefault();
                                showPage(page);
                            };
                        })(i));
                        li.appendChild(a);
                        pagination.appendChild(li);
                    }

                    // Tambahkan tombol Next
                    var nextLi = document.createElement("li");
                    nextLi.classList.add("page-item");
                    var nextA = document.createElement("a");
                    nextA.classList.add("page-link");
                    nextA.href = "javascript: void(0);";
                    nextA.setAttribute("aria-label", "Next");
                    nextA.innerHTML = "<span aria-hidden='true'>&raquo;</span>";
                    nextA.addEventListener("click", function() {
                        var currentPage = parseInt(document.querySelector(
                            ".pagination .active .page-link").innerText);
                        if (currentPage < pageCount) {
                            showPage(currentPage);
                        }
                    });
                    nextLi.appendChild(nextA);
                    pagination.appendChild(nextLi);

                    showPage(0);
                }

                // Fungsi untuk menampilkan halaman tertentu
                function showPage(page) {
                    var start = page * itemsPerPage;
                    var end = start + itemsPerPage;

                    Array.from(document.querySelector("#file-previews").children).forEach(function(child,
                        index) {
                        if (index >= start && index < end) {
                            child.style.display = "";
                        } else {
                            child.style.display = "none";
                        }
                    });

                    // Set active class untuk pagination
                    document.querySelectorAll(".pagination .page-item").forEach(function(item) {
                        item.classList.remove("active");
                    });
                    document.querySelectorAll(".pagination .page-item")[page + 1].classList.add("active");
                }

                // Fungsi untuk menangani klik tombol Save
                submitButton.addEventListener("click", function(event) {
                    event.preventDefault();

                    if (tempFiles.length === 0) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Tidak ada file yang diunggah.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    submitForm(); // Kirim data dan path file ke server
                });

                // Fungsi untuk submit form
                function submitForm() {
                    var formData = {
                        harga: document.getElementById('harga-hidden').value,
                        event_id: document.getElementById('event').value,
                        deskripsi: document.querySelector('[name="deskripsi"]').value,
                        file_paths: tempFiles.map(file => file.tempPath), // Hanya kirim path file
                        file_sizes: tempFiles.map(file => file.size) // Kirim ukuran file
                    };

                    console.log('Form Data:', formData);

                    fetch("/fotografer/foto/store", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(formData)
                    }).then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.errors ? Object.values(errorData
                                    .errors).join(' ') : errorData.error);
                            });
                        }
                        return response.json();
                    }).then(data => {
                        console.log("Success:", data);

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data telah berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('foto.profil') }}";
                            }
                        });
                    }).catch(error => {
                        console.error("Error:", error);

                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data: ' + error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            }
        });

        document.getElementById('harga').addEventListener('input', function() {
            let nilaiAsli = this.value.replace(/\D/g, '');
            let nilaiFormatted = formatRupiah(nilaiAsli);

            this.value = nilaiFormatted;
            document.getElementById('harga-hidden').value = nilaiAsli;

            updateDetailHarga(nilaiAsli);
        });

        function formatRupiah(angka, prefix = 'Rp. ') {
            let numberString = angka.replace(/[^,\d]/g, '').toString(),
                split = numberString.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        function updateDetailHarga(nilaiAsli) {
            const harga = parseFloat(nilaiAsli) || 0;

            const netKreator = harga * 0.90;
            const biayaFotoYu = harga * 0.10;
            const biayaHost = harga * 0.00;
            const hargaDasar = harga * 0.90;
            const biayaLayanan = harga * 0.00;
            const hargaJual = harga;

            document.getElementById('net-kreator').textContent = formatRupiah(netKreator.toFixed(0));
            document.getElementById('biaya-fotoyu').textContent = formatRupiah(biayaFotoYu.toFixed(0));
            document.getElementById('biaya-host').textContent = formatRupiah(biayaHost.toFixed(0));
            document.getElementById('harga-dasar').textContent = formatRupiah(hargaDasar.toFixed(0));
            document.getElementById('biaya-layanan').textContent = formatRupiah(biayaLayanan.toFixed(0));
            document.getElementById('harga-jual').textContent = formatRupiah(hargaJual.toFixed(0));
        }
    </script>
    <script>
        document.getElementById('cancel-button').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data Anda tidak akan tersimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tinggalkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('foto.profil') }}";
                }
            });
        });
    </script>
@endpush
