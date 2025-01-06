@extends('layout.foto')

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
                            <img src="{{ asset('iconrobot/user/user2.png') }}" class="rounded-circle avatar-lg img-thumbnail"
                                alt="profile-image">

                            <h4 class="mb-0">{{ $getUser->fotografer->nama }}</h4>
                            <p class="text-muted">@fotografer</p>

                            <a href="{{ route('foto.upload') }}" class="btn btn-blue btn-xs waves-effect mb-2 waves-light">Unggah</a>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">About Me :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Halo, Saya adalah {{ $getUser->name }} dan saya adalah seorang fotografer handal bekerja secara lepas di website FotoMu.
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">{{ $getUser->name }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{ $getUser->nowa }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ms-2">{{ $getUser->email }}</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span
                                        class="ms-2">{{ $getUser->fotografer->alamat }}</span></p>
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
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Foto Unggahan
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
                                        Foto Unggahanmu</h5>

                                        <div class="photo-gallery">
                                            @foreach ($foto->take(10) as $fotoItem)  <!-- Membatasi hanya 10 foto -->
                                                <img src="{{ Storage::url($fotoItem->foto) }}" alt="Image {{ $loop->index + 1 }}">
                                            @endforeach
                                        </div>
                                        
                                        @if($foto->count() > 10)
                                            <div class="text-center mt-3">
                                                <a href="{{ route('foto.filemanager') }}" class="btn btn-primary">Lihat Selengkapnya</a> <!-- Tombol Lihat Selengkapnya -->
                                            </div>
                                        @endif                              

                                </div> 

                                <div class="tab-pane" id="settings">
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                            Personal Info</h5>
                                            <form action="{{ route('foto.update-personalinfo') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="name" name="name"
                                                                value="{{ $getUser->name }}" placeholder="Masukkan Nama Anda">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nowa" class="form-label">No. Whatsapp</label>
                                                            <input type="number" class="form-control" id="nowa" name="nowa"
                                                                value="{{ $getUser->nowa }}" placeholder="Masukkan Nomor Whatsapp">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
        
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email
                                                                Address</label> 
                                                            <input type="email" class="form-control" id="email" name="email"
                                                                placeholder="Enter email" value="{{ $getUser->email }}" disabled>
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

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i>
                                            Fotografer Info</h5>
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
                                                        <span class="input-group-text"><i
                                                                class="fab fa-twitter"></i></span>
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
                                                        <span class="input-group-text"><i
                                                                class="fab fa-instagram"></i></span>
                                                        <input type="text" class="form-control" id="social-insta"
                                                            placeholder="Url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-lin" class="form-label">Linkedin</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-linkedin"></i></span>
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
                                                        <span class="input-group-text"><i
                                                                class="fab fa-github"></i></span>
                                                        <input type="text" class="form-control" id="social-gh"
                                                            placeholder="Username">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light mt-2"><i
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
@endpush
