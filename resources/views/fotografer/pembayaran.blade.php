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


                                    <div class="border mt-4 rounded">
                                        <h4 class="header-title p-2 mb-0">Order Summary</h4>

                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 90px;">
                                                            <img src="assets/images/products/product-1.png"
                                                                alt="product-img" title="product-img" class="rounded"
                                                                height="48" />
                                                        </td>
                                                        <td>
                                                            <a href="ecommerce-product-detail.php"
                                                                class="text-body fw-semibold">Polo Navy blue
                                                                T-shirt</a>
                                                            <small class="d-block">1 x $39</small>
                                                        </td>

                                                        <td class="text-end">
                                                            $39
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img src="assets/images/products/product-2.png"
                                                                alt="product-img" title="product-img" class="rounded"
                                                                height="48" />
                                                        </td>

                                                        <td>
                                                            <a href="ecommerce-product-detail.php"
                                                                class="text-body fw-semibold">Red Hoodie for
                                                                men</a>
                                                            <small class="d-block">2 x $46</small>
                                                        </td>
                                                        <td class="text-end">
                                                            $92
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img src="assets/images/products/product-3.png"
                                                                alt="product-img" title="product-img"
                                                                class="rounded me-2" height="48" />
                                                        </td>
                                                        <td>
                                                            <a href="ecommerce-product-detail.php"
                                                                class="text-body fw-semibold">Designer Awesome
                                                                T-Shirt</a>
                                                            <small class="d-block">1 x $26</small>
                                                        </td>
                                                        <td class="text-end">
                                                            $26
                                                        </td>
                                                    </tr>
                                                    <tr class="text-end">
                                                        <td colspan="2">
                                                            <h6 class="m-0">Sub Total:</h6>
                                                        </td>
                                                        <td class="text-end">
                                                            $157
                                                        </td>
                                                    </tr>
                                                    <tr class="text-end">
                                                        <td colspan="2">
                                                            <h6 class="m-0">Shipping:</h6>
                                                        </td>
                                                        <td class="text-end">
                                                            FREE
                                                        </td>
                                                    </tr>
                                                    <tr class="text-end">
                                                        <td colspan="2">
                                                            <h5 class="m-0">Total:</h5>
                                                        </td>
                                                        <td class="text-end fw-semibold">
                                                            $157
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-lg-8">
                                    <div class="tab-content p-3">
                                        <div class="tab-pane fade active show" id="custom-v-pills-billing"
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
                                                    <th>Uang Masuk (Earning)</th>
                                                    <th>Uang Keluar (Withdrawal)</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                @php $no = 1; @endphp
                                                @foreach ($pendapatan as $date => $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>Rp {{ number_format($item['earning']) }}</td>
                                                        <td>
                                                            @if (!empty($item['withdrawals']))
                                                                @foreach ($item['withdrawals'] as $withdrawal)
                                                                    Rp {{ number_format($withdrawal['jumlah']) }}<br>
                                                                @endforeach
                                                            @else
                                                                Tidak ada withdrawal
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!empty($item['withdrawals']))
                                                                @foreach ($item['withdrawals'] as $withdrawal)
                                                                    {{ $withdrawal['status'] }}<br>
                                                                @endforeach
                                                            @else
                                                                Uang Masuk
                                                            @endif
                                                        </td>
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
@endpush
