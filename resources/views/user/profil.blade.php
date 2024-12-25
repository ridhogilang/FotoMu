@extends('layout.user')

@push('header')
    <style>
        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .photo-gallery img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Account</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title --> <!-- end page title -->

            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ asset('iconrobot/user/user1.png') }}" class="rounded-circle avatar-lg img-thumbnail"
                                alt="profile-image">

                            <h4 class="mb-0">{{ $user->name }}</h4>
                            <p class="text-muted">@php echo '@' . strtolower(str_replace(' ', '', $user->name)); @endphp</p>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">About Me :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Halo, Saya adalah {{ $user->name }} dan saya senang melihat hasil foto dari website
                                    FotoMu.
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span
                                        class="ms-2">{{ $user->name }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Whatsapp :</strong><span
                                        class="ms-2">{{ $user->nowa }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ms-2">{{ $user->email }}</span></p>

                            </div>

                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);"
                                        class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end col-->

                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Pesanan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#timeline" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        Favorit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Settings
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="aboutme">

                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                        Pesanan Anda</h5>

                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100"
                                            id="tickets-table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>Invoice</th>
                                                    <th>Total Harga</th>
                                                    <th>Catatan</th>
                                                    <th>Status</th>
                                                    <th class="hidden-sm">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($pesanan as $pesananItem)
                                                    <tr>
                                                        <td><b>{{ $loop->iteration }}</b></td>
                                                        <td>
                                                            #0000{{ $pesananItem->id }}
                                                        </td>

                                                        <td>{{ 'Rp. ' . number_format($pesananItem->totalharga, 0, ',', '.') }}
                                                        </td>


                                                        <td>
                                                            {{ $pesananItem->catatan }}
                                                        </td>

                                                        @if ($pesananItem->status == 'Selesai')
                                                            <td>
                                                                <span
                                                                    class="badge bg-success">{{ $pesananItem->status }}</span>
                                                            </td>
                                                        @elseif ($pesananItem->status == 'Menunggu Pembayaran')
                                                            <td>
                                                                <span
                                                                    class="badge bg-warning">{{ $pesananItem->status }}</span>
                                                            </td>
                                                        @elseif ($pesananItem->status == 'Dibatalkan')
                                                            <td>
                                                                <span
                                                                    class="badge bg-danger">{{ $pesananItem->status }}</span>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span
                                                                    class="badge bg-warning">{{ $pesananItem->status }}</span>
                                                            </td>
                                                        @endif

                                                        @switch($pesananItem->status)
                                                            @case('Diproses')
                                                                <td>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"><i
                                                                            class="mdi mdi-bank-transfer me-2 text-muted font-18 vertical-middle"></i>Bayar
                                                                        Sekarang</a>
                                                                </td>
                                                            @break

                                                            @case('Menunggu Pembayaran')
                                                                <td>
                                                                    <div class="btn-group dropdown">
                                                                        <a href="javascript: void(0);"
                                                                            class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm"
                                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                                class="mdi mdi-dots-horizontal"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"><i
                                                                                    class="mdi mdi-bank-transfer me-2 text-muted font-18 vertical-middle"></i>Bayar
                                                                                Sekarang</a>
                                                                            <a class="dropdown-item btn-cancel-order" href="#"
                                                                                data-order-id="{{ $pesananItem->id }}">
                                                                                <i
                                                                                    class="mdi mdi-cancel me-2 text-muted font-18 vertical-middle"></i>Batalkan
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @break

                                                            @case('Selesai')
                                                                <td>
                                                                    <a href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"
                                                                        class="action-icon">
                                                                        <i class="mdi mdi-file-document-outline"></i>
                                                                    </a>
                                                                </td>
                                                            @break

                                                            @case('Dibatalkan')
                                                                <td>
                                                                    <a href="{{ route('user.invoice', ['id' => Crypt::encryptString($pesananItem->id)]) }}"
                                                                        class="action-icon">
                                                                        <i class="mdi mdi-file-document-outline"></i>
                                                                    </a>
                                                                </td>
                                                            @break
                                                        @endswitch
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- end tab-pane -->
                                <!-- end about me section content -->

                                <div class="tab-pane" id="timeline">

                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                        Foto Favoritmu</h5>

                                    <div class="photo-gallery">
                                        @foreach ($foto as $fotoItem)
                                            <img src="{{ Storage::url($fotoItem->foto->foto) }}" alt="Image 1">
                                        @endforeach

                                    </div>

                                </div>
                                <!-- end timeline content-->

                                <div class="tab-pane" id="settings">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                        Personal Info</h5>
                                    <form action="{{ route('user.update-personalinfo') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ $user->name }}" placeholder="Enter first name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nowa" class="form-label">No. Whatsapp</label>
                                                    <input type="number" class="form-control" id="nowa" name="nowa"
                                                        value="{{ $user->nowa }}" placeholder="Enter last name">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email
                                                        Address</label>
                                                    <input type="email" class="form-control" id="useremail"
                                                        placeholder="Enter email" value="{{ $user->email }}" disabled>
                                                    <span class="form-text text-muted"><small>If you want to
                                                            change email please <a href="javascript: void(0);">click</a>
                                                            here.</small></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light mb-2"><i
                                                    class="mdi mdi-content-save"></i> Update Data</button>
                                        </div>
                                    </form>

                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                            class="mdi mdi-office-building me-1"></i> Keamanan</h5>
                                    <form method="POST" action="{{ route('user.pass-update') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="old_password" class="form-label">Password Lama</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="old_password" name="old_password"
                                                            class="form-control" placeholder="Enter your old password"
                                                            required>
                                                        <div class="input-group-text"
                                                            onclick="togglePassword('old_password')">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label">Password Baru</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="new_password" name="new_password"
                                                            class="form-control" placeholder="Enter your new password"
                                                            required>
                                                        <div class="input-group-text"
                                                            onclick="togglePassword('new_password')">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label">Konfirmasi
                                                        Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="password_confirmation"
                                                            name="new_password_confirmation" class="form-control"
                                                            placeholder="Confirm your password" required
                                                            oninput="validatePasswords()">
                                                        <div class="input-group-text"
                                                            onclick="togglePassword('password_confirmation')">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light mb-2"><i
                                                    class="mdi mdi-content-save"></i> Update Password</button>
                                        </div>
                                    </form>

                                    <!-- end row -->

                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i>
                                        Social</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="social-fb" class="form-label">Facebook</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fab fa-facebook-square"></i></span>
                                                    <input type="text" class="form-control" id="social-fb"
                                                        placeholder="Url">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="social-tw" class="form-label">Twitter</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                    <input type="text" class="form-control" id="social-tw"
                                                        placeholder="Username">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="social-insta" class="form-label">Instagram</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                                    <input type="text" class="form-control" id="social-insta"
                                                        placeholder="Url">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="social-lin" class="form-label">Linkedin</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                                    <input type="text" class="form-control" id="social-lin"
                                                        placeholder="Url">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="social-sky" class="form-label">Skype</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-skype"></i></span>
                                                    <input type="text" class="form-control" id="social-sky"
                                                        placeholder="@username">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="social-gh" class="form-label">Github</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-github"></i></span>
                                                    <input type="text" class="form-control" id="social-gh"
                                                        placeholder="Username">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i
                                                class="mdi mdi-content-save"></i> Update</button>
                                    </div>
                                </div>
                                <!-- end settings content-->

                            </div> <!-- end tab-content -->
                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/pages/tickets.js') }}"></script>
    <script>
        function togglePassword(id) {
            const passwordField = document.getElementById(id);
            const passwordEye = passwordField.nextElementSibling.querySelector('.password-eye');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordEye.parentElement.classList.add('show-password');
            } else {
                passwordField.type = 'password';
                passwordEye.parentElement.classList.remove('show-password');
            }
        }

        function validatePasswords() {
            const password = document.getElementById('new_password');
            const confirmPassword = document.getElementById('password_confirmation');

            if (confirmPassword.value === '') {
                confirmPassword.style.borderColor = '';
                return;
            }

            if (password.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = 'red';
            } else {
                confirmPassword.style.borderColor = 'green';
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delegasikan event untuk menangkap klik tombol pembatalan
            document.body.addEventListener('click', function(e) {
                if (e.target.closest('.btn-cancel-order')) { // Tangkap elemen dengan class btn-cancel-order
                    e.preventDefault();

                    const button = e.target.closest('.btn-cancel-order'); // Elemen tombol yang diklik
                    const orderId = button.getAttribute('data-order-id'); // Ambil data-order-id

                    // Tampilkan SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Pesanan akan dibatalkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, batalkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim request pembatalan
                            fetch(`/pelanggan/pesanan/dibatalkan/${orderId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Dibatalkan!',
                                            'Pesanan berhasil dibatalkan.',
                                            'success'
                                        );
                                        // Reload halaman atau lakukan tindakan lain
                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            data.message || 'Gagal membatalkan pesanan.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Terjadi Kesalahan!',
                                        'Tidak dapat membatalkan pesanan.',
                                        'error'
                                    );
                                    console.error('Error:', error);
                                });
                        }
                    });
                }
            });
        });
    </script>
@endpush
