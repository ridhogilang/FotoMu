@extends('layout.admin')

@push('header')
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tickets</a></li>
                                <li class="breadcrumb-item active">Ticket List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Event</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Event Aktif</h4>

                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100"
                                    id="tickets-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>Nama</th>
                                            <th>No. Whatsapp</th>
                                            <th>Pesan</th>
                                            <th class="hidden-sm">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($daftar as $daftarItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>{{ $daftarItem->nama }}</td>
                                                <td>{{ $daftarItem->nowa }}</td>
                                                <td>{{ $daftarItem->pesan }}</td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit-modal-{{ $daftarItem->id }}"
                                                        class="btn btn-xs btn-light edit-event-btn"
                                                        data-id="{{ $daftarItem->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal untuk setiap event -->
                                            <div id="edit-modal-{{ $daftarItem->id }}" class="modal fade" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title">Edit Event</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.event-update', $daftarItem->id) }}"
                                                                method="POST" class="px-3">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="event" class="form-label">Nama
                                                                        Event</label>
                                                                    <input class="form-control" name="event"
                                                                        type="text" value="{{ $daftarItem->event }}"
                                                                        required="">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tanggal" class="form-label">Date</label>
                                                                    <input class="form-control" id="tanggal"
                                                                        name="tanggal" type="date"
                                                                        value="{{ \Carbon\Carbon::parse($daftarItem->tanggal)->format('Y-m-d') }}">

                                                                </div>
                                                                <div class="mb-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_private" value="0"
                                                                        id="customradio-public-{{ $daftarItem->id }}"
                                                                        {{ $daftarItem->is_private == 0 ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="customradio-public-{{ $daftarItem->id }}">Public</label>

                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_private" value="1"
                                                                        id="customradio-private-{{ $daftarItem->id }}"
                                                                        {{ $daftarItem->is_private == 1 ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="customradio-private-{{ $daftarItem->id }}">Private</label>
                                                                </div>

                                                                <div class="mb-3"
                                                                    id="password-section-{{ $daftarItem->id }}"
                                                                    style="{{ $daftarItem->is_private == 0 ? 'display: none;' : '' }}">
                                                                    <label for="password"
                                                                        class="form-label">Password</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input type="password" id="password"
                                                                            class="form-control"
                                                                            placeholder="Enter your password"
                                                                            name="password">
                                                                        <div class="input-group-text" data-password="false">
                                                                            <span class="password-eye"
                                                                                onclick="togglePassword()"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Deskripsi</label>
                                                                    <textarea class="form-control" name="deskripsi" rows="3">{{ $daftarItem->deskripsi }}</textarea>
                                                                </div>

                                                                <!-- Map container with unique ID for each event -->
                                                                <div id="map-{{ $daftarItem->id }}"
                                                                    style="height: 300px;"></div>
                                                                <input type="hidden" name="lokasi"
                                                                    id="lokasi-{{ $daftarItem->id }}"
                                                                    value="{{ $daftarItem->lokasi }}">
                                                                <div class="mb-2 text-center">
                                                                    <button class="btn rounded-pill btn-primary"
                                                                        type="submit">Update Event</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/pages/tickets.js') }}"></script>
@endpush
