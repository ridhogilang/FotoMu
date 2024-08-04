@extends('layout.foto')

@push('header')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a>
                                </li>
                                <li class="breadcrumb-item active">Add / Edit Product</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tambah Foto</h4>
                    </div>
                </div>
            </div>
            <form id="uploadForm">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Foto</h5>

                                <div class="dropzone" id="myAwesomeDropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>

                                    <div class="dz-message needsclick">
                                        <i class="h1 text-muted dripicons-cloud-upload"></i>
                                        <h3>Drop files here or click to upload.</h3>
                                        <span class="text-muted font-13">(Pilih file untuk diupload maksimal
                                            <strong>maksimal</strong> 500 file foto.)</span>
                                    </div>
                                </div>

                                <div class="dropzone-previews mt-3" id="file-previews"></div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-rounded" id="pagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Detail Foto</h5>

                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga Dasar <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="harga" class="form-control"
                                        placeholder="Masukkan harga dasar fotomu">
                                    <input type="hidden" name="harga" id="harga-hidden">
                                </div>

                                <div class="harga-details p-3 mb-3 border rounded">
                                    <div class="detail-harga">
                                        <strong>Detail Harga</strong>
                                        <div class="d-flex justify-content-between">
                                            <span>Net Kreator (90%)</span>
                                            <span class="text-muted" id="net-kreator">Rp. </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Biaya FotoMu (10%)</span>
                                            <span class="text-muted" id="biaya-fotoyu">Rp. </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Biaya Host (0%)</span>
                                            <span class="text-muted" id="biaya-host">Rp. </span>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between">
                                            <span>Harga Dasar (90%)</span>
                                            <span class="text-muted" id="harga-dasar">Rp. </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex flex-column">
                                                <span>Biaya pembayaran & layanan</span>
                                                <span class="text-muted">(0% dari harga jual)</span>
                                            </div>
                                            <span class="text-muted" id="biaya-layanan">Rp. </span>
                                        </div>

                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span><strong>Harga Jual</strong></span>
                                            <span class="text-primary" id="harga-jual">Rp. </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="event" class="form-label">Event <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="event_id" id="event">
                                        <option>Select</option>
                                        @foreach ($event as $eventItem)
                                            <option value="{{ $eventItem->id }}">{{ $eventItem->event }}</option>
                                        @endforeach
                                    </select>
                                    <span>*event belum tersedia, masukkan nama event <a href="">disini</a></span>
                                </div>
                                <div>
                                    <label class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control" name="deskripsi" rows="3" placeholder="Deskripsikan fotomu"></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-3">
                            <a href="fotografer/profil" class="btn w-sm btn-light waves-effect">Cancel</a>
                            <button type="button" class="btn w-sm btn-success waves-effect waves-light" id="save-button"
                                disabled>Save</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-none" id="uploadPreviewTemplate">
                <div class="card mt-1 mb-0 shadow-none border">
                    <div class="p-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                <p class="mb-0" data-dz-size></p>
                                <div class="progress mt-2">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                        data-dz-uploadprogress></div>
                                </div>
                                <div class="dz-success-message text-success d-none">
                                    <i class="dripicons-checkmark"></i> Done
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0);" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                    <i class="dripicons-cross"></i>
                                </a>
                            </div>
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
    <script src="{{ asset('libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('js/pages/add-product.init.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#myAwesomeDropzone", {
            url: "/fotografer/foto/upload", // Endpoint untuk upload sementara
            previewsContainer: "#file-previews",
            previewTemplate: document.querySelector('#uploadPreviewTemplate').innerHTML,
            autoProcessQueue: true, // Mengunggah file ke lokasi sementara saat ditambahkan
            parallelUploads: 10,
            maxFiles: 500,
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

                    tempFiles.push(response.tempPath); // Tambahkan path file sementara
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
                        file_paths: tempFiles // Kirim path file sementara
                    };

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
                            text: 'Terjadi kesalahan saat menyimpan data.',
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
@endpush
