@extends('layouts.app')

@section('title', 'Dashboard | Warung Kopi Thrones')
@section('page-title', 'Dashboard')

@section('content')
<div class="container mt-4 position-relative">

  <!-- 🌅 Latar belakang gradient dan bentuk gelombang -->
  <div class="hero-bg position-relative overflow-hidden rounded-4 mb-5">
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    <div class="text-center text-white py-5" data-aos="fade-down">
      <h2 class="fw-bold animate__animated animate__fadeInDown">☕ Selamat Datang di Thrones Coffee!</h2>
      <p class="animate__animated animate__fadeIn animate__delay-1s">Kelola produk dan pesanan cafemu dengan cepat dan mudah.</p>
      <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
        <a href="{{ route('produk.kopi') }}" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm">
          <i class="bi bi-cup-hot-fill"></i> Kelola Kopi
        </a>
        <a href="{{ route('produk.makanan') }}" class="btn btn-outline-light btn-lg rounded-pill px-4 shadow-sm">
          <i class="bi bi-egg-fried"></i> Kelola Makanan
        </a>
      </div>
    </div>
  </div>

  <!-- 📊 Statistik Floating Cards -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card stat-card p-4 text-center shadow-lg" data-aos="fade-up">
        <div class="icon mb-3 bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:60px; height:60px;">
          <i class="bi bi-cup-hot-fill fs-3"></i>
        </div>
        <h5>Total Kopi</h5>
        <h2 class="text-primary">{{ $totalKopi ?? 0 }}</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card p-4 text-center shadow-lg" data-aos="fade-up" data-aos-delay="100">
        <div class="icon mb-3 bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:60px; height:60px;">
          <i class="bi bi-egg-fried fs-3"></i>
        </div>
        <h5>Total Makanan</h5>
        <h2 class="text-success">{{ $totalMakanan ?? 0 }}</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card p-4 text-center shadow-lg" data-aos="fade-up" data-aos-delay="200">
        <div class="icon mb-3 bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:60px; height:60px;">
          <i class="bi bi-basket fs-3"></i>
        </div>
        <h5>Pesanan Terbaru</h5>
        <h2 class="text-warning">{{ $totalPesanan ?? 0 }}</h2>
      </div>
    </div>
  </div>

</div>

<!-- ✨ Style -->
<style>
  /* Hero Background Gradient dengan Gelombang */
  .hero-bg {
    background: linear-gradient(135deg, #1a87d0, #6fb1fc);
    position: relative;
    overflow: hidden;
  }
  .wave {
    position: absolute;
    width: 200%;
    height: 100%;
    background: rgba(255,255,255,0.1);
    border-radius: 45%;
    animation: waveAnim 20s linear infinite;
    top: -30%;
    left: -50%;
  }
  .wave2 {
    animation-delay: -10s;
  }
  @keyframes waveAnim {
    0% { transform: translateX(0) translateY(0) rotate(0deg);}
    50% { transform: translateX(20%) translateY(5%) rotate(5deg);}
    100% { transform: translateX(0) translateY(0) rotate(0deg);}
  }

  /* Statistik Card Floating Effect */
  .stat-card {
    border-radius: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  }
</style>
@endsection
