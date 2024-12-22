@extends('layout.admin')

@push('header')
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.fotokontrol') }}">Foto Kontrol</a></li>
                                <li class="breadcrumb-item active">File Manager</li>
                            </ol>
                        </div>
                        <h4 class="page-title">File Manager</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">

                <!-- Right Sidebar -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Left sidebar -->
                            <div class="inbox-leftbar">
                                <div class="btn-group d-block mb-2">
                                    <a href="{{ route('admin.fotokontrol') }}" class="btn btn-secondary waves-effect"><i
                                            class="fe-arrow-left"></i>Kembali</a>
                                </div>
                                
                                <div class="mt-5">
                                    <h4><span class="badge rounded-pill p-1 px-2 badge-soft-secondary">FREE</span>
                                    </h4>
                                    <h6 class="text-uppercase mt-3">Storage</h6>
                                    <div class="progress my-2 progress-sm">
                                        <div class="progress-bar progress-lg bg-success" role="progressbar"
                                            style="width: {{ number_format($percentageUsed, 2) }}%"
                                            aria-valuenow="{{ number_format($percentageUsed, 2) }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <p>{{ $totalStorageFormatted }} ({{ number_format($percentageUsed, 2) }}%) of
                                        {{ $maxStorageFormatted }} used</p>
                                </div>

                            </div>
                            <!-- End Left sidebar -->

                            <div class="inbox-rightbar">
                                <div class="d-md-flex justify-content-between align-items-center">
                                    <form class="search-bar" method="GET" action="{{ route('admin.fotokontrol') }}">
                                        <div class="position-relative">

                                        </div>
                                    </form>
                                    <div class="mt-2 mt-md-0">
                                        <!-- Tombol Pilih dan Pilih Semua -->
                                        <button id="pilih" type="button"
                                            class="btn btn-success waves-effect waves-light">Pilih</button>
                                        <button id="pilih-semua" type="button"
                                            class="btn btn-outline-primary waves-effect waves-light">Pilih Semua</button>

                                        <!-- Tombol Hapus Pilihan (untuk modal) dan Hapus Data -->
                                        <button id="hapus-pilihan-modal" type="button"
                                            class="btn btn-blue waves-effect waves-light" style="display: none;">
                                            <i class="mdi mdi-border-color"></i>
                                        </button>
                                        <button id="hapus-pilihan-data" type="button"
                                            class="btn btn-danger waves-effect waves-light" style="display: none;">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>

                                        <!-- Tombol Batal Pilih -->
                                        <button id="batal-pilih" type="button"
                                            class="btn btn-warning waves-effect waves-light" style="display: none;">Batal
                                            Pilih</button>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h5 class="mb-2">Event - {{ $event }}</h5>

                                    <div class="row mx-n1 g-0 mt-3">
                                        @foreach ($foto as $fotoItem)
                                            <div class="col"
                                                style="flex: 0 0 20%; max-width: 20%; padding: 0; position: relative;">
                                                <div class="card m-1 shadow">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <!-- Foto -->
                                                            <img src="{{ Storage::url($fotoItem->foto) }}" alt="Foto"
                                                                class="img-fluid rounded">
                                                            <!-- Checkbox Pilihan di Pojok Kanan Atas, disembunyikan secara default -->
                                                            <input type="checkbox" class="form-check-input checkbox-foto"
                                                                value="{{ $fotoItem->id }}"
                                                                style="position: absolute; top: 10px; right: 10px; display: none;">
                                                        </div>
                                                    </div> <!-- end row -->
                                                </div> <!-- end card -->
                                            </div>
                                            <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                                                aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Edit
                                                                    Konten Foto</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="event" class="form-label">Event <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-control select2" name="event_id"
                                                                        id="event">
                                                                        <option>Select</option>
                                                                        @foreach ($eventAll as $eventItem)
                                                                            <option value="{{ $eventItem->id }}">
                                                                                {{ $eventItem->event }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span>*event belum tersedia, masukkan nama event <a
                                                                            href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#login-modal">disini</a></span>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="harga" class="form-label">Harga Dasar
                                                                        <span class="text-danger">*</span></label>
                                                                    <input type="text" id="harga"
                                                                        class="form-control"
                                                                        placeholder="Masukkan harga dasar fotomu">
                                                                    <input type="hidden" name="harga"
                                                                        id="harga-hidden">
                                                                </div>

                                                                <div class="harga-details p-3 mb-3 border rounded">
                                                                    <div class="detail-harga">
                                                                        <strong>Detail Harga</strong>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>Net Kreator (90%)</span>
                                                                            <span class="text-muted" id="net-kreator">Rp.
                                                                            </span>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>Biaya FotoMu (10%)</span>
                                                                            <span class="text-muted" id="biaya-fotoyu">Rp.
                                                                            </span>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>Biaya Host (0%)</span>
                                                                            <span class="text-muted" id="biaya-host">Rp.
                                                                            </span>
                                                                        </div>

                                                                        <hr>

                                                                        <div class="d-flex justify-content-between">
                                                                            <span>Harga Dasar (90%)</span>
                                                                            <span class="text-muted" id="harga-dasar">Rp.
                                                                            </span>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-column">
                                                                                <span>Biaya pembayaran & layanan</span>
                                                                                <span class="text-muted">(0% dari harga
                                                                                    jual)</span>
                                                                            </div>
                                                                            <span class="text-muted"
                                                                                id="biaya-layanan">Rp. </span>
                                                                        </div>

                                                                        <hr>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span><strong>Harga Jual</strong></span>
                                                                            <span class="text-primary" id="harga-jual">Rp.
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="form-label">Deskripsi (Opsional)</label>
                                                                    <textarea class="form-control" name="deskripsi" rows="3" placeholder="Deskripsikan fotomu"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    id="save-changes">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>



                                <div class="clearfix"></div>

                                <div class="row" style="margin-right: 10px;">
                                    <div class="col-12">
                                        {{ $foto->links('pagination::custom-pagination') }}
                                    </div> <!-- end col-->
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end Col -->
            </div>

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
    <script>
        // Ambil elemen tombol
        const btnPilih = document.getElementById('pilih');
        const btnPilihSemua = document.getElementById('pilih-semua');
        const btnBatalPilih = document.getElementById('batal-pilih');
        const btnHapusPilihanModal = document.getElementById('hapus-pilihan-modal');
        const btnHapusPilihanData = document.getElementById('hapus-pilihan-data');

        // Ambil semua checkbox foto
        const checkboxes = document.querySelectorAll('.checkbox-foto');

        // Fungsi untuk menampilkan tombol Hapus dan Batal
        function showActionButtons() {
            btnPilih.style.display = 'none';
            btnPilihSemua.style.display = 'none';
            btnBatalPilih.style.display = 'inline-block';
            btnHapusPilihanModal.style.display = 'inline-block';
            btnHapusPilihanData.style.display = 'inline-block';
        }

        // Fungsi untuk mengembalikan tombol Pilih dan Pilih Semua
        function showSelectionButtons() {
            btnPilih.style.display = 'inline-block';
            btnPilihSemua.style.display = 'inline-block';
            btnBatalPilih.style.display = 'none';
            btnHapusPilihanModal.style.display = 'none';
            btnHapusPilihanData.style.display = 'none';
        }

        // Tombol Pilih (untuk memilih satu persatu)
        btnPilih.addEventListener('click', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.style.display = 'block'; // Tampilkan checkbox
                checkbox.disabled = false; // Pastikan checkbox bisa diklik
            });
            showActionButtons(); // Tampilkan tombol Batal dan Hapus
        });

        // Tombol Pilih Semua
        btnPilihSemua.addEventListener('click', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.style.display = 'block'; // Tampilkan checkbox
                checkbox.checked = true; // Centang semua checkbox
                checkbox.disabled = false; // Pastikan checkbox bisa diklik
            });
            showActionButtons(); // Tampilkan tombol Batal dan Hapus
        });

        // Tombol Batal Pilih
        btnBatalPilih.addEventListener('click', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.style.display = 'none'; // Sembunyikan checkbox
                checkbox.checked = false; // Hapus semua centang
            });
            showSelectionButtons(); // Kembalikan ke tombol Pilih dan Pilih Semua
        });

        document.getElementById('hapus-pilihan-modal').addEventListener('click', function() {
            // Ambil semua checkbox yang dipilih
            const selectedPhotos = Array.from(document.querySelectorAll('.checkbox-foto:checked'));

            if (selectedPhotos.length > 0) {
                // Ambil ID dari foto yang dipilih
                const fotoId = selectedPhotos[0].value;

                // Buat permintaan ke server untuk mendapatkan ID foto berdasarkan ID
                fetch(`/admin/get-foto/${fotoId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Logika jika hanya ID yang diterima
                        console.log('ID Foto yang diperoleh:', data.id);

                        // Misalnya, Anda bisa menggunakan ID ini untuk sesuatu yang lain
                        // Tampilkan modal (contoh)
                        var myModal = new bootstrap.Modal(document.getElementById('standard-modal'));
                        myModal.show();
                    })
                    .catch(error => {
                        // Jika terjadi kesalahan
                        Swal.fire('Error!', 'Terjadi kesalahan dalam mendapatkan ID foto.', 'error');
                    });
            } else {
                // Jika tidak ada foto yang dipilih, tampilkan peringatan
                Swal.fire('Tidak ada foto yang dipilih!', 'Silakan pilih foto terlebih dahulu.', 'warning');
            }
        });


        // Tombol Hapus Data dengan konfirmasi swal.fire
        btnHapusPilihanData.addEventListener('click', function() {
            // Cek apakah ada checkbox yang dipilih
            const selectedPhotos = Array.from(checkboxes).filter(checkbox => checkbox.checked);
            if (selectedPhotos.length > 0) {
                // Tampilkan konfirmasi sebelum menghapus
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data foto yang dipilih akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil ID dari foto yang dipilih
                        const fotoIds = selectedPhotos.map(checkbox => checkbox.value);

                        // Kirimkan request DELETE dengan AJAX
                        fetch('/admin/admin-fotohapus', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content') // Ambil CSRF token dari meta tag
                                },
                                body: JSON.stringify({
                                    foto_id: fotoIds // Kirim array ID foto yang terpilih
                                })
                            }).then(response => response.json())
                            .then(data => {
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    // Reload halaman setelah alert swal ditutup
                                    location.reload();
                                });
                            }).catch(error => {
                                // Tampilkan pesan error jika gagal
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus foto.',
                                    'error'
                                );
                            });
                    }
                });
            } else {
                // Tidak ada foto yang dipilih
                Swal.fire({
                    title: 'Tidak ada foto yang dipilih!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
     {{-- js untuk skema harga fotografer --}}
     <script>
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
    {{-- js untuk update data foto --}}
    <script>
        document.getElementById('save-changes').addEventListener('click', function() {
            // Ambil semua checkbox yang dipilih
            const selectedPhotos = Array.from(document.querySelectorAll('.checkbox-foto:checked')).map(checkbox =>
                checkbox.value);

            if (selectedPhotos.length > 0) {
                // Data yang akan dikirim ke server
                const data = {
                    foto_ids: selectedPhotos,
                    event_id: document.getElementById('event').value,
                    harga: document.getElementById('harga').value,
                    deskripsi: document.querySelector('textarea[name="deskripsi"]').value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // Laravel CSRF token
                };

                // Kirimkan permintaan untuk memperbarui semua data foto yang dipilih
                fetch('/admin/update-selected-photos', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': data._token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire(
                            'Terupdate!',
                            'Data Foto berhasil diperbaharui', // Pesan statis yang langsung ditulis
                            'success'
                        ).then(() => {
                            // Reload halaman setelah alert swal ditutup
                            location.reload();
                        });
                    })
                    .catch(error => {
                        // Tampilkan pesan error jika terjadi kesalahan
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                    });
            } else {
                // Jika tidak ada foto yang dipilih, tampilkan peringatan
                Swal.fire('Tidak ada foto yang dipilih!', 'Silakan pilih foto terlebih dahulu.', 'warning');
            }
        });
    </script>
@endpush
