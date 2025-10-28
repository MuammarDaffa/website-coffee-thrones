<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrones Cafe | Pengalaman Kopi Premium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('build/assets/css/frontend.css') }}">
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container header-container">
            <div class="logo-container">
                <a href="#home" class="logo">Thrones<span>.</span></a>
            </div>
            
            <nav id="nav">
                <ul>
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="#gallery">Galeri</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </nav>
            
            <button class="mobile-menu-btn" id="mobile-menu-toggle">☰</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-content">
            <div class="hero-text">
                <span class="welcome">Selamat Datang di</span>
                <h1>Thrones Cafe</h1>
                <p>Nikmati paduan sempurna kopi premium, suasana yang nyaman, dan pelayanan istimewa di Thrones Cafe. Singgasana Anda telah menanti.</p>
                <a href="#menu" class="btn btn-primary">Lihat Menu Kami</a>
            </div>
            
            <div class="hero-images">
                <div class="image-box image-box-1">
                    <img src="{{ asset('build/assets/images/kopi throns.PNG') }}" alt="">
                </div>
                <div class="image-box image-box-2">
                    <img src="{{ asset('build/assets/images/desk.jpg') }}" alt="">
                </div>
            </div>
        </div>
        
        <div class="scroll-indicator">
            <span>Scroll Down</span>
            <div class="circle">↓</div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title">Cerita Kami</h2>
            
            <div class="about-content">
                <div class="about-text">
                    <p>Didirikan pada tahun 2015, Throne Cafe bermula dari sebuah mimpi sederhana untuk menciptakan ruang di mana para pecinta kopi dapat berkumpul, berkoneksi, dan menikmati seduhan terbaik dalam suasana yang elegan namun tetap ramah.</p>
                    <p>Nama kami mencerminkan komitmen untuk memberikan pengalaman kopi yang berkelas, di mana setiap detail diperhatikan dengan cermat untuk membuat kunjungan Anda terasa istimewa. Dari biji kopi yang dipilih dengan etis hingga barista terampil kami, kami bangga dengan setiap cangkir yang kami sajikan.</p>
                    <p>Kini, Throne Cafe terus menjadi destinasi favorit para pecinta kopi, menawarkan tempat yang nyaman untuk melepaskan diri dari kesibukan hidup sehari-hari.</p>
                </div>
                
                <div class="about-image">
                    <img src="{{ asset('build/assets/images/about kopi.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </section>

   <!-- Menu Section -->
<section class="menu" id="menu">
    <div class="container">
        <h2 class="section-title">Menu Kami</h2>

        <div class="menu-tabs">
            <button class="menu-tab active" data-category="coffee">Kopi</button>
            <button class="menu-tab" data-category="non-coffee">Non-Kopi</button>
            <button class="menu-tab" data-category="food">Makanan</button>
        </div>

        <!-- Kopi -->
        <div class="menu-categories active" id="coffee">
            <h3 class="menu-category-title">Pilihan Kopi Premium</h3>
            <div class="menu-grid-elegant">
                @forelse($kopi as $item)
                    <div class="menu-item-elegant">
                        <div class="menu-item-header-elegant">
                            <h4 class="menu-item-name-elegant">{{ $item->nama_produk }}</h4>
                            <span class="menu-item-price-elegant">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="menu-divider"></div>
                        <p class="menu-item-description-elegant">{{ $item->deskripsi ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-muted">Belum ada produk kopi.</p>
                @endforelse
            </div>
        </div>

        <!-- Non Kopi -->
        <div class="menu-categories" id="non-coffee">
            <h3 class="menu-category-title">Pilihan Non-Kopi</h3>
            <div class="menu-grid-elegant">
                @forelse($nonkopi as $item)
                    <div class="menu-item-elegant">
                        <div class="menu-item-header-elegant">
                            <h4 class="menu-item-name-elegant">{{ $item->nama_produk }}</h4>
                            <span class="menu-item-price-elegant">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="menu-divider"></div>
                        <p class="menu-item-description-elegant">{{ $item->deskripsi ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-muted">Belum ada produk non-kopi.</p>
                @endforelse
            </div>
        </div>

        <!-- Makanan -->
        <div class="menu-categories" id="food">
            <h3 class="menu-category-title">Makanan</h3>
            <div class="menu-grid-elegant">
                @forelse($makanan as $item)
                    <div class="menu-item-elegant">
                        <div class="menu-item-header-elegant">
                            <h4 class="menu-item-name-elegant">{{ $item->nama_produk }}</h4>
                            <span class="menu-item-price-elegant">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="menu-divider"></div>
                        <p class="menu-item-description-elegant">{{ $item->deskripsi ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-muted">Belum ada produk makanan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>


    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <h2 class="section-title">Galeri Kami</h2>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="{{ asset('build/assets/images/galeri 1.jpg') }}" alt="">
                </div>
                <div class="gallery-item tall">
                    <img src="{{ asset('build/assets/images/galeri 2.jpg') }}" alt="">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('build/assets/images/galeri 3.jpg') }}" alt="">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('build/assets/images/galeri 4.jpg') }}" alt="">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('build/assets/images/galeri 5.jpg') }}" alt="">
                </div>
                <div class="gallery-item tall">
                    <img src="{{ asset('build/assets/images/galeri 6.jpg') }}" alt="">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('build/assets/images/galeri 7.jpg') }}" alt="">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('build/assets/images/galeri 8.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2 class="section-title">Kunjungi Kami</h2>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <h3>Lokasi</h3>
                        <p>Jl. RE Martadinata No.18D</p>
                        <p>Sungai Jawi Dalam, Pontianak</p>
                        <p>Kalimantan Barat 78115</p>
                    </div>
                    
                    <div class="contact-item">
                        <h3>Kontak</h3>
                        <p><a href="mailto:thronescoffee455@gmail.com">thronescoffee455@gmail.com</a></p>
                        <p><a href="tel:+62895337470175">+62 895-3374-70175</a></p>
                    </div>
                    
                    <div class="contact-item">
                        <h3>Jam Operasional</h3>
                        <table class="hours-table">
                            <tr>
                                <td>Senin - Jumat</td>
                                <td>07.00 - 22.00 WIB</td>
                            </tr>
                            <tr>
                                <td>Sabtu & Minggu</td>
                                <td>07.00 - 00.00 WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.817165224514!2d109.315307!3d-0.014282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d58e8a7ff6fff%3A0x99069b79c3189e91!2sJl.%20RE%20Martadinata%20No.18D%2C%20Sungai%20Jawi%20Dalam%2C%20Kec.%20Pontianak%20Tim.%2C%20Kota%20Pontianak%2C%20Kalimantan%20Barat%2078115!5e0!3m2!1sen!2sid!4v1697367799842!5m2!1sen!2sid" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    
    <footer>
        <div class="container">
            <div class="footer-logo">Thrones<span>.</span></div>
            <p class="footer-text">Nikmati paduan sempurna kopi premium, suasana yang nyaman, dan pelayanan istimewa di Thrones Cafe. Singgasana Anda telah menanti.</p>
            
            <div class="social-icons">
                <a href="https://www.instagram.com/share/BAL0mWIUcC" target="_blank" class="social-icon instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/share/17CBzqSdQ1/?mibextid=wwXIfr" target="_blank" class="social-icon facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.tiktok.com/@kedaikopithrones?_t=ZS-90ZLgJTAx85&_r=1" target="_blank" class="social-icon tiktok">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
            
            <p class="copyright">© 2025 Thrones Cafe. Hak cipta dilindungi.</p>
        </div>
    </footer>

    <script src="{{ asset('build/assets/js/frontend.js') }}"></script>
</body>
</html>