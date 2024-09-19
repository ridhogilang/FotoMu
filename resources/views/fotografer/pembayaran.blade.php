@extends('layout.foto');

@push('header')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .otp-input:focus {
            border-color: #6c63ff;
            /* Warna saat fokus */
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.5);
        }

        .rekening-info p {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }

        .rekening-info p strong {
            color: #333;
        }

        .text-purple {
            color: #6f42c1;
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a>
                                </li>
                                <li class="breadcrumb-item active">Checkout</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Checkout</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    @if ($fotografer->rekening_id)
                                        <h4 class="header-title mb-3">Rekening Anda</h4>
                                        <div class="card mb-1 shadow-none border" data-bs-toggle="modal"
                                            data-bs-target="#rekeningModal">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm">
                                                            <span
                                                                class="avatar-title badge-soft-primary text-primary rounded">
                                                                <i data-feather="credit-card" class="icon-dual"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <a href="javascript:void(0);"
                                                            class="text-muted fw-bold">{{ $fotografer->rekening->nama_bank }}
                                                            | {{ $fotografer->rekening->nama }}
                                                        </a>
                                                        <p class="mb-0 font-12">{{ $fotografer->rekening->rekening }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="rekeningModal" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rekeningModalLabel">Detail Rekening</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <!-- Informasi Rekening -->
                                                        <div class="rekening-info">
                                                            <p><strong>Nama Akun</strong> <span
                                                                    class="float-end">{{ $fotografer->rekening->nama }}</span>
                                                            </p>
                                                            <p><strong>Nomor Rekening Bank</strong> <span
                                                                    class="float-end">{{ $fotografer->rekening->rekening }}</span>
                                                            </p>
                                                            <p><strong>Nama Bank</strong> <span
                                                                    class="float-end">{{ $fotografer->rekening->nama_bank }}</span>
                                                            </p>
                                                        </div>

                                                        <!-- Tombol Hapus Rekening -->
                                                        <div class="mt-4">
                                                            <button class="btn btn-danger waves-effect waves-light w-100"
                                                                id="deleteRekeningBtn"
                                                                data-id="{{ $fotografer->rekening_id }}">Hapus Rekening
                                                                Bank</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <h4 class="header-title mb-3">Rekening
                                                Bank Baru</h4>
                                            <form id="rekeningForm" method="POST" action="{{ route('bank.store') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="billing-first-name" class="form-label">Nama
                                                                Lengkap</label>
                                                            <input class="form-control" name="nama" type="text"
                                                                placeholder="Masukkan nama pemilik rekening" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="billing-first-name" class="form-label">Nomor
                                                                Rekening</label>
                                                            <input class="form-control" name="rekening" type="number"
                                                                min="10" placeholder="Masukkan nomor rekening" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Bank</label>
                                                            <select class="form-select" id="example-select"
                                                                name="nama_bank" data-width="100%">
                                                                <option value="">Pilih Nama Bank
                                                                </option>
                                                                <option value="BCA">BCA</option>
                                                                <option value="CIMB Niaga">Bank CIMB
                                                                    Niaga</option>
                                                                <option value="Bank Jago">Bank Jago
                                                                </option>
                                                                <option value="Bank Mandiri">Bank
                                                                    Mandiri</option>
                                                                <option value="Bank Negara Indonesia (BNI)">
                                                                    Bank Negara
                                                                    Indonesia (BNI)</option>
                                                                <option value="Bank Permata">Bank
                                                                    Permata</option>
                                                                <option value="Bank Rakyat Indonesia (BRI)">
                                                                    Bank Rakyat
                                                                    Indonesia (BRI)</option>
                                                                <option value="Bank Syariah Indonesia (BSI)">
                                                                    Bank Syariah
                                                                    Indonesia (BSI)</option>
                                                                <option value="Dana">Dana</option>
                                                                <option value="GoPay">GoPay</option>
                                                                <option value="LinkAja">LinkAja
                                                                </option>
                                                                <option value="ShopeePay">ShopeePay
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <div class="text-sm-end mt-2 mt-sm-0">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="mdi mdi-truck-fast me-1"></i>
                                                                Tambah Bank </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content p-3">
                                        <div class="tab-pane fade active show mt-2" id="custom-v-pills-billing"
                                            role="tabpanel" aria-labelledby="custom-v-pills-billing-tab">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="header-title">Riwayat Penarikan</h4>
                                                <div class="text-sm-end">
                                                    <button type="button"
                                                        class="btn btn-success waves-effect waves-light mb-2"
                                                        id="tarikUangButton">
                                                        Tarik Uang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('bank.penarikan') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="standard-modalLabel">Form
                                                                Penarikan Penghasilan</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <!-- Input Jumlah -->
                                                                <label for="jumlah" class="form-label">Penarikan <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="jumlah" class="form-control"
                                                                    placeholder="Masukkan jumlah penarikan">
                                                                <input type="hidden" name="jumlah" id="jumlah-hidden">
                                                                <!-- Hidden input untuk menyimpan nilai tanpa format Rp. -->
                                                            </div>
                                                            <div class="mb-3">
                                                                <!-- Input Rekening -->
                                                                <label for="rekening_id" class="form-label">Rekening <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $fotografer->rekening->nama }} - {{ $fotografer->rekening->rekening }} ({{ $fotografer->rekening->nama_bank }})"
                                                                    disabled>
                                                                <input type="hidden" name="rekening_id"
                                                                    value="{{ $fotografer->rekening_id }}">
                                                                <!-- Hanya kirim rekening_id -->
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        <table id="basic-datatable"
                                            class="table table-centered table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No. </th>
                                                    <th>Rekening</th>
                                                    <th>Jumlah</th>
                                                    <th>Saldo</th>
                                                    <th>Status</th>
                                                    <th>Pengajuan</th>
                                                    <th style="width: 82px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($penarikan as $penarikanItem)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $penarikanItem->rekening->nama }} -
                                                            {{ $penarikanItem->rekening->nama_bank }}</td>
                                                        <td>Rp.
                                                            {{ number_format($penarikanItem->jumlah, 0, ',', '.') }}
                                                        </td>
                                                        <td>Rp.
                                                            {{ number_format($penarikanItem->saldo, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ $penarikanItem->status }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($penarikanItem->requested_at)->format('d, M y') }}
                                                        </td>
                                                        <td>
                                                            @if ($penarikanItem->status === 'Pending')
                                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                                <a href="javascript:void(0);" class="action-icon"
                                                                    onclick="confirmDelete({{ $penarikanItem->id }})">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="tab-pane fade active show mt-3" id="custom-v-pills-billing"
                                            role="tabpanel" aria-labelledby="custom-v-pills-billing-tab">
                                            <div>
                                                <h4 class="header-title mb-3">PendapatanMu</h4>
                                            </div>
                                        </div>
                                        <table id="datatable-buttons"
                                            class="table table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Pendapatan</th>
                                                    <th>Penarikan</th>
                                                    <th>Status</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($uangMasukPerHari as $index => $earning)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>Rp.
                                                            {{ number_format($earning->total_uang_masuk, 0, ',', '.') }}
                                                        </td>
                                                        <td>-</td> <!-- Tidak ada uang keluar di sini -->
                                                        <td>Pendapatan
                                                            ({{ \Carbon\Carbon::parse($earning->date)->format('d M Y') }})
                                                        </td>
                                                        <td>Rp. {{ number_format($earning->saldo_akhir, 0, ',', '.') }}
                                                        </td> <!-- Saldo akhir -->
                                                    </tr>
                                                @endforeach
                                                @foreach ($uangKeluar as $index => $withdrawal)
                                                    <tr>
                                                        <td>{{ $index + 1 + count($uangMasukPerHari) }}</td>
                                                        <td>-</td> <!-- Tidak ada uang masuk di baris ini -->
                                                        <td>Rp. {{ number_format($withdrawal->uang_keluar, 0, ',', '.') }}
                                                        </td>
                                                        <td>Penarikan ({{ $withdrawal->created_at->format('d M Y') }})</td>
                                                        <td>Rp. {{ number_format($withdrawal->jumlah, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end row-->

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal OTP -->
            <!-- Modal OTP -->
            <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="otpModalLabel">Verifikasi OTP</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p>Masukkan OTP yang dikirim ke <br><strong>rid********se@g****l.com</strong></p>

                            <!-- Tambahkan Form untuk OTP -->
                            <form id="otpForm" method="POST" action="{{ route('bank.verifyOtp') }}">
                                @csrf <!-- Laravel CSRF Protection -->

                                <!-- Input OTP (6 digit) -->
                                <div class="otp-inputs">
                                    <input type="text" class="otp-input" name="otp[]" maxlength="1" required>
                                    <input type="text" class="otp-input" name="otp[]" maxlength="1" required>
                                    <input type="text" class="otp-input" name="otp[]" maxlength="1" required>
                                    <input type="text" class="otp-input" name="otp[]" maxlength="1" required>
                                    <input type="text" class="otp-input" name="otp[]" maxlength="1" required>
                                    <input type="text" class="otp-input" name="otp[]" maxlength="1" required>
                                </div>

                                <!-- Resend Timer -->
                                <p class="mt-3">Tidak menerima kode?</p>
                                <p class="text-muted">Kirim ulang tautan (<span id="resend-timer">4m46d</span>)</p>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" id="confirm-btn" class="btn btn-primary"
                                        disabled>Konfirmasi</button>
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
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set CSRF Token di setiap request AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Saat form rekening dikirim
            $('#rekeningForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form dari reload halaman

                $('#otpModal').modal('show'); // Tampilkan modal OTP

                $.ajax({
                    url: "{{ route('bank.store') }}", // Arahkan ke route store rekening
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        // Jika sukses, munculkan modal OTP
                    },
                    error: function(xhr) {
                        // Jika ada error, tampilkan pesan error (optional)
                        alert('Gagal menambah rekening. Silakan coba lagi.');
                    }
                });
            });

            // Saat form OTP dikirim
            $('#otpForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                // Gabungkan nilai dari semua input OTP menjadi satu string
                var otp = '';
                $('.otp-input').each(function() {
                    otp += $(this).val(); // Gabungkan nilai setiap input
                });

                // Kirim OTP ke server melalui AJAX
                $.ajax({
                    url: "{{ route('bank.verifyOtp') }}", // Ganti dengan route verifikasi OTP
                    method: "POST",
                    data: {
                        otp: otp, // Kirim OTP sebagai satu string
                        _token: $('meta[name="csrf-token"]').attr('content') // Sertakan CSRF token
                    },
                    success: function(response) {
                        // Jika sukses, tutup modal dan tampilkan SweetAlert
                        $('#otpModal').modal('hide');

                        // Tampilkan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload halaman setelah pengguna menutup SweetAlert
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        // Jika ada error, tampilkan pesan error menggunakan SweetAlert
                        if (xhr.status === 422) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kode OTP Salah!',
                                text: xhr.responseJSON.error,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan!',
                                text: 'Terjadi kesalahan, silakan coba lagi.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });

            // Fokus ke input berikutnya secara otomatis setelah mengisi 1 karakter
            $('.otp-input').on('keyup', function(e) {
                var nextInput = $(this).next('.otp-input');
                var prevInput = $(this).prev('.otp-input');

                // Pindah ke input berikutnya jika ada dan karakter sudah dimasukkan
                if (this.value.length === 1 && nextInput.length) {
                    nextInput.focus();
                }
                // Jika tombol backspace ditekan, pindah ke input sebelumnya
                else if (e.key === 'Backspace' && prevInput.length) {
                    prevInput.focus();
                }

                // Cek apakah semua input sudah terisi
                checkOtpInputs();
            });

            function checkOtpInputs() {
                var allFilled = true;
                $('.otp-input').each(function() {
                    if ($(this).val() === '') {
                        allFilled = false;
                        return false;
                    }
                });

                // Jika semua terisi, enable tombol "Konfirmasi"
                if (allFilled) {
                    $('#confirm-btn').prop('disabled', false);
                } else {
                    $('#confirm-btn').prop('disabled', true);
                }
            }

            var timer = 280; // 4 menit 46 detik
            var timerInterval = setInterval(function() {
                if (timer <= 0) {
                    clearInterval(timerInterval);
                    $('#resend-timer').text('Kirim Ulang').addClass(
                        'active'); // Aktifkan tombol resend setelah waktu habis
                } else {
                    var minutes = Math.floor(timer / 60);
                    var seconds = timer % 60;
                    $('#resend-timer').text(minutes + 'm' + seconds + 'd');
                    timer--;
                }
            }, 1000);

            $('#resend-timer').on('click', function() {
                if ($(this).hasClass('active')) { // Pastikan tombol aktif setelah timer habis
                    $.ajax({
                        url: "{{ route('bank.resendOtp') }}", // Route untuk resend OTP
                        method: "POST",
                        success: function(response) {
                            alert('OTP baru telah dikirim.');
                            timer = 280; // Reset timer setelah OTP dikirim ulang
                            $('#resend-timer').removeClass(
                                'active'); // Nonaktifkan tombol resend setelah OTP dikirim
                            // Restart countdown
                            timerInterval = setInterval(function() {
                                if (timer <= 0) {
                                    clearInterval(timerInterval);
                                    $('#resend-timer').text('Kirim Ulang').addClass(
                                        'active');
                                } else {
                                    var minutes = Math.floor(timer / 60);
                                    var seconds = timer % 60;
                                    $('#resend-timer').text(minutes + 'm' + seconds +
                                        'd');
                                    timer--;
                                }
                            }, 1000);
                        },
                        error: function(xhr) {
                            alert('Gagal mengirim ulang OTP. Silakan coba lagi.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#deleteRekeningBtn').on('click', function(e) {
                e.preventDefault();
                var rekeningId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data rekening bank akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/fotografer/bank/" +
                                rekeningId,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Dihapus!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan, silakan coba lagi.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById('tarikUangButton').addEventListener('click', function() {
            // Panggil pengecekan via Ajax
            cekRekeningFotografer();
        });

        function cekRekeningFotografer() {
            // Menggunakan fetch untuk melakukan request ke backend
            fetch('/fotografer/cek-rekening-fotografer')
                .then(response => response.json())
                .then(data => {
                    if (data.rekening_ada) {
                        // Jika rekening_id ada, tampilkan modal
                        var modal = new bootstrap.Modal(document.getElementById('standard-modal'));
                        modal.show();
                    } else {
                        // Jika rekening_id tidak ada, tampilkan SweetAlert
                        Swal.fire({
                            title: 'Rekening Tidak Ditemukan!',
                            text: 'Silakan tambahkan nomor rekening terlebih dahulu sebelum menarik uang.',
                            icon: 'warning',
                            confirmButtonText: 'Ok', // Hanya satu tombol OK
                            showCancelButton: false // Tidak ada tombol Cancel
                        });

                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Oops...', 'Terjadi kesalahan saat memeriksa rekening!', 'error');
                });
        }
    </script>
    <script>
        const jumlahInput = document.getElementById('jumlah');
        const jumlahHiddenInput = document.getElementById('jumlah-hidden');

        jumlahInput.addEventListener('input', function() {
            // Hapus format Rp. dan koma untuk mendapatkan nilai asli
            let value = this.value.replace(/\D/g, '');

            // Perbarui nilai di input hidden (nilai asli tanpa format)
            jumlahHiddenInput.value = value;

            // Tambahkan format Rp. dan koma pada tampilan input
            this.value = formatRupiah(value);
        });

        // Fungsi untuk memformat angka menjadi format Rp.
        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/\D/g, '');
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp. ' + rupiah;
        }
    </script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(id);
                }
            });
        }
    
        function deleteData(id) {
            $.ajax({
                url: '/fotografer/penarikan/' + id,  // URL untuk menghapus data berdasarkan id
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'  // Token CSRF Laravel
                },
                success: function(response) {
                    Swal.fire(
                        'Dihapus!',
                        'Data berhasil dihapus.',
                        'success'
                    ).then((result) => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Gagal!',
                        'Data tidak berhasil dihapus.',
                        'error'
                    );
                }
            });
        }
    </script>
@endpush
