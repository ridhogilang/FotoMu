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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pengguna</a></li>
                                <li class="breadcrumb-item active">Tambah Admin</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tambah Admin</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.store-pengguna') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" class="form-control" id="floatingInputName" placeholder="Nama Lengkap">
                                            <label for="floatingInputName">Nama</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" id="floatingInputEmail" placeholder="Email Anda">
                                            <label for="floatingInputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">+62</span>
                                            <input type="text" name="nowa" class="form-control" id="floatingInputWhatsapp"
                                                placeholder="Nomor WhatsApp">
                                            <label for="floatingInputWhatsapp" style="margin-left: 45px;">No. Whatsapp</label>
                                        </div>
                                    </div>
                            
                                    <!-- Kolom Kanan -->
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <div class="form-floating input-group input-group-merge mb-3">
                                                <input type="password" id="password" name="password" class="form-control"
                                                    placeholder="Enter your password">
                                                <div class="input-group-text" onclick="togglePassword('password', 'password-eye')">
                                                    <span class="password-eye" id="password-eye"></span>
                                                </div>
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <div class="form-floating input-group input-group-merge mb-3">
                                                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control"
                                                    placeholder="Confirm your password">
                                                <div class="input-group-text" onclick="togglePassword('confirmPassword', 'confirmPassword-eye')">
                                                    <span class="password-eye" id="confirmPassword-eye"></span>
                                                </div>
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="floatingSelect" name="role" aria-label="Floating label select example">
                                                <option value="" disabled selected>Pilih Role</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Fotografer">Fotografer</option>
                                                <option value="User">User</option>
                                            </select>
                                            <label for="floatingSelect">Pilih Role</label>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('footer')
    <script>
        // Fungsi untuk menghapus angka 0 pada awal nomor WhatsApp
        document.getElementById('floatingInputWhatsapp').addEventListener('input', function () {
            this.value = this.value.replace(/^0+/, ''); // Menghapus semua 0 di awal string
        });
    
        // Fungsi untuk toggle password dan confirm password
        function togglePassword(fieldId, eyeId) {
            const passwordField = document.getElementById(fieldId);
            const passwordEye = document.getElementById(eyeId);
    
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordEye.parentElement.classList.add('show-password');
            } else {
                passwordField.type = 'password';
                passwordEye.parentElement.classList.remove('show-password');
            }
        }
    </script>    
    @endpush
