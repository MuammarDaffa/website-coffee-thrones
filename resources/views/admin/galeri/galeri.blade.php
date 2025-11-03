@extends('layouts.app')

@section('title', 'Galeri')
@section('page-title', 'Galeri')

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

    {{-- Tombol tambah gambar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Galeri</h3>
        <button class="btn btn-primary" onclick="openCreateModal()">
            + Tambah Gambar
        </button>
    </div>

    {{-- Daftar galeri --}}
    <div class="row">
        @forelse ($galeri as $item)
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    {{-- Gambar --}}
                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                         class="card-img-top" 
                         alt="Gambar Galeri"
                         style="height:200px;object-fit:cover; border-top-left-radius:0.75rem; border-top-right-radius:0.75rem;">

                    <div class="card-body">
                        {{-- Deskripsi --}}
                        <p class="card-text text-muted" style="min-height:50px;">
                            {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                        </p>

                        {{-- Tombol edit dan delete --}}
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-warning" 
                                    onclick="openEditModal({{ $item->id }}, '{{ $item->deskripsi }}', '{{ asset('storage/' . $item->gambar) }}')">
                                Edit
                            </button>

                            <form action="{{ route('galeri.destroy', $item->id) }}" 
                                  method="POST" class="d-inline deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-sm btn-danger btn-delete">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada gambar di galeri.</p>
        @endforelse
    </div>
</div>

{{-- Modal Tambah Gambar --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createForm" action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gambar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- PREVIEW GAMBAR --}}
                    <img id="previewCreate" src="" alt="Preview Gambar" 
                         class="img-fluid mb-3 rounded d-none" 
                         style="max-height: 250px; object-fit: cover;">

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambarCreate" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsiCreate" rows="3" class="form-control" placeholder="Tulis deskripsi singkat..."></textarea>
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

{{-- Modal Edit Gambar --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img id="previewImage" src="" alt="Preview" class="img-fluid mb-3 rounded">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
                        <input type="file" class="form-control" id="gambarEdit" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsiEdit" rows="3" class="form-control"></textarea>
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

{{-- Script Modal dan SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // === Modal Tambah ===
    function openCreateModal() {
        const modal = new bootstrap.Modal(document.getElementById('createModal'));
        document.getElementById('previewCreate').classList.add('d-none');
        document.getElementById('gambarCreate').value = "";
        document.getElementById('deskripsiCreate').value = "";
        modal.show();
    }

    document.getElementById('gambarCreate').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewCreate');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });

    // === Modal Edit ===
    function openEditModal(id, deskripsi, imageUrl) {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('editForm').action = `/admin/galeri/${id}`;
        document.getElementById('deskripsiEdit').value = deskripsi;
        document.getElementById('previewImage').src = imageUrl;
        modal.show();
    }

    document.getElementById('gambarEdit').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewImage');
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });

    // === SweetAlert untuk Tambah dan Edit ===
    document.getElementById('createForm').addEventListener('submit', function(e) {
        Swal.fire({
            icon: 'success',
            title: 'Gambar berhasil ditambahkan!',
            showConfirmButton: false,
            timer: 2000
        });
    });

    document.getElementById('editForm').addEventListener('submit', function(e) {
        Swal.fire({
            icon: 'success',
            title: 'Gambar berhasil diperbarui!',
            showConfirmButton: false,
            timer: 2000
        });
    });

    // === SweetAlert Konfirmasi Hapus ===
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.deleteForm');
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Gambar ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
