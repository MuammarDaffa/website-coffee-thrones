@extends('layouts.app')

@section('title', 'Jam Operasional')
@section('page-title', 'Jam Operasional')

@section('content')
<div class="container mt-4">
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

    <h3 class="mb-3 text-center">Jam Operasional</h3>

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
                    <td class="text-start">{{ $item->day_group }}</td>
                    <td>{{ $item->open_time ?? '-' }}</td>
                    <td>{{ $item->close_time ?? '-' }}</td>
                    <td>
                        {{-- Gunakan data-* attributes agar aman (tidak ada masalah quoting) --}}
                        <button type="button"
                                class="btn btn-warning btn-sm btn-edit"
                                data-id="{{ $item->id }}"
                                data-day="{{ $item->day_group }}"
                                data-open="{{ $item->open_time ?? '' }}"
                                data-close="{{ $item->close_time ?? '' }}">
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
                        <input type="time" class="form-control" name="open_time" id="open_time">
                    </div>

                    <div class="mb-3">
                        <label for="close_time" class="form-label">Jam Tutup</label>
                        <input type="time" class="form-control" name="close_time" id="close_time">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');
    const editModalEl = document.getElementById('editModal');
    const editModal = new bootstrap.Modal(editModalEl);
    const editForm = document.getElementById('editForm');
    const dayLabel = document.getElementById('dayLabel');
    const openInput = document.getElementById('open_time');
    const closeInput = document.getElementById('close_time');

    editButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const day = btn.dataset.day;
            const open = btn.dataset.open || '';
            const close = btn.dataset.close || '';

            // set action dan nilai input
            editForm.action = `/admin/jam-operasional/${id}`;
            dayLabel.innerText = `Hari: ${day}`;
            openInput.value = open;
            closeInput.value = close;

            editModal.show();
        });
    });

    // Optional: show SweetAlert after submit with a tiny delay so user sees it
    // BUT because controller redirects back with session('success'),
    // we currently rely on session alert (so no need to intercept submit here).
});
</script>
@endsection
