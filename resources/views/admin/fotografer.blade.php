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
                                <li class="breadcrumb-item active">Fotografer List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Fotografer</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Fotografer Aktif</h4>

                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-centered nowrap w-100" id="tickets-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>No. Whatsapp</th>
                                            <th>Detail Rekening</th>
                                            <th>Active</th>
                                            <th class="hidden-sm">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($fotografer as $fotograferItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>{{ $fotograferItem->nama }}</td>
                                                <td class="text-start"
                                                    style="max-width: 300px; min-width: 200px; white-space: normal; word-wrap: break-word;">
                                                    {{ $fotograferItem->alamat }}
                                                </td>
                                                <td>{{ $fotograferItem->nowa }}</td>
                                                @if ($fotograferItem->rekening_id)
                                                    <td>{{ $fotograferItem->rekening->nama_bank }} -
                                                        {{ $fotograferItem->rekening->rekening }}
                                                        ({{ $fotograferItem->rekening->nama }})
                                                    </td>
                                                @else
                                                    <td>rekening tidak tersedia</td>
                                                @endif
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox"
                                                            class="form-check-input update-status-checkbox"
                                                            id="customSwitch{{ $fotograferItem->user->id }}"
                                                            data-id="{{ $fotograferItem->user->id }}"
                                                            {{ $fotograferItem->user->is_foto ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit-modal-{{ $fotograferItem->id }}"
                                                        class="action-icon"
                                                        data-id="{{ $fotograferItem->id }}">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal untuk setiap event -->
                                            <div id="edit-modal-{{ $fotograferItem->id }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title">Detail Fotografer</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.event-update', $fotograferItem->id) }}"
                                                                method="POST" class="px-3">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6">
                                                                        <label for="event" class="form-label">Nama
                                                                            Fotografer</label>
                                                                        <input class="form-control" name="nama"
                                                                            type="text"
                                                                            value="{{ $fotograferItem->nama }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="event" class="form-label">No.
                                                                            Whatsapp</label>
                                                                        <input class="form-control" name="nama"
                                                                            type="text"
                                                                            value="{{ $fotograferItem->nowa }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tanggal" class="form-label">Alamat</label>
                                                                    <input class="form-control" name="nama"
                                                                        type="text"
                                                                        value="{{ $fotograferItem->alamat }}"
                                                                        required="" readonly
                                                                        style="border: none; background-color: transparent;">
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6">
                                                                        <label for="event" class="form-label">Nama
                                                                            User</label>
                                                                        <input class="form-control" name="nama"
                                                                            type="text"
                                                                            value="{{ $fotograferItem->user->name }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="event" class="form-label">Email
                                                                            User</label>
                                                                        <input class="form-control" name="nama"
                                                                            type="text"
                                                                            value="{{ $fotograferItem->user->email }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6">
                                                                        <label for="event"
                                                                            class="form-label">Rekening</label>
                                                                        @if ($fotograferItem->rekening_id)
                                                                            <input class="form-control" name="nama"
                                                                                type="text"
                                                                                value="{{ $fotograferItem->rekening->rekening }} - {{ $fotograferItem->rekening->nama }}"
                                                                                required="" readonly
                                                                                style="border: none; background-color: transparent;">
                                                                        @else
                                                                            <input class="form-control" name="nama"
                                                                                type="text"
                                                                                value="Rekening tidak tersedia"
                                                                                required="" readonly
                                                                                style="border: none; background-color: transparent;">
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="event"
                                                                            class="form-label">Bank</label>
                                                                        @if ($fotograferItem->rekening_id)
                                                                            <input class="form-control" name="nama"
                                                                                type="text"
                                                                                value="{{ $fotograferItem->rekening->nama_bank }}"
                                                                                required="" readonly
                                                                                style="border: none; background-color: transparent;">
                                                                        @else
                                                                            <input class="form-control" name="nama"
                                                                                type="text"
                                                                                value="Rekening tidak tersedia"
                                                                                required="" readonly
                                                                                style="border: none; background-color: transparent;">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <div class="col-md-6">
                                                                        <label for="event"
                                                                            class="form-label">Saldo</label>
                                                                        <input class="form-control" name="nama"
                                                                            type="text"
                                                                            value="{{ 'Rp. ' . number_format($fotograferItem->jumlah, 0, ',', '.') }}"
                                                                            required="" readonly
                                                                            style="border: none; background-color: transparent;">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="event" class="form-label">Foto
                                                                            KTP</label>
                                                                        <div class="col-lg-12">
                                                                            <div>
                                                                                <img src="{{ Storage::url($fotograferItem->foto_ktp) }}"
                                                                                    alt="image"
                                                                                    class="img-fluid rounded"
                                                                                    width="200" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <!-- Map container with unique ID for each event -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Close</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.update-status-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function(event) {
                    const userId = this.dataset.id; // Ambil ID user dari data-id
                    const isChecked = this.checked; // Periksa apakah checkbox dicentang

                    // Simpan checkbox asli untuk mengembalikan nilai jika dibatalkan
                    const originalCheckbox = this;

                    // Tampilkan konfirmasi menggunakan SweetAlert
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan mengubah status fotografer menjadi ${isChecked ? 'aktif' : 'nonaktif'}.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ubah!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim permintaan AJAX jika pengguna mengkonfirmasi
                            fetch(`/admin/fotografer/update-status/${userId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        is_foto: isChecked
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: data.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                    } else {
                                        throw new Error('Gagal memperbarui status');
                                    }
                                })
                                .catch(error => {
                                    // Tampilkan error jika terjadi kesalahan
                                    console.error('Error:', error);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan saat memperbarui status, coba lagi.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                    // Kembalikan checkbox ke nilai awal
                                    originalCheckbox.checked = !isChecked;
                                });
                        } else {
                            // Jika batal, kembalikan checkbox ke nilai awal
                            originalCheckbox.checked = !isChecked;
                        }
                    });
                });
            });
        });
    </script>
@endpush
