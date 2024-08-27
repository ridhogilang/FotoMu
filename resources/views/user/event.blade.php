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
                        @foreach ($similarPhotos as $similar)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-box">
                                <div class="card-body">
                                    <div class="bg-light">
                                        <img src="{{ Storage::url($similar->fotowatermark) }}" alt="product-pic"
                                            class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                        class="text-dark"><i class="fas fa-map-marker-alt"></i> {{ $similar->event->event }}</a></h5>
                                                <h5 class="m-0"> <span class="text-muted"> Fotografer : {{ $similar->user->name }}</span>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    {{ number_format($similar->harga / 1000, 0, ',', '.') . 'K' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mt-3">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <button class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-close-circle"></i></button>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">Beli Sekarang</button>
                                                        <button type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-cart"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                        @foreach ($semuaFoto as $FotoAll)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card product-box">
                                    <div class="card-body">
                                        <div class="bg-light">
                                            <img src="{{ Storage::url($FotoAll->fotowatermark) }}" alt="product-pic"
                                                class="img-fluid" />
                                        </div>

                                        <div class="product-info">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html"
                                                            class="text-dark"><i class="fas fa-map-marker-alt"></i> {{ $FotoAll->event->event }}</a></h5>
                                                    <h5 class="m-0"> <span class="text-muted"> Fotografer : {{ $FotoAll->user->name }}</span>
                                                    </h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="product-price-tag">
                                                        {{ number_format($FotoAll->harga / 1000, 0, ',', '.') . 'K' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <button class="btn btn-outline-danger waves-effect waves-light"><i class="mdi mdi-heart-outline"></i></button>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-outline-info rounded-pill waves-effect waves-light me-2">Beli Sekarang</button>
                                                            <button type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-cart"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
