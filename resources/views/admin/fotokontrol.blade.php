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
                                <li class="breadcrumb-item active">Foto Kontrol</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Foto Kontrol</h4>
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
                                    <button type="button"
                                        class="btn btn-success w-100 waves-effect waves-light dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="mdi mdi-plus"></i>Upload Tree</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('foto.upload') }}"><i
                                                class="mdi mdi-folder-plus-outline me-1"></i> Tambah Foto</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="mdi mdi-file-plus-outline me-1"></i> Tambah Event</a>
                                    </div>
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
                                            <input type="text" name="search" class="form-control form-control-light"
                                                placeholder="Search files..." value="{{ request('search') }}">
                                            <!-- Isi dengan nilai pencarian jika ada -->
                                            <span class="mdi mdi-magnify"></span>
                                        </div>
                                    </form>
                                    <div class="mt-2 mt-md-0">
                                        <button type="submit" class="btn btn-sm btn-white"><i
                                                class="mdi mdi-format-list-bulleted"></i></button>
                                        <button type="submit" class="btn btn-sm btn-white"><i
                                                class="mdi mdi-view-grid"></i></button>
                                        <button type="submit" class="btn btn-sm btn-white"><i
                                                class="mdi mdi-information-outline"></i></button>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h5 class="mb-2">Event FotoMu</h5>

                                    <div class="row mx-n1 g-0">
                                        @foreach ($event as $eventItem)
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card m-1 shadow-none border"
                                                    onclick="window.location='{{ route('admin.fotoevent', ['id' => Crypt::encryptString($eventItem->id)]) }}';"
                                                    style="cursor: pointer;">
                                                    <div class="p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto pe-0">
                                                                <div class="avatar-sm">
                                                                    <span
                                                                        class="avatar-title bg-light text-secondary rounded">
                                                                        <i class="mdi mdi-folder-account font-18"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <!-- Teks link tetap untuk keperluan SEO atau aksesibilitas -->
                                                                <a href="{{ route('admin.fotoevent', ['id' => Crypt::encryptString($eventItem->id)]) }}"
                                                                    class="text-muted fw-bold">
                                                                    {{ $eventItem->event }}
                                                                </a>
                                                                <p class="mb-0 font-13">
                                                                    {{ $eventItem->total_storage_formatted }}</p>
                                                            </div>
                                                        </div> <!-- end row -->
                                                    </div> <!-- end .p-2-->
                                                </div> <!-- end col -->
                                            </div>
                                        @endforeach
                                    </div> <!-- end row-->
                                </div> <!-- end .mt-3-->

                            </div>
                            <!-- end inbox-rightbar-->

                            <div class="clearfix"></div>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end Col -->
            </div><!-- End row -->

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
