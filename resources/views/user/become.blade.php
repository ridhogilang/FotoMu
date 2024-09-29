@extends('layout.user')

@push('header')
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                <li class="breadcrumb-item active">Become Fotografer</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Become Fotografer</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Lengkapi Data Dari Anda</h4><br>
                            <div class="alert alert-warning d-none fade show">
                                <h4 class="mt-0 text-warning">Oh snap!</h4>
                                <p class="mb-0">This form seems to be invalid :(</p>
                            </div>

                            <div class="alert alert-info d-none fade show">
                                <h4 class="mt-0 text-info">Yay!</h4>
                                <p class="mb-0">Everything seems to be ok :)</p>
                            </div>

                            <form method="POST" action="{{ route('user.upgrade-store') }}" id="demo-form" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Full Name * :</label>
                                    <input type="text" class="form-control" name="nama" id="nama" required="">
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat * :</label>
                                    <textarea id="alamat" class="form-control" name="alamat" data-parsley-trigger="keyup" data-parsley-minlength="10"
                                        data-parsley-maxlength="200" data-parsley-minlength-message="Masukkan Alamat anda" required></textarea>
                                </div>


                                <div class="mb-3">
                                    <label for="nowa" class="form-label">No. Whatsapp * :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="nowa-prefix">62</span> <!-- Changed ID -->
                                        <input data-parsley-type="number" type="text" class="form-control" name="nowa"
                                            id="nowa" required="">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nowa" class="form-label">Foto KTP * :</label>
                                    <div class="col-lg-12">
                                        <div>
                                            <input type="file" data-plugins="dropify" data-max-file-size="10M"
                                                name="foto_ktp" required="" />
                                            <p class="text-muted text-center mt-2 mb-0">Max File size</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="pesan" class="form-label">Message (20 chars min, 100 max) :</label>
                                    <textarea id="pesan" class="form-control" name="pesan" data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."
                                        data-parsley-validation-threshold="1">
                                </textarea> <!-- Closing tag is added here -->

                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card" style="background-color: #6658DC; border-radius: 15px; color: white;">
                        <div class="card-body">
                            <!-- Flexbox container to align robot and title side by side -->
                            <div class="d-flex align-items-center">
                                <!-- Robot image on the left -->
                                <div>
                                    <img src="{{ asset('iconrobot/ROBOT LOOKING SOMETHING.png') }}" alt="Robot"
                                        style="width: 180px; height: auto;">
                                </div>

                                <!-- Header title on the right -->
                                <div class="ms-3"> <!-- Adds margin between the image and the text -->
                                    <h4 class="fw-bold mb-3 text-white">Keuntungan menjadi Fotografer FotoMu</h4>
                                </div>
                            </div>
                            <br>

                            <ul>
                                <li><strong>Peluang Penghasilan Tambahan:</strong> Dapatkan bayaran dari setiap foto yang
                                    diambil dan diunggah di platform FotoMu.</li>
                                <li><strong>Promosi Gratis:</strong> Sebagai fotografer, Anda akan mendapatkan promosi
                                    gratis di platform kami, yang akan meningkatkan eksposur Anda.</li>
                                <li><strong>Komunitas Kreatif:</strong> Bergabung dengan komunitas fotografer yang aktif dan
                                    saling berbagi tips dan trik fotografi.</li>
                                <li><strong>Fleksibilitas Waktu:</strong> Atur sendiri jadwal pemotretan Anda sesuai dengan
                                    waktu yang Anda miliki.</li>
                                <li><strong>Beragam Proyek Fotografi:</strong> Dapatkan kesempatan untuk terlibat dalam
                                    proyek-proyek foto unik dan menarik dari klien platform kami.</li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- container -->

    </div>
@endsection

@push('footer')
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-fileuploads.init.js') }}"></script>
    <script>
        // Listen for form submission
        document.getElementById('demo-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Validate using Parsley.js
            var form = $(this);

            // Check if the form is valid
            if (form.parsley().isValid()) {
                // If the form is valid, submit it
                this.submit();
            } else {
                // If validation fails, show an error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill all required fields correctly.',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
@endpush
