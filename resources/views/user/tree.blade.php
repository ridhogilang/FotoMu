@extends('layout.user')

@push('header')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        /* Tambahkan styling untuk peta dan elemen lainnya */
        #map {
            height: 750px; /* Mengurangi height peta */
            width: 100%;
            position: relative;
            margin-bottom: 60px; /* Menambahkan margin di bawah peta untuk ruang ekstra */
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

    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlkaG9naWxhbmciLCJhIjoiY2w5OWp2NndmM2hoZTNucGN4djZ4NnQwcCJ9.z7oCuzMyT0CJY70K1q6CIQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11', // Gaya peta default
            center: [110.370529, -7.797068],
            zoom: 11
        });

        // Kontrol search yang ingin di-load bersamaan dengan map
        var searchDiv = document.createElement('div');
        searchDiv.className = 'search-box';
        searchDiv.innerHTML =
            '<input type="text" placeholder="Masukkan nama FotoTree" style="width: 300px; padding: 5px; border-radius: 5px; border: 1px solid lightgray;">';
        map.getContainer().appendChild(searchDiv);

        // Menambahkan geolokasi pengguna saat ini
        var userLocation = null;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
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
    </script>

    <script>
        // Tambahkan kontrol "Semua" dan "Kamera Live" di peta
        var buttonControlsDiv = document.createElement('div');
        buttonControlsDiv.className = 'button-controls';
        buttonControlsDiv.innerHTML = `
            <div class="button-group">
                <button class="control-button">Semua</button>
                <button class="control-button">Kamera Live</button>
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
        zoomButtonDiv.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/512/7184/7184546.png" alt="zoom to location" width="30">';
        zoomButtonDiv.addEventListener('click', function () {
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
