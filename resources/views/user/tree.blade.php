@extends('layout.user')

@push('header')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css'
        rel='stylesheet' />
    <style>
        #map {
            height: 750px;
            width: 100%;
            position: relative;
            margin-bottom: 60px;
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

        .zoom-location-button {
            position: absolute;
            bottom: 40px;
            right: 30px;
            z-index: 1001;
            background-color: white;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }

        .mapboxgl-popup {
            padding-bottom: 50px;
        }

        .mapboxgl-popup-close-button {
            display: none;
        }

        .mapboxgl-popup-content {
            font:
                400 15px/22px 'Source Sans Pro',
                'Helvetica Neue',
                sans-serif;
            padding: 0;
            /* width: 180px; */
        }

        .mapboxgl-popup-content h4 {
            background: #91c949;
            color: #fff;
            margin: 0;
            padding: 10px;
            border-radius: 3px 3px 0 0;
            font-weight: 700;
            margin-top: -15px;
        }

        .mapboxgl-popup-content h5 {
            margin: 0;
            padding: 10px;
            font-weight: 400;
        }

        .mapboxgl-popup-content div {
            padding: 10px;
        }

        .mapboxgl-popup-anchor-top>.mapboxgl-popup-content {
            margin-top: 15px;
        }

        .mapboxgl-popup-anchor-top>.mapboxgl-popup-tip {
            border-bottom-color: #91c949;
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
        // Data events dari Laravel (termasuk ID yang sudah terenkripsi)
        const events = @json($events);

        // Memuat peta Mapbox
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlkaG9naWxhbmciLCJhIjoiY2w5OWp2NndmM2hoZTNucGN4djZ4NnQwcCJ9.z7oCuzMyT0CJY70K1q6CIQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [110.370529, -7.797068],
            zoom: 11
        });

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

        var currentPopup = null;
        var currentMarker = null;

        // Fungsi untuk menambahkan marker ke peta
        function addMarkerToMap(event) {
            var el = document.createElement('div');
            el.className = 'marker';

            el.innerHTML = `
                <div style="text-align: center; color: #800080; font-weight: bold; margin-bottom: 5px;">${event.event}</div>
                <div><img src="../foto/marker.png" style="width: 30px; height: 30px;"></div>
            `;

            var marker = new mapboxgl.Marker(el, {
                    anchor: 'bottom'
                })
                .setLngLat([event.longitude, event.latitude])
                .addTo(map);

            // URL dengan ID terenkripsi
            const baseUrl = "{{ url('/') }}";
            const url = baseUrl + '/pelanggan/foto/event/' + event.id; // ID sudah terenkripsi

            const eventButtonText = event.is_private ? 'Event ini private' : 'Lihat Event';
            const buttonDisabledClass = event.is_private ? 'disabled' : '';

            var popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
                })
                .setHTML(`
                <div style="font-size: 12px;">
                <button class="close-popup" style="position: absolute; top: 5px; right: 1px; margin-top: 6px; margin-bottom: 40px; margin-right: 6px; border: none; background: none; font-size: 16px; font-weight: bold; cursor: pointer;">&times;</button><br>
                    <h4 style="margin-bottom: 10px;">${event.event}</h4>
                    <p>${event.deskripsi}</p>
                    <p><strong>Tanggal:</strong> ${event.tanggal}</p>
                   <a href="${url}" class="btn btn-primary ${buttonDisabledClass}">
            ${eventButtonText}
        </a>
                </div>
            `);

            marker.getElement().addEventListener('click', () => {
                if (currentPopup && currentMarker !== marker) {
                    currentPopup.remove();
                    popup.setLngLat([event.longitude, event.latitude]).addTo(map);
                    currentPopup = popup;
                    currentMarker = marker;
                } else if (!currentPopup) {
                    popup.setLngLat([event.longitude, event.latitude]).addTo(map);
                    currentPopup = popup;
                    currentMarker = marker;
                }

                const closeButton = popup.getElement().querySelector('.close-popup');
                closeButton.addEventListener('click', () => {
                    popup.remove();
                    currentPopup = null;
                    currentMarker = null;
                });
            });
        }

        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });

        map.addControl(new mapboxgl.NavigationControl());
        map.addControl(geocoder, 'top-left');

        // Memuat data event yang sudah terenkripsi
        events.forEach(event => {
            var coords = event.lokasi.split(',');
            event.longitude = parseFloat(coords[1]);
            event.latitude = parseFloat(coords[0]);
            addMarkerToMap(event);
        });
    </script>
    <script>
        // Tambahkan tombol zoom ke lokasi saya di atas tombol "Tanam FotoTree"
        var zoomButtonDiv = document.createElement('div');
        zoomButtonDiv.className = 'zoom-location-button';
        zoomButtonDiv.innerHTML =
            '<i class="mdi mdi-map-marker" style="font-size: 30px; color: #6a1b9a;"></i>';
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
