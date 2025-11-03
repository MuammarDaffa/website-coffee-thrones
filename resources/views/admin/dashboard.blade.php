@extends('layouts.app')

@section('title', 'Dashboard | Warung Kopi Thrones')
@section('page-title', 'Dashboard')

@section('content')
<div class="container mt-4 position-relative">

<div class="coffee-particles">
  @for($i = 0; $i < 50; $i++)
    <span class="particle" style="
      left: {{ rand(0,100) }}%;
      width: {{ rand(2,6) }}px;
      height: {{ rand(2,6) }}px;
      animation-duration: {{ rand(8,15) }}s;
      opacity: {{ rand(3,7)/10 }};
    "></span>
  @endfor
</div>



  <!-- 🌤️ Hero -->
  <div class="text-center py-5 position-relative" style="z-index:1;">
    <div data-aos="fade-down">
      <h2 class="fw-bold text-blue animate__animated animate__fadeInDown">☕ Selamat Datang di Thrones Coffee!</h2>
      <p class="text-muted animate__animated animate__fadeIn animate__delay-1s">Kelola produk dan pesanan cafemu dengan cepat dan menyenangkan.</p>
      <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
        <a href="{{ route('produk.kopi') }}" class="btn btn-brown btn-lg rounded-pill px-4 shadow-sm">
          Kelola Kopi
        </a>
        <a href="{{ route('produk.makanan') }}" class="btn btn-outline-brown btn-lg rounded-pill px-4 shadow-sm">
           Kelola Makanan
        </a>
      </div>
    </div>
   
  </div>

  <!-- 📊 Statistik Floating Cards -->


</div>

<!-- ✨ Style -->
<style>
 /* Warna tema biru */
.text-blue { color: #1A87D0; } /* ganti text-brown jadi text-blue */
.btn-brown { background-color: #1A87D0; color: white; border:none; }
.btn-brown:hover { background-color: #166fb0; }
.btn-outline-brown { border: 2px solid #1A87D0; color:#1A87D0; }
.btn-outline-brown:hover { background-color: #1A87D0; color:white; }

/* Icon kartu (opsional) */



  /* Floating/stat card hover */
  .hover-float { transition: all 0.3s ease; border-radius:1rem; }
  .hover-float:hover { transform: translateY(-10px); box-shadow:0 20px 40px rgba(0,0,0,0.2); }

  /* Animasi cangkir kopi */
  .coffee-cup { animation-duration: 2s; animation-timing-function: ease-in-out; }

  /* Partikel kopi full background */
  .coffee-particles {
    position: fixed;
    top:0; left:0;
    width:100%;
    height:100%;
    pointer-events:none;
    overflow:hidden;
    z-index:0;
  }
  .coffee-particles::before {
    content: '';
    position: absolute;
    width: 8px; height: 8px;
    background: #1A87D0;
    border-radius:50%;
    animation: floatCoffee 15s linear infinite;
    top:100%; left:20%;
    opacity:0.6;
  }
  .coffee-particles::after {
    content: '';
    position: absolute;
    width: 6px; height: 6px;
    background: #1A87D0;
    border-radius:50%;
    animation: floatCoffee 20s linear infinite;
    top:100%; left:60%;
    opacity:0.5;
  }
.coffee-particles .particle {
  position: absolute;
  background: #1A87D0; /* ganti dari coklat ke biru */
  border-radius: 50%;
  top: 100%;
  animation-name: floatCoffee;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}


@keyframes floatCoffee {
  0% { transform: translateY(0) translateX(0) rotate(0deg); opacity:1; }
  100% { transform: translateY(-1200px) translateX(50px) rotate(360deg); opacity:0; }
}


</style>
@endsection
