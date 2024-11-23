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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fotografer</a></li>
                                <li class="breadcrumb-item active">Pembayaran List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pembayaran</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Pembayaran</h4>

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
                                            <th>Status</th>
                                            <th>Sisa Saldo</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th class="hidden-sm">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($pembayaran as $pembayaranItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>{{ $pembayaranItem->fotografer->nama }}</td>
                                                @if ($pembayaranItem->rekening_id)
                                                <td>{{ $pembayaranItem->rekening->nama_bank }} -
                                                    {{ $pembayaranItem->rekening->rekening }}
                                                    ({{ $pembayaranItem->rekening->nama }})
                                                </td>
                                                @else
                                                    <td>Belum menambahkan rekening</td>
                                                @endif
                                                <td>{{ 'Rp. ' . number_format($pembayaranItem->jumlah, 0, ',', '.') }}</td>
                                                <td>{{ 'Rp. ' . number_format($pembayaranItem->saldo, 0, ',', '.') }}</td>
                                                <td>{{ $pembayaranItem->created_at->format('d M Y') }}</td>
                                                @if ($pembayaranItem->status == 'Pending')
                                                    <td><span
                                                            class="badge label-table bg-warning">{{ $pembayaranItem->status }}</span>
                                                    </td>
                                                @elseif ($pembayaranItem->status == 'Approved')
                                                    <td><span
                                                            class="badge label-table bg-success">{{ $pembayaranItem->status }}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge label-table bg-danger">{{ $pembayaranItem->status }}</span>
                                                    </td>
                                                @endif
                                                @if ($pembayaranItem->status == 'Pending')
                                                    <td>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#edit-modal-{{ $pembayaranItem->id }}"
                                                             class="action-icon"
                                                            data-id="{{ $pembayaranItem->id }}">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#view-modal-{{ $pembayaranItem->id }}"
                                                             class="action-icon"
                                                            data-id="{{ $pembayaranItem->id }}">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                    </td>
                                                @endif

                                            </tr>

                                            <!-- Modal untuk setiap event -->
                                            <div id="edit-modal-{{ $pembayaranItem->id }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title">Review Pembayaran</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.proses-pembayaran', $pembayaranItem->id) }}"
                                                                method="POST" id="demo-form" enctype="multipart/form-data"
                                                                class="px-3">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label">Nama
                                                                        Fotografer</label>
                                                                    <input class="form-control" name="nama"
                                                                        type="text"
                                                                        value="{{ $pembayaranItem->fotografer->nama }}"
                                                                        required="" readonly
                                                                        style="border: none; background-color: transparent;">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="rekening" class="form-label">Detail
                                                                        Rekening</label>
                                                                    <input class="form-control" name="rekening"
                                                                        type="text"
                                                                        value="{{ $pembayaranItem->rekening->nama_bank }} - {{ $pembayaranItem->rekening->rekening }} ({{ $pembayaranItem->rekening->nama }})"
                                                                        required="" readonly
                                                                        style="border: none; background-color: transparent;">
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6">
                                                                        <label for="jumlah" class="form-label">Jumlah
                                                                            Penarikan</label>
                                                                        <input class="form-control" name="jumlah"
                                                                            type="text"
                                                                            value="{{ 'Rp. ' . number_format($pembayaranItem->jumlah, 0, ',', '.') }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="saldo" class="form-label">Sisa
                                                                            Saldo</label>
                                                                        <input class="form-control" name="saldo"
                                                                            type="text"
                                                                            value="{{ 'Rp. ' . number_format($pembayaranItem->saldo, 0, ',', '.') }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-control select2" name="status"
                                                                        id="event">
                                                                        <option>Pilih Status</option>
                                                                        <option value="Pending"
                                                                            @selected($pembayaranItem->status === 'Pending')>Pending</option>
                                                                        <option value="Approved"
                                                                            @selected($pembayaranItem->status === 'Approved')>Approved</option>
                                                                        <option value="Rejected"
                                                                            @selected($pembayaranItem->status === 'Rejected')>Rejected</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="bukti_foto" class="form-label">Foto Bukti
                                                                        Transfer :</label>
                                                                    <div class="col-lg-12">
                                                                        <div>
                                                                            <input type="file" name="bukti_foto"
                                                                                class="form-control"
                                                                                accept=".jpg, .jpeg, .png">
                                                                        </div>
                                                                    </div>
                                                                    <div id="preview-container" class="mt-3">
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Pesan <span
                                                                        class="text-danger">*</span></label>
                                                                    <textarea class="form-control" name="pesan" rows="3"></textarea>
                                                                </div>
                                                                <div class="mb-2 text-center">
                                                                    <button class="btn rounded-pill btn-primary"
                                                                        type="submit">Proses Pembayaran</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="view-modal-{{ $pembayaranItem->id }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title">Status Pembayaran</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label">Nama
                                                                        Fotografer</label>
                                                                    <input class="form-control" name="nama"
                                                                        type="text"
                                                                        value="{{ $pembayaranItem->fotografer->nama }}"
                                                                        required="" readonly
                                                                        style="border: none; background-color: transparent;">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="rekening" class="form-label">Detail
                                                                        Rekening</label>
                                                                    <input class="form-control" name="rekening"
                                                                        type="text"
                                                                        value="{{ $pembayaranItem->rekening->nama_bank }} - {{ $pembayaranItem->rekening->rekening }} ({{ $pembayaranItem->rekening->nama }})"
                                                                        required="" readonly
                                                                        style="border: none; background-color: transparent;">
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6">
                                                                        <label for="jumlah" class="form-label">Jumlah
                                                                            Penarikan</label>
                                                                        <input class="form-control" name="jumlah"
                                                                            type="text"
                                                                            value="{{ 'Rp. ' . number_format($pembayaranItem->jumlah, 0, ',', '.') }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="saldo" class="form-label">Sisa
                                                                            Saldo</label>
                                                                        <input class="form-control" name="saldo"
                                                                            type="text"
                                                                            value="{{ 'Rp. ' . number_format($pembayaranItem->saldo, 0, ',', '.') }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6"> <label for="status"
                                                                            class="form-label">Status</label>
                                                                        <input class="form-control" name="status"
                                                                            type="text"
                                                                            value="{{ $pembayaranItem->status }}" required
                                                                            readonly
                                                                            style="border: none; background-color: transparent; 
                                                                           color: 
                                                                           @if ($pembayaranItem->status == 'Pending') orange 
                                                                           @elseif ($pembayaranItem->status == 'Approved') green 
                                                                           @else red @endif;">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="saldo" class="form-label">Processed
                                                                            at</label>
                                                                            <input class="form-control" name="saldo"
                                                                            type="text"
                                                                            value="{{ \Carbon\Carbon::parse($pembayaranItem->processed_at)->format('d M Y H:i') }}"
                                                                            required readonly
                                                                            style="border: none; background-color: transparent;">                                                                     
                                                                    </div>
                                                                </div>

                                                                @if ($pembayaranItem->status != 'Rejected')
                                                                    <div class="mb-3">
                                                                        <label for="bukti_foto" class="form-label">Foto
                                                                            Bukti
                                                                            Transfer :</label>
                                                                        <div class="col-lg-12">
                                                                            <div>
                                                                                <img src="{{ Storage::url($pembayaranItem->bukti_foto) }}"
                                                                                    alt="image"
                                                                                    class="img-fluid rounded"
                                                                                    width="200" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label">Pesan</label>
                                                                    <input class="form-control" name="nama"
                                                                        type="text"
                                                                        value="{{ $pembayaranItem->pesan }}"
                                                                        required="" readonly
                                                                        style="border: none; background-color: transparent;">
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
