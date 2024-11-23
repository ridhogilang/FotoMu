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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pengguna</a></li>
                                <li class="breadcrumb-item active">Pengguna List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pengguna</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Pengguna FotoMu</h4>

                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-centered nowrap w-100" id="tickets-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. Whatsapp</th>
                                            <th>Status</th>
                                            <th>Active</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($user as $userItem)
                                            <tr>
                                                <td><b>{{ $loop->iteration }}</b></td>
                                                <td>{{ $userItem->name }}</td>
                                                <td>{{ $userItem->email }}</td>
                                                <td>{{ $userItem->nowa }}</td>
                                                @if ($userItem->is_admin == 1)
                                                    <td><span class="badge label-table bg-primary">Admin</span>
                                                    </td>
                                                @elseif ($userItem->is_foto == 1 && $userItem->is_user == 1)
                                                    <td><span class="badge label-table bg-success">Fotografer</span> <span
                                                            class="badge label-table bg-warning">User</span>
                                                    </td>
                                                @elseif ($userItem->is_foto == 1)
                                                    <td><span class="badge label-table bg-success">Fotografer</span>
                                                    </td>
                                                @elseif ($userItem->is_user == 1)
                                                    <td><span class="badge label-table bg-warning">User</span>
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox"
                                                            class="form-check-input update-status-checkbox"
                                                            id="customSwitch{{ $userItem->id }}"
                                                            data-id="{{ $userItem->id }}"
                                                            {{ $userItem->is_active ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
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
            const activeCheckboxes = document.querySelectorAll('.update-status-checkbox');
    
            activeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const userId = this.dataset.id; // ID pengguna
                    const isChecked = this.checked; // Status checkbox
                    
                    // Simpan referensi checkbox asli untuk rollback jika dibatalkan
                    const originalCheckbox = this;
    
                    // SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan mengubah status aktif menjadi ${isChecked ? 'aktif' : 'nonaktif'}.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ubah!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim permintaan AJAX jika pengguna mengkonfirmasi
                            fetch(`/admin/user/update-active/${userId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        is_active: isChecked
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
