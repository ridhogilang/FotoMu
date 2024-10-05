@extends('layout.foto')

@push('header')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css'
        rel='stylesheet' />
    <style>
        /* Tambahkan styling untuk peta dan elemen lainnya */
        #map {
            height: 750px;
            /* Mengurangi height peta */
            width: 100%;
            position: relative;
            margin-bottom: 60px;
            /* Menambahkan margin di bawah peta untuk ruang ekstra */
        }

        .search-box {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
        }

        .button-controls {
            position: absolute;
            bottom: 80px;
            left: 20px;
            z-index: 1000;
        }

        .plant-button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .control-button {
            background-color: #6a1b9a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        /* Styling untuk lokasi saat ini */
        .current-location-marker {
            width: 15px;
            height: 15px;
            background-color: purple;
            border-radius: 50%;
            border: 2px solid white;
        }

        .current-location-radius {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(128, 0, 128, 0.2);
        }

        /* Styling untuk tombol zoom ke lokasi saya */
        .zoom-location-button {
            position: absolute;
            bottom: 90px;
            right: 30px;
            z-index: 1001;
            background-color: white;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }
    </style>
@endpush

@section('main')
    <div id="map"></div>
@endsection

@push('footer')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js'></script>

    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlkaG9naWxhbmciLCJhIjoiY2w5OWp2NndmM2hoZTNucGN4djZ4NnQwcCJ9.z7oCuzMyT0CJY70K1q6CIQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11', // Gaya peta default
            center: [110.370529, -7.797068], // Koordinat awal
            zoom: 11
        });

        // Menambahkan kontrol search di map
        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            placeholder: 'Cari daerah atau tempat',
            bbox: [110.0, -8.0, 111.0, -7.0], // Batasi area pencarian
            proximity: {
                longitude: 110.370529,
                latitude: -7.797068
            }
        });

        map.addControl(geocoder, 'top-left');

        // Menambahkan geolokasi pengguna saat ini
        var userLocation = null;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                userLocation = [position.coords.longitude, position.coords.latitude];

                // Pusatkan peta ke lokasi pengguna
                map.setCenter(userLocation);

                // Tambahkan marker untuk lokasi pengguna
                var markerDiv = document.createElement('div');
                markerDiv.className = 'current-location-marker';

                // Tambahkan lingkaran radius untuk lokasi
                var radiusDiv = document.createElement('div');
                radiusDiv.className = 'current-location-radius';

                // Tambahkan elemen marker dan radius ke peta
                new mapboxgl.Marker({
                        element: radiusDiv
                    })
                    .setLngLat(userLocation)
                    .addTo(map);

                new mapboxgl.Marker({
                        element: markerDiv
                    })
                    .setLngLat(userLocation)
                    .addTo(map);
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }

        // Fungsi untuk menambahkan marker dengan teks di atasnya dan event listener
        function addMarkerToMap(event) {
            // Buat elemen HTML untuk marker dan teks
            var el = document.createElement('div');
            el.className = 'marker';

            // Isi HTML: teks judul event dan gambar marker
            el.innerHTML = `
                <div style="text-align: center; color: red; font-weight: bold; margin-bottom: 5px;">${event.event}</div>
                <div><img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" style="width: 30px; height: 30px;"></div>
            `;

            // Tambahkan marker ke peta
            var marker = new mapboxgl.Marker(el)
                .setLngLat([event.longitude, event.latitude])
                .addTo(map);

            // Tampilkan popup saat mouse masuk
            var popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
                })
                .setHTML(`
                    <div style="font-size: 12px;">
                        <h4>${event.event}</h4>
                        <p>${event.deskripsi}</p>
                        <p><strong>Tanggal:</strong> ${event.tanggal}</p>
                    </div>
                `);

            marker.getElement().addEventListener('mouseenter', () => {
                popup.setLngLat([event.longitude, event.latitude]).addTo(map);
            });

            // Sembunyikan popup saat mouse keluar
            marker.getElement().addEventListener('mouseleave', () => {
                popup.remove();
            });

            // Event listener untuk menampilkan modal saat marker diklik
            marker.getElement().addEventListener('click', () => {
                // Buat modal dinamis untuk detail event
                var modalHtml = `
                    <div class="modal fade" id="eventModal-${event.id}" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">${event.event}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Lokasi:</strong> ${event.lokasi}</p>
                                    <p><strong>Tanggal:</strong> ${event.tanggal}</p>
                                    <p>${event.deskripsi}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Hapus modal sebelumnya jika ada
                $(`#eventModal-${event.id}`).remove();

                // Tambahkan modal ke body
                $('body').append(modalHtml);

                // Tampilkan modal
                $(`#eventModal-${event.id}`).modal('show');
            });
        }

        // Memuat data event dari backend
        fetch('/pelanggan/events')
            .then(response => response.json())
            .then(events => {
                events.forEach(event => {
                    // Koordinat lokasi diambil dari string 'lokasi'
                    var coords = event.lokasi.split(',');
                    event.longitude = parseFloat(coords[1]);
                    event.latitude = parseFloat(coords[0]);

                    // Tambahkan marker dengan teks di atasnya ke peta
                    addMarkerToMap(event);
                });
            })
            .catch(error => {
                console.error('Error fetching events:', error);
            });
    </script>



    <script>
        // Tambahkan kontrol "Semua" dan "Kamera Live" di peta
        var buttonControlsDiv = document.createElement('div');
        buttonControlsDiv.className = 'button-controls';
        buttonControlsDiv.innerHTML = `
           <div class="btn-group mb-2">
                                                    <button type="button" class="btn btn-light">Left</button>
                                                    <button type="button" class="btn btn-light">Middle</button>
                                                    <button type="button" class="btn btn-light">Right</button>
                                                </div>
        `;
        map.getContainer().appendChild(buttonControlsDiv); // Menggunakan map.getContainer() agar sesuai dengan elemen peta

        // Tambahkan kontrol "Tanam FotoTree" di peta
        var plantButtonDiv = document.createElement('div');
        plantButtonDiv.className = 'plant-button';
        plantButtonDiv.innerHTML =
            '<button style="background-color: purple; color: white; padding: 10px; border: none; border-radius: 5px;">+ Tanam FotoTree</button>';
        map.getContainer().appendChild(plantButtonDiv); // Menggunakan map.getContainer() agar sesuai dengan elemen peta
    </script>

    <script>
        // Tambahkan tombol zoom ke lokasi saya di atas tombol "Tanam FotoTree"
        var zoomButtonDiv = document.createElement('div');
        zoomButtonDiv.className = 'zoom-location-button';
        zoomButtonDiv.innerHTML =
            '<img src="https://cdn-icons-png.flaticon.com/512/7184/7184546.png" alt="zoom to location" width="30">';
        zoomButtonDiv.addEventListener('click', function() {
            if (userLocation) {
                // Zoom ke lokasi pengguna dan pusatkan peta
                map.flyTo({
                    center: userLocation,
                    zoom: 15 // Zoom lebih dekat ke lokasi pengguna
                });
            } else {
                alert("Lokasi pengguna tidak ditemukan.");
            }
        });
        map.getContainer().appendChild(zoomButtonDiv);
    </script>
@endpush