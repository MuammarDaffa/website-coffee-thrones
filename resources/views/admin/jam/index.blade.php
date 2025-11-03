@extends('layouts.app')

@section('title', 'Jam Operasional')
@section('page-title', 'Jam Operasional')

@section('content')
<div class="container mt-4">
    {{-- SweetAlert session success --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif

    <h3 class="mb-3 text-center">Jam Operasional (Senin - Minggu)</h3>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Hari</th>
                    <th>Jam Buka</th>
                    <th>Jam Tutup</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jam as $item)
                <tr>
                    <td class="text-start">{{ $item->day }}</td>
                    <td>{{ $item->open_time ?? '-' }}</td>
                    <td>{{ $item->close_time ?? '-' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                                onclick="openEditModal({{ $item->id }}, '{{ $item->day }}', '{{ $item->open_time ?? '' }}', '{{ $item->close_time ?? '' }}')">
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jam Operasional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong id="dayLabel"></strong></p>

                    <div class="mb-3">
                        <label for="open_time" class="form-label">Jam Buka</label>
                        <input type="time" class="form-control" name="open_time" id="open_time" required>
                    </div>

                    <div class="mb-3">
                        <label for="close_time" class="form-label">Jam Tutup</label>
                        <input type="time" class="form-control" name="close_time" id="close_time" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- include SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openEditModal(id, day, open, close) {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('editForm').action = `/admin/jam-operasional/${id}`;
        document.getElementById('dayLabel').innerText = `Hari: ${day}`;
        document.getElementById('open_time').value = open || '';
        document.getElementById('close_time').value = close || '';
        modal.show();
    }

    // Optional: tampilkan SweetAlert sebelum submit (tunggu sebentar lalu submit)
    // Jika kamu lebih suka menampilkan alert dari session (setelah reload),
    // hapus blok ini. Disini kita pakai session alert di atas.
    /*
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            icon: 'success',
            title: 'Jam operasional diperbarui!',
            showConfirmButton: false,
            timer: 1200
        });
        setTimeout(() => form.submit(), 1200);
    });
    */
</script>
@endsection
