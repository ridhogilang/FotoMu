<!DOCTYPE html>
<html lang="en" data-layout="horizontal" data-topbar-color="dark">

<head>
    <meta charset="utf-8" />
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <script src="{{ asset('js/head.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <br><br><br><br>
                    <div class="card bg-pattern">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="#" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('images/logo-dark.png') }}" alt=""
                                                height="22">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Reset Password</p>
                            </div>
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Enter your password" required>
                                        <div class="input-group-text" onclick="togglePassword('password')">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" placeholder="Confirm your password" required
                                            oninput="validatePasswords()">
                                        <div class="input-group-text" onclick="togglePassword('password_confirmation')">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit">Reset Password</button>
                                </div>
                            </form>

                        </div> 
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <footer class="footer footer-alt">
        <script>
            document.write(new Date().getFullYear())
        </script> &copy; Fotomu by Ridho
    </footer>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/pages/authentication.init.js') }}"></script>
    <script>
        // Display SweetAlert using Swal.fire() if toast_error exists in session
        @if (session('toast_error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('toast_error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
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
        const password = document.getElementById('password');
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
</body>

</html>
