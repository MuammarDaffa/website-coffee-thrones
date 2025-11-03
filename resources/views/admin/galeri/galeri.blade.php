@extends('layouts.app')

@section('title', 'Galeri')
@section('page-title', 'Galeri')

@section('content')
<div class="container mt-4">
    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus gambar ini?')">
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
        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gambar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Tulis deskripsi singkat..."></textarea>
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
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control"></textarea>
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

{{-- Script Modal --}}
<script>
    function openCreateModal() {
        const modal = new bootstrap.Modal(document.getElementById('createModal'));
        modal.show();
    }

    function openEditModal(id, deskripsi, imageUrl) {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('editForm').action = `/admin/galeri/${id}`;
        document.getElementById('deskripsi').value = deskripsi;
        document.getElementById('previewImage').src = imageUrl;
        modal.show();
    }
</script>
@endsection
