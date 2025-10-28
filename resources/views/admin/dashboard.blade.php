@extends('layouts.app')

@section('title', 'Dashboard | Warung Kopi Thrones')
@section('page-title', 'Dashboard')

@section('content')
<div class="container mt-4">

  <!-- 🌤️ Header dengan animasi fade-down -->
  <div class="text-center mb-4" data-aos="fade-down">
    <h2 class="fw-bold text-primary animate__animated animate__fadeInDown">
      ☕ Selamat Datang di Thrones Coffee Dashboard!
    </h2>
    <p class="text-muted animate__animated animate__fadeIn animate__delay-1s">
      Kelola produk dan data cafemu dengan mudah dan cepat.
    </p>
  </div>

  <!-- 🪄 Card utama -->
  <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp" data-aos="zoom-in">
    <div class="card-body text-center p-5">
      <h4 class="fw-semibold mb-2">Hai, Admin!</h4>
      <p class="text-muted mb-4">Selamat datang di halaman utama sistem manajemen Warung Kopi Thrones ☕</p>

      <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('produk.kopi') }}" class="btn btn-primary btn-lg rounded-pill px-4">
          <i class="bi bi-cup-hot"></i> Kelola Produk Kopi
        </a>
        <a href="{{ route('produk.makanan') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
          <i class="bi bi-egg-fried"></i> Kelola Makanan
        </a>
      </div>
    </div>
  </div>

 

</div>
@endsection
