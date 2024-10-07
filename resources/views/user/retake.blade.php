@extends('layout.user')

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
                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a>
                                </li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Products</h4> --}}
                    </div>
                </div>
            </div><br><br><br><br>
            <!-- end page title -->
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between align-items-center">
                                <!-- Image on the left -->
                                <div class="col-auto">
                                    <img src="{{ asset('iconrobot/ROBOT LOOKING SOMETHING.png') }}" alt="Selfie"
                                        class="img-fluid" style="max-width: 50px;">
                                </div>
                                <!-- Text on the right -->
                                <div class="col">
                                    <h5>Halo {{$user->name}}, RoboMu mencari foto kamu berdasarkan selfie ini.</h5>
                                </div>
                            </div> <!-- end row -->
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col-->
            </div> <!-- end row -->
            <!-- end row-->

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card product-box">
                        <div class="card-body">

                            <div class="bg-light">
                                <img src="{{ Storage::url($user->foto_depan) }}" alt="product-pic" class="img-fluid" />
                            </div>

                            <div class="product-info">
                                <div class="row justify-content-center align-items-center">
                                    <h3 class="text-center">Original</h3>
                                </div> <!-- end row -->
                            </div> <!-- end product info-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card product-box">
                        <div class="card-body">
                            @if ($user->foto_kanan)
                                <div class="bg-light">
                                    <img src="{{ Storage::url($user->foto_kanan) }}" alt="product-pic" class="img-fluid" />
                                </div>
                            @else
                                <div class="bg-light">
                                    <img src="{{ asset('foto/tambah_foto.jpg') }}" alt="product-pic" class="img-fluid" />
                                </div>
                            @endif

                            <div class="product-info">
                                <div class="row align-items-center">
                                    <a href="{{ route('user.formfotokanan') }}"
                                        class="btn btn-primary waves-effect waves-light">Tambah Selfie</a>
                                </div> <!-- end row -->
                            </div> <!-- end product info-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
        </div> <!-- container -->

    </div> <!-- content -->
@endsection

@push('footer')
@endpush
