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
                                <li class="breadcrumb-item active">Pendaftaran List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pendaftaran</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Pendaftaran Fotografer</h4>

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
                                                <td class="d-flex justify-content-start align-items-center gap-1">
                                                    <!-- Tombol Edit -->
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit-modal-{{ $daftarItem->id }}"
                                                        class="btn btn-xs btn-light edit-event-btn"
                                                        data-id="{{ $daftarItem->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('admin.reject-foto', $daftarItem->id) }}"
                                                        method="POST" class="m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <button id="reject-btn-{{ $daftarItem->id }}"
                                                            class="btn btn-xs btn-danger reject-event-btn-fotografer"
                                                            data-id="{{ $daftarItem->id }}">
                                                            <i class="mdi mdi-close"></i>
                                                        </button>
                                                    </form>
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
                                                                action="{{ route('admin.validasi-foto', $daftarItem->id) }}"
                                                                method="POST" class="px-3">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="nama-{{ $daftarItem->id }}"
                                                                        class="form-label">Full Name * :</label>
                                                                    <input type="text" class="form-control"
                                                                        name="nama" id="nama-{{ $daftarItem->id }}"
                                                                        value="{{ $daftarItem->nama }}" required="">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="alamat-{{ $daftarItem->id }}"
                                                                        class="form-label">Full Name * :</label>
                                                                    <input type="text" class="form-control"
                                                                        name="alamat" id="alamat-{{ $daftarItem->id }}"
                                                                        value="{{ $daftarItem->alamat }}" required="">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="nowa-{{ $daftarItem->id }}"
                                                                        class="form-label">No. Whatsapp * :</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"
                                                                            id="nowa-prefix">62</span>
                                                                        <input data-parsley-type="number" type="text"
                                                                            class="form-control" name="nowa"
                                                                            id="nowa-{{ $daftarItem->id }}"
                                                                            value="{{ $daftarItem->nowa }}" required="">
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="pesan-{{ $daftarItem->id }}"
                                                                        class="form-label">Message (20 chars min, 100 max)
                                                                        :</label>
                                                                    <textarea id="pesan-{{ $daftarItem->id }}" class="form-control" name="pesan" data-parsley-trigger="keyup"
                                                                        data-parsley-minlength="20" data-parsley-maxlength="100"
                                                                        data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.." required>{{ $daftarItem->pesan }}</textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="foto_ktp-{{ $daftarItem->id }}"
                                                                        class="form-label">Foto KTP * :</label>
                                                                    <div class="col-lg-12">
                                                                        <img src="{{ Storage::url($daftarItem->foto_ktp) }}"
                                                                            alt="Foto KTP" class="img-fluid" />
                                                                    </div>
                                                                </div>

                                                                <div class="mb-2 text-center">
                                                                    <button class="btn rounded-pill btn-primary"
                                                                        type="submit">Setujui</button>
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
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delegasikan event untuk menangkap klik tombol pembatalan
            document.body.addEventListener('click', function(e) {
                if (e.target.closest(
                        '.reject-event-btn-fotografer'
                        )) { // Tangkap elemen dengan class reject-event-btn-fotografer
                    e.preventDefault();

                    const button = e.target.closest(
                        '.reject-event-btn-fotografer'); // Elemen tombol yang diklik
                    const dataId = button.getAttribute('data-id'); // Ambil data-order-id

                    // Tampilkan SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Apakah Anda yakin, ingin menolak fotografer ini?',
                        text: "Anda tidak akan bisa mengembalikan aksi ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, batalkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/reject-fotografer/${dataId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Berhasil!',
                                            'Fotografer sudah di tolak',
                                            'success'
                                        );
                                        // Reload halaman atau lakukan tindakan lain
                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            data.message || 'Gagal Menolak Fotografer.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Terjadi Kesalahan!',
                                        'Tidak dapat menolak fotografer.',
                                        'error'
                                    );
                                    console.error('Error:', error);
                                });
                                

                        }
                    });
                }
            });
        });
    </script> --}}
@endpush
