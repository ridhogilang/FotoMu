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
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pemesanan</a></li>
                                <li class="breadcrumb-item active">Download List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Download FotoMu</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($pesanan as $tanggal => $items)
                                <h5>{{ $tanggal }}</h5>
                                @foreach ($items as $item)
                                <div class="card mb-1 shadow-none border">
                                    <div class="p-2">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title badge-soft-primary text-primary rounded">
                                                        <img src="{{ Storage::url($item->foto->foto) }}" alt="JPG" class="img-fluid" style="max-width: 100%;">
                                                    </span>
                                                </div>                                                
                                            </div>
                                            <div class="col ps-0">
                                                <a href="{{ Storage::url($item->foto->foto) }}"
                                                    class="text-muted fw-bold" download>{{ $item->foto->event->event }}_{{ $item->id }}.jpg</a>
                                                <p class="mb-0 font-12">{{ number_format($item->foto->file_size / 1048576, 2) }} MB</p>
                                            </div>
                                            <div class="col-auto">
                                                <!-- Button -->
                                                <a href="{{ Storage::url($item->foto->foto) }}" class="btn btn-link font-16 text-muted" download>
                                                    <i class="dripicons-download"></i>
                                                </a>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endforeach

                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
@endpush
