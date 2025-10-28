@extends('layouts.app')

@section('title', 'Produk Kopi')
@section('page-title', 'Daftar Produk Non Kopi')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Produk Non Kopi</h4>

    {{-- 🔘 Tombol Tambah Produk --}}
    <button id="btnTambah" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-circle"></i> Tambah Produk
    </button>
  </div>

  <div class="row">
    @forelse($produks as $produk)
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ $produk->nama_produk }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </h6>
            <p class="card-text">{{ $produk->deskripsi ?? '-' }}</p>

            <button 
              class="btn btn-warning btn-sm me-2 btn-edit"
              data-id="{{ $produk->id }}"
              data-nama="{{ $produk->nama_produk }}"
              data-harga="{{ $produk->harga }}"
              data-deskripsi="{{ $produk->deskripsi }}">
              <i class="bi bi-pencil-square"></i> Edit
            </button>

            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm btn-delete">
                <i class="bi bi-trash"></i> Hapus
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="text-muted">Belum ada produk kopi.</p>
    @endforelse
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {

  // ==========================
  // ➕ TAMBAH PRODUK
  // ==========================
  $('#btnTambah').click(function(e) {
    e.preventDefault();

    Swal.fire({
      title: 'Tambah Produk Kopi',
      html: `
        <input id="nama_produk" class="swal2-input" placeholder="Nama Produk">
        <input id="harga" type="number" class="swal2-input" placeholder="Harga">
        <textarea id="deskripsi" class="swal2-textarea" placeholder="Deskripsi"></textarea>
      `,
      showCancelButton: true,
      confirmButtonText: 'Simpan',
      cancelButtonText: 'Batal',
      preConfirm: () => {
        return {
          nama_produk: $('#nama_produk').val(),
          harga: $('#harga').val(),
          deskripsi: $('#deskripsi').val(),
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `{{ route('produk.store') }}`,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            nama_produk: result.value.nama_produk,
            harga: result.value.harga,
            deskripsi: result.value.deskripsi,
            kategori: 'nonkopi', // ✅ otomatis set kategori kopi
          },
          success: function(response) {
            Swal.fire('Berhasil!', 'Produk berhasil ditambahkan.', 'success')
              .then(() => location.reload());
          },
          error: function(xhr) {
            Swal.fire('Error!', 'Gagal menambahkan produk.', 'error');
          }
        });
      }
    });
  });


  // ==========================
  // ✏️ EDIT PRODUK
  // ==========================
  $('.btn-edit').click(function(e) {
    e.preventDefault();

    const id = $(this).data('id');
    const nama = $(this).data('nama');
    const harga = $(this).data('harga');
    const deskripsi = $(this).data('deskripsi');

    Swal.fire({
      title: 'Edit Produk',
      html: `
        <input id="nama_produk" class="swal2-input" placeholder="Nama Produk" value="${nama}">
        <input id="harga" type="number" class="swal2-input" placeholder="Harga" value="${harga}">
        <textarea id="deskripsi" class="swal2-textarea" placeholder="Deskripsi">${deskripsi || ''}</textarea>
      `,
      showCancelButton: true,
      confirmButtonText: 'Simpan',
      cancelButtonText: 'Batal',
      preConfirm: () => {
        return {
          nama_produk: $('#nama_produk').val(),
          harga: $('#harga').val(),
          deskripsi: $('#deskripsi').val(),
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/admin/produk/${id}`,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            nama_produk: result.value.nama_produk,
            harga: result.value.harga,
            deskripsi: result.value.deskripsi
          },
          success: function(response) {
            Swal.fire('Berhasil!', 'Produk berhasil diperbarui.', 'success');
            const card = $(`.btn-edit[data-id="${id}"]`).closest('.card-body');
            card.find('.card-title').text(result.value.nama_produk);
            card.find('.card-subtitle').text('Rp ' + new Intl.NumberFormat('id-ID').format(result.value.harga));
            card.find('.card-text').text(result.value.deskripsi || '-');
          },
          error: function(xhr) {
            Swal.fire('Error!', 'Gagal memperbarui produk.', 'error');
          }
        });
      }
    });
  });

  // ==========================
  // 🗑️ HAPUS PRODUK
  // ==========================
  $('.btn-delete').click(function(e) {
    e.preventDefault();
    const form = $(this).closest('form');

    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: "Produk ini akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });

});
</script>
@endsection
