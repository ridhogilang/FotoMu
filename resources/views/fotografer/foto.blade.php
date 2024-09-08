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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
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
                                    <a href="{{ route('foto.filemanager') }}"
                                                class="btn btn-secondary waves-effect"><i
                                                    class="fe-arrow-left"></i>Kembali</a>
                                </div>
                                <div class="mail-list mt-3">
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-folder-outline font-18 align-middle me-2"></i>My
                                        Files</a>
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-google-drive font-18 align-middle me-2"></i>Google
                                        Drive</a>
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-dropbox font-18 align-middle me-2"></i>Dropbox</a>
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-share-variant font-18 align-middle me-2"></i>Share
                                        with me</a>
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-clock-outline font-18 align-middle me-2"></i>Recent</a>
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-star-outline font-18 align-middle me-2"></i>Starred</a>
                                    <a href="#" class="list-group-item border-0"><i
                                            class="mdi mdi-delete font-18 align-middle me-2"></i>Deleted
                                        Files</a>
                                </div>

                                <div class="mt-5">
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
                                    <h5 class="mb-2">Event - {{ $event }}</h5>

                                    <div class="row mx-n1 g-0">
                                        @foreach ($foto as $fotoItem)
                                        <div class="col" style="flex: 0 0 20%; max-width: 20%; padding: 0;">
                                            <div class="card m-1 shadow">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <img src="{{ Storage::url($fotoItem->foto) }}" alt="Foto" class="img-fluid rounded">
                                                    </div>
                                                </div> <!-- end row -->
                                            </div> <!-- end card -->
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="row" style="margin-right: 10px;">
                                <div class="col-12">
                                    {{ $foto->links('pagination::custom-pagination') }}
                                </div> <!-- end col-->
                            </div>
                        </div>
                    </div>
                </div> <!-- end card -->

            </div> <!-- end Col -->
        </div>

    </div> <!-- container -->

    </div>
@endsection

@push('footer')
@endpush
