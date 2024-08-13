@extends('layout.user')

@push('header')
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
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Products</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex align-self-center me-3 rounded-circle" src="{{ asset('images/companies/amazon.png') }}" alt="Generic placeholder image" height="64">
                                        <div class="w-100 ms-3">
                                            <h4 class="mt-0 mb-2 font-16">{{ $event->event }}</h4>
                                            <p class="mb-1"><b>Jumlah :</b> {{ $event->foto_count }} Foto</p>
                                            <p class="mb-0"><b>Tanggal :</b> {{ \Carbon\Carbon::parse($event->created_at)->translatedFormat('d F Y') }} </p>
                                        </div>
                                        <div class="w-100 ms-2">
                                            <p class="mb-1"><b>Deskripsi:</b>  {{ $event->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <div class="text-lg-end my-1 my-lg-0">
                                        <button type="button" class="btn btn-success waves-effect waves-light me-1">
                                            <i class="mdi mdi-cog"></i>
                                        </button>
                                        <a href="ecommerce-product-edit.html" class="btn btn-danger waves-effect waves-light">
                                            <i class="mdi mdi-map-marker me-1"></i> Lihat Lokasi
                                        </a>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <ul class="nav nav-tabs nav-bordered nav-justified mb-2">
                                    <li class="nav-item">
                                        <a href="#home-b2" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                            FotoMu
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#profile-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Galeri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#messages-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            Messages
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="home-b2">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-1.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Jones
                                                        Men's T-shirt (Blue)</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 98 pcs</span>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $39
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-2.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Brown
                                                        Hoodie for men</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 23 pcs</span>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $98
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-3.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Designer
                                                        Awesome T-Shirt</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 235
                                                        pcs</span></h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $49
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>
                                    <div class="bg-light">
                                        <img src="assets/images/products/product-4.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Jones
                                                        Awesome T-Shirt</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 385
                                                        pcs</span></h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $29
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-5.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Green
                                                        Hoodie for men</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 25 pcs</span>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $49
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-6.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Blue
                                                        Awesome T-Shirt</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 39 pcs</span>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $19
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-7.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Jones
                                                        Men's T-shirt (Green)</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 36 pcs</span>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $99
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="product-action">
                                        <a href="javascript: void(0);"
                                            class="btn btn-success btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-danger btn-xs waves-effect waves-light"><i
                                                class="mdi mdi-close"></i></a>
                                    </div>

                                    <div class="bg-light">
                                        <img src="assets/images/products/product-8.png" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark">Red
                                                        Hoodie for men</a> </h5>
                                                <div class="text-warning mb-2 font-13">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <h5 class="m-0"> <span class="text-muted"> Stocks : 128
                                                        pcs</span></h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    $29
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul class="pagination pagination-rounded justify-content-end mb-3">
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- end col-->
                    </div>
                </div>
                <div class="tab-pane" id="profile-b2">
                    <div class="row">
                        {{-- @foreach ($event as $eventItem)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card product-box">
                                    <div class="card-body">
                                        <div class="bg-light">
                                            <img src="{{ asset('images/products/product-1.png') }}" alt="product-pic"
                                                class="img-fluid" />
                                        </div>

                                        <div class="product-info">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="font-16 mt-0 sp-line-1"><a
                                                            href="{{ route('user.event', ['id' => $eventItem->id]) }}"
                                                            class="text-dark">{{ $eventItem->event }}</a></h5>
                                                    <div class="text-warning mb-2 font-13">
                                                        <p>{{ $eventItem->deskripsi }}</p>
                                                    </div>
                                                    <h5 class="m-0"> <span class="text-muted"> Jumlah :
                                                            {{ $eventItem->foto_count }} Foto</span>
                                                    </h5>
                                                </div>
                                                <div class="col-auto">
                                                    <svg height="30" viewBox="0 0 64 64" width="30"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g id="camera_shop-video_camera-location-pin-map"
                                                            data-name="camera shop-video camera-location-pin-map">
                                                            <ellipse cx="32" cy="57" fill="#ebe5dd"
                                                                rx="10" ry="4" />
                                                            <path
                                                                d="m42 57c0 2.21-4.48 4-10 4-.68 0-1.35-.03-1.99-.08 4.56-.37 7.99-1.99 7.99-3.92s-3.43-3.55-7.99-3.92c.64-.05 1.31-.08 1.99-.08 5.52 0 10 1.79 10 4z"
                                                                fill="#c0ab91" />
                                                            <path
                                                                d="m52 23c0 10.94-10.64 24.01-16.4 30.28-2.14 2.33-3.6 3.72-3.6 3.72s-1.46-1.39-3.6-3.72c-5.76-6.27-16.4-19.34-16.4-30.28a20 20 0 0 1 40 0z"
                                                                fill="#fd7777" />
                                                            <path
                                                                d="m52 23c0 10.94-10.64 24.01-16.4 30.28-2.14 2.33-3.6 3.72-3.6 3.72s-.76-.73-2-2.01c.46-.49 1.01-1.07 1.6-1.71 5.76-6.27 16.4-19.34 16.4-30.28a20 20 0 0 0 -18-19.9 18.862 18.862 0 0 1 2-.1 19.994 19.994 0 0 1 20 20z"
                                                                fill="#ff3051" />
                                                            <circle cx="32" cy="23" fill="#fee9ab"
                                                                r="16" />
                                                            <path
                                                                d="m48 23a16 16 0 0 1 -16 16 16.524 16.524 0 0 1 -2-.12 16 16 0 0 0 0-31.75 14.713 14.713 0 0 1 2-.13 16 16 0 0 1 16 16z"
                                                                fill="#ffde55" />
                                                            <path d="m22 17h20v12h-20z" fill="#a78966" />
                                                            <circle cx="32" cy="23" fill="#898890" r="6" />
                                                            <path
                                                                d="m38 23a6 6 0 0 1 -6 6 5.8 5.8 0 0 1 -2-.35 5.99 5.99 0 0 0 0-11.3 5.8 5.8 0 0 1 2-.35 6 6 0 0 1 6 6z"
                                                                fill="#57565c" />
                                                            <path d="m29 13h6v4h-6z" fill="#c6c5ca" />
                                                            <circle cx="32" cy="23" fill="#ff3051" r="2" />
                                                            <path
                                                                d="m34 23a2 2 0 0 1 -3 1.73 2 2 0 0 0 0-3.46 2 2 0 0 1 3 1.73z"
                                                                fill="#cd2a00" />
                                                            <path d="m32 13h3v4h-3z" fill="#898890" />
                                                            <path d="m38 17h4v12h-4z" fill="#806749" />
                                                            <path
                                                                d="m32 6a17 17 0 1 0 17 17 17.024 17.024 0 0 0 -17-17zm0 32a15 15 0 1 1 15-15 15.018 15.018 0 0 1 -15 15z" />
                                                            <path
                                                                d="m37.54 52.65c6.02-6.75 15.46-19.03 15.46-29.65a21 21 0 0 0 -42 0c0 10.62 9.44 22.9 15.46 29.65-3.41.84-5.46 2.44-5.46 4.35 0 3.25 5.67 5 11 5s11-1.75 11-5c0-1.91-2.05-3.51-5.46-4.35zm-24.54-29.65a19 19 0 0 1 38 0c0 12.84-15.51 29.1-19 32.6-3.49-3.5-19-19.76-19-32.6zm19 37c-5.49 0-9-1.78-9-3 0-.74 1.58-2.01 5.03-2.63 1.81 1.94 3.08 3.17 3.28 3.35a.99.99 0 0 0 1.38 0c.2-.18 1.47-1.41 3.28-3.35 3.45.62 5.03 1.89 5.03 2.63 0 1.22-3.51 3-9 3z" />
                                                            <path
                                                                d="m35.73 48.65c-.99 1.15-2 2.28-3 3.34a1.007 1.007 0 0 1 -.73.32 1.024 1.024 0 0 1 -.73-.32c-1-1.07-2.01-2.2-2.99-3.34l1.52-1.3c.4.46.8.9 1.2 1.35v-2.7h2v2.71c.4-.45.81-.9 1.21-1.36z" />
                                                            <path
                                                                d="m42 16h-1v-2h-2v2h-3v-3a1 1 0 0 0 -1-1h-6a1 1 0 0 0 -1 1v3h-3v-2h-2v2h-1a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1v-12a1 1 0 0 0 -1-1zm-12-2h4v2h-4zm-7 14v-10h4.11a6.979 6.979 0 0 0 0 10zm9 0a5 5 0 1 1 5-5 5 5 0 0 1 -5 5zm9 0h-4.11a6.979 6.979 0 0 0 0-10h4.11z" />
                                                            <path d="m31 42h2v2h-2z" />
                                                            <path
                                                                d="m32 20a3 3 0 1 0 3 3 3 3 0 0 0 -3-3zm0 4a1 1 0 1 1 1-1 1 1 0 0 1 -1 1z" />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div> <!-- end row -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul class="pagination pagination-rounded justify-content-end mb-3">
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- end col-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
@endpush
