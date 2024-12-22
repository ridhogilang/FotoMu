@extends('layout.foto')

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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fotografer</a></li>
                                <li class="breadcrumb-item active">File Manager</li>
                            </ol>
                        </div>
                        <h4 class="page-title">File Manager</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">

                <!-- Right Sidebar -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Left sidebar -->
                            <div class="inbox-leftbar">
                                <div class="btn-group d-block mb-2">
                                    <button type="button"
                                        class="btn btn-success w-100 waves-effect waves-light dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="mdi mdi-plus"></i>Upload Tree</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('foto.upload') }}"><i
                                                class="mdi mdi-folder-plus-outline me-1"></i> Tambah Foto</a>
                                        <a class="dropdown-item" href="{{ route('foto.tambahtree') }}"><i
                                                class="mdi mdi-file-plus-outline me-1"></i> Tambah Event</a>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4><span class="badge rounded-pill p-1 px-2 badge-soft-secondary">FREE</span>
                                    </h4>
                                    <h6 class="text-uppercase mt-3">Storage</h6>
                                    <div class="progress my-2 progress-sm">
                                        <div class="progress-bar progress-lg bg-success" role="progressbar"
                                            style="width: {{ number_format($percentageUsed, 2) }}%"
                                            aria-valuenow="{{ number_format($percentageUsed, 2) }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <p>{{ $totalStorageFormatted }} ({{ number_format($percentageUsed, 2) }}%) of
                                        {{ $maxStorageFormatted }} used</p>
                                </div>

                            </div>
                            <!-- End Left sidebar -->

                            <div class="inbox-rightbar">
                                <div class="d-md-flex justify-content-between align-items-center">
                                    <form class="search-bar" method="GET" action="{{ route('foto.filemanager') }}">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control form-control-light"
                                                placeholder="Search files..." value="{{ request('search') }}">
                                            <!-- Isi dengan nilai pencarian jika ada -->
                                            <span class="mdi mdi-magnify"></span>
                                        </div>
                                    </form>
                                    <div class="mt-2 mt-md-0">
                                        <button type="submit" class="btn btn-sm btn-white"><i
                                                class="mdi mdi-format-list-bulleted"></i></button>
                                        <button type="submit" class="btn btn-sm btn-white"><i
                                                class="mdi mdi-view-grid"></i></button>
                                        <button type="submit" class="btn btn-sm btn-white"><i
                                                class="mdi mdi-information-outline"></i></button>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h5 class="mb-2">Event FotoMu</h5>

                                    <div class="row mx-n1 g-0">
                                        @foreach ($event as $eventItem)
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card m-1 shadow-none border"
                                                    onclick="window.location='{{ route('foto.foto', ['id' => Crypt::encryptString($eventItem->id)]) }}';"
                                                    style="cursor: pointer;">
                                                    <div class="p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto pe-0">
                                                                <div class="avatar-sm">
                                                                    <span
                                                                        class="avatar-title bg-light text-secondary rounded">
                                                                        <i class="mdi mdi-folder-account font-18"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <!-- Teks link tetap untuk keperluan SEO atau aksesibilitas -->
                                                                <a href="{{ route('foto.foto', ['id' => Crypt::encryptString($eventItem->id)]) }}"
                                                                    class="text-muted fw-bold">
                                                                    {{ $eventItem->event }}
                                                                </a>
                                                                <p class="mb-0 font-13">
                                                                    {{ $eventItem->total_storage_formatted }}</p>
                                                            </div>
                                                        </div> <!-- end row -->
                                                    </div> <!-- end .p-2-->
                                                </div> <!-- end col -->
                                            </div>
                                        @endforeach
                                    </div> <!-- end row-->
                                </div> <!-- end .mt-3-->

                            </div>
                            <!-- end inbox-rightbar-->

                            <div class="clearfix"></div>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end Col -->
            </div><!-- End row -->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
@endpush
