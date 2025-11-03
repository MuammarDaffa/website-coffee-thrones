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
        <button id="btnTambah" class="btn btn-primary">+ Tambah Gambar</button>
    </div>

    {{-- Daftar galeri --}}
    <div class="row">
        @forelse ($galeri as $item)
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm position-relative overflow-hidden">
                    {{-- Gambar --}}
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="Gambar Galeri" style="height:200px;object-fit:cover;">


                    {{-- Deskripsi overlay --}}
                    <div class="overlay position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2 text-center"
                        style="transform: translateY(100%); transition: all 0.3s;">
                        {{ $item->deskripsi ?? '-' }}
                    </div>
                </div>

                {{-- Tombol edit dan delete --}}
                <div class="mt-2 text-center">
                    <button class="btn btn-sm btn-warning edit-btn"
                        data-id="{{ $item->id }}"
                        data-deskripsi="{{ $item->deskripsi }}"
                        data-gambar="{{ asset('storage/' . $item->gambar) }}">
                        Edit
                    </button>

                    <form action="{{ route('galeri.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada gambar di galeri.</p>
        @endforelse
    </div>
</div>

{{-- Modal Tambah Gambar --}}
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahModalLabel">Tambah Gambar Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3 text-center">
                  <img id="previewTambah" src="{{ asset('images/no-preview.png') }}" class="img-fluid rounded mb-2" style="max-height:200px; object-fit:cover;">
              </div>
              <div class="mb-3">
                  <label for="gambarTambah" class="form-label">Upload Gambar</label>
                  <input type="file" class="form-control" id="gambarTambah" name="gambar" required>
              </div>
              <div class="mb-3">
                  <label for="deskripsiTambah" class="form-label">Deskripsi</label>
                  <textarea name="deskripsi" id="deskripsiTambah" class="form-control" rows="3" placeholder="Tulis deskripsi gambar..."></textarea>
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

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Gambar Galeri</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <img id="previewGambar" src="" class="img-fluid mb-3 rounded" style="max-height:200px;object-fit:cover;">
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar Baru (opsional)</label>
                <input type="file" class="form-control" name="gambar" id="gambar">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
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

{{-- Style overlay hover --}}
<style>
.card:hover .overlay {
    transform: translateY(0);
}
</style>

{{-- Script Modal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    const tambahModal = new bootstrap.Modal(document.getElementById('tambahModal'));

    const formEdit = document.getElementById('editForm');
    const deskripsiInput = document.getElementById('deskripsi');
    const previewGambar = document.getElementById('previewGambar');

    // Edit modal setup
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const deskripsi = button.dataset.deskripsi;
            const gambar = button.dataset.gambar;

            deskripsiInput.value = deskripsi;
            previewGambar.src = gambar;
            formEdit.action = `/galeri/${id}`;
            editModal.show();
        });
    });

    // Tambah modal
    document.getElementById('btnTambah').addEventListener('click', () => {
        tambahModal.show();
    });

    // Preview gambar baru saat upload di modal tambah
    const gambarTambah = document.getElementById('gambarTambah');
    const previewTambah = document.getElementById('previewTambah');

    gambarTambah.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            previewTambah.src = URL.createObjectURL(file);
        }
    });
});
</script>
@endsection
