@extends('layout.user')

@push('header')
    <style>
        #video {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
            position: relative;
            width: 100%;
            max-width: 100%;
            height: auto;
            display: none;
        }

        #canvas {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
            position: relative;
            width: 100%;
            max-width: 100%;
            height: auto;
            display: block;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 100%;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .instructions {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 3;
            cursor: pointer;
        }

        .example-images {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .example-images div {
            border: 2px solid white;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }

        .example-images img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .video-container {
                max-width: 100%;
            }

            canvas,
            video,
            .overlay {
                max-width: 100%;
                height: auto;
            }

            .card {
                padding: 10px;
            }

            .example-images img {
                width: 60px;
            }
        }

        .overlay {
            position: absolute;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
            width: 100%;
            max-width: 100%;
            height: auto;
            pointer-events: none;
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                <li class="breadcrumb-item active">Basic Elements</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Basic Elements</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card" id="camera-denied-row" style="display: none; height: 70vh;">
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
                            <div class="camera-denied text-center" style="padding: 550px;">
                                <h2><strong>Izin Akses Kamera</strong></h2>
                                <p>Untuk mengaktifkan akun dan mencari foto kamu, Fotoyu memerlukan persetujuanmu untuk
                                    mengaktifkan akses kameramu.</p>
                                <a href="https://support.google.com/chrome/answer/2693767" target="_blank" class="btn btn-primary mb-2">Izinkan</a>
                                <p>Datamu dienkripsi oleh RoboYu, sehingga sebagian besar staf Fotoyu tidak dapat membaca
                                    data tersebut.</p>
                                <small>(Hanya beberapa staf penting yang memiliki akses untuk keperluan pemeliharaan)</small>
                            </div>
                        </div>
                    </div>                                       
                    <div class="card" id="camera-access-row" style="display: none;">
                        <div class="card-body text-center">
                            <h1 class="">Tambah Selfie</h1>
                            <div class="card text-white bg-danger text-xs-center">
                                <div class="card-body">
                                    <blockquote class="card-bodyquote mb-0">
                                        <p>Hadap depan dan pastikan wajahmu bersih dan tidak tertutup oleh aksesoris (selain
                                            kacamata) dan rambut</p>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="instructions" onclick="hideInstructions()">
                                <h1>Ikuti instruksi saat kamu memulai</h1>
                                <p>Ketuk layar untuk melanjutkan</p>
                                <h2>Contoh Yang Benar & Salah:</h2>
                                <div class="example-images">
                                    <div>
                                        <img src="path/to/image1.jpg" alt="Benar 1">
                                        <p>✔ Benar</p>
                                    </div>
                                    <div>
                                        <img src="path/to/image2.jpg" alt="Salah 1">
                                        <p>✘ Salah</p>
                                    </div>
                                    <div>
                                        <img src="path/to/image3.jpg" alt="Benar 2">
                                        <p>✔ Benar</p>
                                    </div>
                                    <div>
                                        <img src="path/to/image4.jpg" alt="Benar 3">
                                        <p>✔ Benar</p>
                                    </div>
                                </div>
                            </div>

                            <div class="video-container">
                                <video id="video" autoplay></video>
                                <canvas id="canvas"></canvas>
                                <img src="{{ asset('foto/overlay-wajah.png') }}" class="overlay" id="overlay">
                            </div>

                            <div class="controls">
                                <button class="btn btn-success waves-effect waves-light mt-4 mb-4" id="capture-btn">Ambil
                                    Foto</button>
                                <button class="btn btn-primary waves-effect waves-light mt-4 mb-4" id="retake-btn"
                                    style="display:none;">Ambil Ulang</button>
                                <button class="btn btn-secondary waves-effect waves-light mt-4 mb-4" id="submit-btn"
                                    style="display:none;">Submit</button>
                            </div>
                        </div>
                        {{-- <div class="card-body text-center">
                        <h1 class="">Tambah Selfie</h1>
                        <div class="card text-white bg-danger text-xs-center instructions">
                            <div class="card-body">
                                <blockquote class="card-bodyquote mb-0">
                                    <p>Hadap depan dan pastikan wajahmu bersih dan tidak tertutup oleh aksesoris (selain
                                        kacamata) dan rambut</p>
                                </blockquote>
                            </div>
                        </div>
                        <div class="instructions" onclick="hideInstructions()">
                            <h1>Ikuti instruksi saat kamu memulai</h1>
                            <p>Ketuk layar untuk melanjutkan</p>
                            <h2>Contoh Yang Benar & Salah:</h2>
                            <div class="example-images">
                                <div>
                                    <img src="path/to/image1.jpg" alt="Benar 1">
                                    <p>✔ Benar</p>
                                </div>
                                <div>
                                    <img src="path/to/image2.jpg" alt="Salah 1">
                                    <p>✘ Salah</p>
                                </div>
                                <div>
                                    <img src="path/to/image3.jpg" alt="Benar 2">
                                    <p>✔ Benar</p>
                                </div>
                                <div>
                                    <img src="path/to/image4.jpg" alt="Benar 3">
                                    <p>✔ Benar</p>
                                </div>
                            </div>
                        </div>

                        <!-- Video and Canvas for Selfie -->
                        <div class="video-container" style="display: none;">
                            <video id="video" autoplay></video>
                            <canvas id="canvas"></canvas>
                            <img src="{{ asset('foto/overlay-wajah.png') }}" class="overlay" id="overlay">
                        </div>

                        <!-- Controls -->
                        <div class="controls" style="display: none;">
                            <button class="btn btn-success waves-effect waves-light mt-4 mb-4" id="capture-btn">Ambil
                                Foto</button>
                            <button class="btn btn-primary waves-effect waves-light mt-4 mb-4" id="retake-btn"
                                style="display:none;">Ambil Ulang</button>
                            <button class="btn btn-secondary waves-effect waves-light mt-4 mb-4" id="submit-btn"
                                style="display:none;">Submit</button>
                        </div>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const retakeBtn = document.getElementById('retake-btn');
        const submitBtn = document.getElementById('submit-btn');
        const context = canvas.getContext('2d');
        const overlayImage = document.getElementById('overlay');

        const cameraDeniedRow = document.getElementById('camera-denied-row');
        const cameraAccessRow = document.getElementById('camera-access-row');

        let stream; // Simpan stream di variabel global agar bisa diakses di seluruh script

        function hideInstructions() {
            document.querySelector('.instructions').style.display = 'none';
            video.style.display = 'block';
            canvas.style.display = 'none';
            overlayImage.style.display = 'block';
            startCamera();
        }

        function startCamera() {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(mediaStream => {
                    stream = mediaStream; // Simpan stream di variabel global
                    video.srcObject = stream;
                    video.addEventListener('loadedmetadata', () => {
                        // Atur ukuran canvas sesuai rasio aspek video
                        const aspectRatio = video.videoWidth / video.videoHeight;
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        // Sesuaikan style untuk menjaga proporsi
                        canvas.style.width = `${canvas.width}px`;
                        canvas.style.height = `${canvas.height}px`;
                        overlayImage.style.width = `${canvas.width}px`;
                        overlayImage.style.height = `${canvas.height}px`;

                        // Tampilkan camera-access-row dan sembunyikan camera-denied-row
                        cameraAccessRow.style.display = 'block';
                        cameraDeniedRow.style.display = 'none';
                    });
                })
                .catch(err => {
                    console.error("Gagal mengakses kamera: ", err);
                    // Tampilkan camera-denied-row dan sembunyikan camera-access-row
                    cameraDeniedRow.style.display = 'block';
                    cameraAccessRow.style.display = 'none';
                });
        }

        captureBtn.addEventListener('click', () => {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            canvas.style.display = 'block';
            video.style.display = 'none';

            // Menyembunyikan gambar overlay
            overlayImage.style.display = 'none';

            // Matikan kamera
            if (stream) {
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop()); // Hentikan semua track pada stream
            }

            // Sembunyikan tombol "Ambil Foto" dan tampilkan tombol "Ambil Ulang" serta "Submit"
            captureBtn.style.display = 'none';
            retakeBtn.style.display = 'inline-block';
            submitBtn.style.display = 'inline-block';
        });

        retakeBtn.addEventListener('click', () => {
            // Reset tampilan untuk mengambil ulang foto
            canvas.style.display = 'none';
            video.style.display = 'block';
            overlayImage.style.display = 'block';

            // Mulai ulang kamera
            startCamera();

            // Tampilkan tombol "Ambil Foto" dan sembunyikan tombol "Ambil Ulang" serta "Submit"
            captureBtn.style.display = 'inline-block';
            retakeBtn.style.display = 'none';
            submitBtn.style.display = 'none';
        });

        submitBtn.addEventListener('click', () => {
            // Konversi gambar dari canvas ke Blob
            canvas.toBlob(blob => {
                const formData = new FormData();
                formData.append('file', blob, 'fotodepan.png'); // Nama file yang dikirim ke server

                // Kirim data gambar ke server
                fetch('{{ route('user.fotodepan') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Kirim token CSRF Laravel
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Foto disubmit!", data);
                        if (data.success) {
                            // Redirect setelah berhasil upload
                            window.location.href = data
                                .redirect_url; // Redirect ke URL yang diterima dari server
                        } else {
                            alert("Foto gagal diupload."); // Tangani jika upload gagal
                        }
                    })
                    .catch(error => {
                        console.error("Terjadi kesalahan:", error);
                        alert("Terjadi kesalahan saat mengupload foto."); // Notifikasi kesalahan
                    });
            }, 'image/png');
        });

        // Fungsi untuk memulai ulang akses kamera jika pengguna menolak pada awalnya
        function retryAccess() {
            cameraDeniedRow.style.display = 'none';
            cameraAccessRow.style.display = 'block';
            startCamera();
        }

        // Pastikan untuk memanggil startCamera() saat halaman dimuat
        window.onload = function() {
            startCamera();
        };
    </script>

    {{-- <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const retakeBtn = document.getElementById('retake-btn');
        const submitBtn = document.getElementById('submit-btn');
        const context = canvas.getContext('2d');
        const overlayImage = document.getElementById('overlay');

        let stream; // Simpan stream di variabel global agar bisa diakses di seluruh script

        function hideInstructions() {
            document.querySelector('.instructions').style.display = 'none';
            video.style.display = 'block';
            canvas.style.display = 'none';
            overlayImage.style.display = 'block';
            startCamera();
        }

        function startCamera() {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(mediaStream => {
                    stream = mediaStream; // Simpan stream di variabel global
                    video.srcObject = stream;
                    video.addEventListener('loadedmetadata', () => {
                        // Atur ukuran canvas sesuai rasio aspek video
                        const aspectRatio = video.videoWidth / video.videoHeight;
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        // Sesuaikan style untuk menjaga proporsi
                        canvas.style.width = `${canvas.width}px`;
                        canvas.style.height = `${canvas.height}px`;
                        overlayImage.style.width = `${canvas.width}px`;
                        overlayImage.style.height = `${canvas.height}px`;
                    });
                })
                .catch(err => {
                    console.error("Gagal mengakses kamera: ", err);
                    // Show the camera access denied message
                    cameraDenied.style.display = 'block';
                    video.style.display = 'none'; // Hide the video element if camera access is denied
                });
        }

        captureBtn.addEventListener('click', () => {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            canvas.style.display = 'block';
            video.style.display = 'none';

            // Menyembunyikan gambar overlay
            overlayImage.style.display = 'none';

            // Matikan kamera
            if (stream) {
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop()); // Hentikan semua track pada stream
            }

            // Sembunyikan tombol "Ambil Foto" dan tampilkan tombol "Ambil Ulang" serta "Submit"
            captureBtn.style.display = 'none';
            retakeBtn.style.display = 'inline-block';
            submitBtn.style.display = 'inline-block';
        });

        retakeBtn.addEventListener('click', () => {
            // Reset tampilan untuk mengambil ulang foto
            canvas.style.display = 'none';
            video.style.display = 'block';
            overlayImage.style.display = 'block';

            // Mulai ulang kamera
            startCamera();

            // Tampilkan tombol "Ambil Foto" dan sembunyikan tombol "Ambil Ulang" serta "Submit"
            captureBtn.style.display = 'inline-block';
            retakeBtn.style.display = 'none';
            submitBtn.style.display = 'none';
        });

        submitBtn.addEventListener('click', () => {
            // Konversi gambar dari canvas ke Blob
            canvas.toBlob(blob => {
                const formData = new FormData();
                formData.append('file', blob, 'fotodepan.png'); // Nama file yang dikirim ke server

                // Kirim data gambar ke server
                fetch('{{ route('user.fotodepan') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Kirim token CSRF Laravel
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Foto disubmit!", data);
                        if (data.success) {
                            // Redirect setelah berhasil upload
                            window.location.href = data
                                .redirect_url; // Redirect ke URL yang diterima dari server
                        } else {
                            alert("Foto gagal diupload."); // Tangani jika upload gagal
                        }
                    })
                    .catch(error => {
                        console.error("Terjadi kesalahan:", error);
                        alert("Terjadi kesalahan saat mengupload foto."); // Notifikasi kesalahan
                    });
            }, 'image/png');
        });
    </script> --}}
@endpush
