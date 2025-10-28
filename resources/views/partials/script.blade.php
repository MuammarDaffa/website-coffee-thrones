<script>
$(document).ready(function() {

    // Ambil kategori dari variabel Blade
    const kategori = "{{ $kategori }}";

    // ==========================
    // TAMBAH PRODUK
    // ==========================
    $('#btnTambah').click(function(e) {
        e.preventDefault();

        Swal.fire({
            title: `Tambah Produk ${kategori.charAt(0).toUpperCase() + kategori.slice(1)}`,
            html: `
                <input id="nama_produk" class="swal2-input" placeholder="Nama Produk">
                <input id="harga" class="swal2-input" placeholder="Rp. ">
                <textarea id="deskripsi" class="swal2-textarea" placeholder="Deskripsi"></textarea>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            didOpen: () => {
                const hargaInput = document.getElementById('harga');
                hargaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value ? parseInt(value).toLocaleString('id-ID') : '';
                });
            },
            preConfirm: () => {
                const hargaRaw = $('#harga').val().replace(/\./g, '');
                return {
                    nama_produk: $('#nama_produk').val(),
                    harga: hargaRaw,
                    deskripsi: $('#deskripsi').val(),
                };
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
                        kategori: kategori,
                    },
                    success: function() {
                        Swal.fire('Berhasil!', 'Produk berhasil ditambahkan.', 'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal menambahkan produk.', 'error');
                    }
                });
            }
        });
    });

    // ==========================
    // EDIT PRODUK
    // ==========================
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const harga = $(this).data('harga');
        const deskripsi = $(this).data('deskripsi');

        Swal.fire({
            title: 'Edit Produk',
            html: `
                <input id="nama_produk" class="swal2-input" placeholder="Nama Produk">
                <input id="harga" class="swal2-input" placeholder="Rp. ">
                <textarea id="deskripsi" class="swal2-textarea" placeholder="Deskripsi"></textarea>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            didOpen: () => {
                $('#nama_produk').val(nama);
                $('#harga').val(parseInt(harga).toLocaleString('id-ID'));
                $('#deskripsi').val(deskripsi);

                const hargaInput = document.getElementById('harga');
                hargaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value ? parseInt(value).toLocaleString('id-ID') : '';
                });
            },
            preConfirm: () => {
                const hargaRaw = $('#harga').val().replace(/\./g, '').replace(/,/g, '');
                return {
                    nama_produk: $('#nama_produk').val(),
                    harga: hargaRaw,
                    deskripsi: $('#deskripsi').val(),
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/produk/${id}`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nama_produk: result.value.nama_produk,
                        harga: result.value.harga,
                        deskripsi: result.value.deskripsi,
                        kategori: kategori,
                    },
                    success: function() {
                        Swal.fire('Berhasil!', 'Produk berhasil diperbarui.', 'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal memperbarui produk.', 'error');
                    }
                });
            }
        });
    });

    // ==========================
    // HAPUS PRODUK
    // ==========================
    $(document).on('click', '.btn-delete', function(e) {
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

    // ==========================
    // LIVE SEARCH
    // ==========================
    $('#search').on('keyup', function() {
        let query = $(this).val();

        $.ajax({
            url: "{{ route('produk.search') }}",
            type: "GET",
            data: { q: query, kategori: kategori },
            success: function(response) {
                let html = '';

                if (response.length > 0) {
                    response.forEach(function(produk) {
                        html += `
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">${produk.nama_produk}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            Rp ${parseInt(produk.harga).toLocaleString('id-ID')}
                                        </h6>
                                        <p class="card-text">${produk.deskripsi ?? '-'}</p>

                                        <button class="btn btn-warning btn-sm me-2 btn-edit"
                                            data-id="${produk.id}"
                                            data-nama="${produk.nama_produk}"
                                            data-harga="${produk.harga}"
                                            data-deskripsi="${produk.deskripsi ?? ''}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <form action="/admin/produk/${produk.id}" method="POST" class="d-inline">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>`;
                    });
                } else {
                    html = '<p class="text-center text-muted">Produk tidak ditemukan.</p>';
                }

                $('#produk-list').html(html);

                // ✅ Tambahkan ulang event delete setelah search
                $('.btn-delete').off('click').on('click', function(e) {
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
            }
        });
    });

});
</script>
