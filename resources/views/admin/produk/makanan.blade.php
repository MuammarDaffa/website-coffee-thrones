@extends('layouts.app')

@section('title', 'Produk Kopi')
@section('page-title', 'Daftar Produk Non Kopi')

@section('content')
    @include('partials.navbar-produk')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Produk Makanan</h4>
        </div>

        <div class="row" id="produk-list">
            @forelse($produks as $produk)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </h6>
                            <p class="card-text">{{ $produk->deskripsi ?? '-' }}</p>

                            <button class="btn btn-warning btn-sm me-2 btn-edit" 
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
    @include('partials.script', ['kategori' => 'makanan'])
@endsection
