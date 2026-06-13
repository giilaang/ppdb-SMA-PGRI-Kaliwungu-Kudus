@extends('layouts.frontend')

@section('title', 'PPDB ' . ($activeYear ? $activeYear->year : ''))
@section('meta-description', 'Daftarkan diri Anda di SMA PGRI Kaliwungu Kudus melalui sistem PPDB online kami.')

@section('content')

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <!-- Hero Slider (Full Width) -->
        <div class="guitar-wrapper">
            <div class="hero-image-card project-slider-wrapper">
                <div class="project-slider" data-autoplay="true">
                    @if ($hero && $hero->banner_image_1)
                        <img src="{{ Str::startsWith($hero->banner_image_1, 'http') ? $hero->banner_image_1 : asset($hero->banner_image_1) }}"
                            alt="Banner 1" class="hero-dev-img">
                    @else
                        <img src="{{ asset('images/ppdb/BROSUR SMA PLUS BU 2025.jpg') }}" alt="Banner 1"
                            class="hero-dev-img" onerror="this.style.display='none'">
                    @endif
                    @if ($hero && $hero->banner_image_2)
                        <img src="{{ Str::startsWith($hero->banner_image_2, 'http') ? $hero->banner_image_2 : asset($hero->banner_image_2) }}"
                            alt="Banner 2" class="hero-dev-img">
                    @else
                        <img src="{{ asset('images/ppdb/download.jpg') }}" alt="Banner 2" class="hero-dev-img"
                            onerror="this.style.display='none'">
                    @endif
                    @if ($hero && $hero->banner_image_3)
                        <img src="{{ Str::startsWith($hero->banner_image_3, 'http') ? $hero->banner_image_3 : asset($hero->banner_image_3) }}"
                            alt="Banner 3" class="hero-dev-img">
                    @endif
                </div>
                <div class="hero-img-overlay"></div>
                <div class="slider-dots"></div>
            </div>
        </div>

        <!-- Hero Content (Centered, Constrained Width) -->
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span>●</span>
                    @if ($activeYear)
                        @if ($ppdbSetting && $ppdbSetting->status === 'open')
                            PPDB {{ $activeYear->year }} Telah Dibuka
                        @else
                            PPDB {{ $activeYear->year }} Belum Dibuka
                        @endif
                    @else
                        Selamat Datang di Website Kami
                    @endif
                </div>
                <h1>
                    @if ($hero)
                        {!! $hero->title !!}
                    @else
                        <p>SMA <span class="">PGRI</span> KALIWUNGU <span class="">KUDUS</span></p>
                    @endif
                </h1>
                <p class="hero-description">
                    {{ $hero ? $hero->subtitle : 'Segera bergabung bersama sekolah unggulan yang membentuk generasi cerdas, berkarakter, dan berprestasi.' }}
                </p>
                <div class="hero-buttons">
                    @if ($ppdbSetting && $ppdbSetting->status === 'open')
                        <a href="{{ route('services.ppdb') }}#pendaftaran-form" class="btn-primary">
                            {{ $hero ? $hero->register_button_text : 'Daftar Sekarang' }} 
                        <span class="material-symbols-outlined">
arrow_right_alt
</span>
                        </a>
                    @else
                        <a href="javascript:void(0)" class="btn-primary info-modal-trigger">
                            Info Pendaftaran
                        </a>
                    @endif
                    @if ($brochure)
                        <a href="{{ route('brochure.download') }}" class="btn-secondary">
                            {{ $hero ? $hero->brochure_button_text : 'Download Brosur' }}
                            <span class="material-symbols-outlined" style="margin-left: 10px;">
download
</span>
                        </a>
                    @else
                        <a href="javascript:void(0)" class="btn-secondary info-modal-trigger">
                            {{ $hero ? $hero->brochure_button_text : 'Download Brosur' }}
                            <span class="material-symbols-outlined" style="margin-left: 10px;">
download
</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Intro Section -->
    <section class="profile-intro" id="profil">
        <div class="section-container">
            <div class="profile-card">
                <div class="profile-image-container">
                    <img src="{{ $profile && $profile->principal_welcome_photo ? (Str::startsWith($profile->principal_welcome_photo, 'http') ? $profile->principal_welcome_photo : asset($profile->principal_welcome_photo)) : asset('images/ppdb/logo-smakaliwungu.jpeg') }}"
                        alt="Kepala Sekolah" class="profile-img"
                        onerror="this.src='{{ asset('images/ppdb/logo-smakaliwungu.jpeg') }}'">
                    <div class="profile-decoration"></div>
                </div>
                <div class="profile-info">
                    <span class="profile-label">Visi &amp; Misi Kami</span>
                    <h2 class="profile-name">
                        {{ $profile ? Str::limit($profile->principal_welcome_name, 40) : 'SMA PGRI KALIWUNGU' }}</h2>
                    <p class="profile-tagline">
                        {{ $profile ? $profile->vision : 'Mewujudkan generasi yang berakhlak mulia, unggul dalam prestasi, dan siap menghadapi tantangan global.' }}
                    </p>
                </div>
            </div>

            @if ($profile && $profile->video_path)
                <div class="profile-video-section" style="margin-top: 5rem; text-align: center; border: none; outline: none; position: relative;">
                    <div style="margin-bottom: 2.5rem; border: none; outline: none;">
                        <span
                            style="font-size: 0.85rem; color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: block;">Video
                            Profil Sekolah</span>
                        <h2
                            style="font-size: clamp(2rem, 4vw, 2.5rem); font-weight: 700; margin-bottom: 0.75rem; letter-spacing: -0.02em; color: var(--text-primary);">
                            Kenal Lebih Dekat Dengan Kami</h2>
                        <p
                            style="font-size: 1.05rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto; line-height: 1.6;">
                            Tonton video profil SMA PGRI Kaliwungu Kudus untuk melihat lingkungan sekolah, aktivitas
                            belajar, dan fasilitas secara langsung.</p>
                    </div>

                    <div class="video-wrapper"
                        style="max-width: 1000px; max-height: 700px;margin: 0 auto; border-radius: 50px; overflow: hidden; outline: none; transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); border: 10px solid #8CC0EB;"
                        onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <video width="100%" autoplay loop muted playsinline
                            style="display: block; outline: none; border: none; border-radius: 12px; pointer-events: none; width: 100%;">
                            <source src="{{ asset($profile->video_path) }}">
                            Browser Anda tidak mendukung pemutar video HTML5.
                        </video>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
    /* ==========================
   PROFILE INTRO
========================== */

.profile-intro{
    background-color:#ffffff;
    background-size:80px 80px;
    position:relative;
    padding:5.5rem 0;
    overflow:hidden;
}

/* Biar isi section tidak mepet */
.profile-intro .section-container{
    max-width:1200px;
    margin:0 auto;
    padding:0 24px;
}

/* Center teks profile */
.profile-info{
    text-align:center;
    max-width:700px;
    margin:0 auto;
}

.profile-label{
    display:inline-block;
}

/* Judul video profile seperti berita */
.profile-video-section > div:first-child{
    text-align:center;
    max-width:700px;
    margin:0 auto 2.5rem;
}

/* ==========================
   RESPONSIVE MOBILE
========================== */

@media (max-width:768px){

    .profile-intro{
        padding:4rem 0;
    }

    /* jarak kanan kiri HP */
    .profile-intro .section-container{
        padding:0 22px;
    }

    /* profile card jadi vertikal */
    .profile-card{
        display:flex;
        flex-direction:column;
        align-items:center;
        text-align:center;
        gap:1.8rem;
    }

    /* ukuran foto lebih proporsional */
    .profile-img{
        width:220px;
        max-width:100%;
        height:auto;
    }

    /* heading video tidak terlalu besar */
    .profile-video-section h2{
        font-size:1.8rem !important;
        line-height:1.3;
    }

    .profile-video-section p{
        font-size:0.95rem !important;
    }

    /* video tidak mepet layar */
    .video-wrapper{
        border-width:6px !important;
        border-radius:20px !important;
    }
}
    </style>

    <!-- Keunggulan Section -->
    <section style="border: none;" class="features" id="keunggulan">
        <div class="section-container">
            <div class="section-header">
                <div class="section-label">Keunggulan Kami</div>
                <h1 class="section-title">Mengapa Memilih SMA PGRI?</h1>
                <p class="section-description">Kami menyediakan lingkungan belajar yang kondusif dengan fasilitas pendukung
                    yang lengkap untuk mencetak lulusan yang kompetitif.</p>
            </div>
            <div class="features-grid">
                @forelse($advantages as $adv)
                    <div class="feature-card">
                        <div class="feature-icon">
                            {!! $adv->icon !!}
                        </div>
                        <div class="feature-content">
                            <h3>{{ $adv->title }}</h3>
                            <p>{{ $adv->description }}</p>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center;color:#888;">Belum ada data keunggulan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- News & Announcements Section (New!) -->
    
    <!-- BERITA & PENGUMUMAN -->
<section id="berita-pengumuman" style="background-color: #F5F5F5;" class="news-announcements-section">

    <div class="section-container">

        <!-- ==================== BERITA ==================== -->
        <div class="section-header-custom">
            <span class="section-label">
                Kabar Sekolah
            </span>

            <h2>
                Berita Rilis Terkini
            </h2>

            <p>
                Ikuti perkembangan kegiatan, prestasi, dan aktivitas terbaru di sekolah kami.
            </p>
        </div>

        <div class="news-grid">

            @forelse($news->take(6) as $item)

                <a href="{{ route('news.show', $item->slug) }}"
                   class="news-card">

                    <div class="news-image-wrapper">
                        <img
                            src="{{ $item->image_path ? (Str::startsWith($item->image_path,'http') ? $item->image_path : asset($item->image_path)) : asset('images/ppdb/logo-smakaliwungu.jpeg') }}"
                            alt="{{ $item->title }}">
                    </div>

                    <div class="news-content-wrapper">

                        <span class="news-date">
                            📅
                            {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                        </span>

                        <h3 class="news-title">
                            {{ $item->title }}
                        </h3>

                        <p class="news-excerpt">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>

                    </div>

                </a>

            @empty

                <p>Belum ada berita.</p>

            @endforelse

        </div>

        <style>
        /* Desktop = tampil 6 */
.news-card{
    display:block;
}

/* Mobile = tampil hanya 3 kartu */
@media (max-width:768px){

    .news-grid .news-card:nth-child(n+4){
        display:none;
    }

    @media (max-width:768px){

    .announcement-grid .announcement-card:nth-child(n+4){
        display:none;
    }

}

}
        </style>

        <div class="section-button">
            <a href="{{ route('news.index') }}" class="btn-lihat-semua">
                Lihat Semua Berita
                <i class="fa-solid fa-arrow-right ms-2" style="margin-left: 5px;"></i>
            </a>
        </div>


        <!-- ==================== PENGUMUMAN ==================== -->

        <div style="margin-top:80px;">

            <div class="section-header-custom">
                <span class="section-label">
                    Informasi Penting
                </span>

                <h2>
                    Pengumuman
                </h2>

                <p>
                    Pengumuman resmi dari panitia PPDB dan sekolah.
                </p>
            </div>

            <div class="announcement-grid">

                @forelse($announcements->take(6) as $ann)

                    <a href="{{ route('announcements.show', $ann->id) }}"
                       class="announcement-card">

                        <div class="announcement-meta">

                            <span class="announcement-badge">
                                PENTING
                            </span>

                            <span class="announcement-date">
                                {{ $ann->published_at ? $ann->published_at->format('d M Y') : $ann->created_at->format('d M Y') }}
                            </span>

                        </div>

                        <h4 class="announcement-title">
                            {{ $ann->title }}
                        </h4>

                        <p class="announcement-text">
                            {{ Str::limit(strip_tags($ann->content), 120) }}
                        </p>

                        @if($ann->file_path)
                            <span class="announcement-file">
                                📎 Lampiran tersedia
                            </span>
                        @endif

                    </a>

                @empty

                    <p>Belum ada pengumuman.</p>

                @endforelse

            </div>

            <div class="section-button">
                <a href="{{ route('announcements.index') }}"
                   class="btn-lihat-semua">
                    Lihat Semua Pengumuman
                    <i class="fa-solid fa-arrow-right ms-2" style="margin-left: 5px;"></i>
                </a>
            </div>

        </div>

    </div>

</section>

<style>
/* =======================================================
   BERITA & PENGUMUMAN
======================================================= */

/* =======================================================
   BERITA & PENGUMUMAN
======================================================= */

.news-announcements-section{
    padding:80px 0;
    background:#f8fafc;
}

/* Tambahkan ini */
.section-container{
    max-width:1200px;
    margin:0 auto;
    padding:0 24px; /* jarak kanan kiri */
}

/* HEADER SECTION */
.section-header-custom{
    margin-bottom:35px;
    text-align:center; /* bikin semua header ke tengah */
    max-width:700px;
    margin-left:auto;
    margin-right:auto;
}

.section-header-custom h2{
    font-size:2.3rem;
    font-weight:800;
    margin:10px 0;
    color:#0f172a;
}

.section-header-custom p{
    color:#64748b;
    margin:0;
    line-height:1.8;
}

.section-label{
    display:inline-block;
    padding:8px 14px;
    border-radius:999px;
    background:#e0f2fe;
    color:#0284c7;
    font-size:14px;
    font-weight:600;
}

/* ==================== GRID ==================== */

.news-grid,
.announcement-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}

/* ==================== CARD BERITA ==================== */

.news-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    text-decoration:none;
    color:inherit;
    box-shadow:0 4px 20px rgba(0,0,0,.06);
    transition:.3s;
}

.news-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 40px rgba(0,0,0,.12);
}

.news-image-wrapper{
    height:220px;
    overflow:hidden;
}

.news-image-wrapper img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.4s;
}

.news-card:hover img{
    transform:scale(1.05);
}

.news-content-wrapper{
    padding:20px;
}

.news-date{
    color:#0ea5e9;
    font-size:14px;
    font-weight:600;
}

.news-title{
    margin-top:10px;
    font-size:1.1rem;
    font-weight:700;
    color:#0f172a;
}

.news-excerpt{
    margin-top:10px;
    color:#64748b;
    line-height:1.7;
}

/* ==================== CARD PENGUMUMAN ==================== */

.announcement-card{
    background:white;
    padding:24px;
    border-radius:20px;
    text-decoration:none;
    color:inherit;
    box-shadow:0 4px 20px rgba(0,0,0,.06);
    transition:.3s;
}

.announcement-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 40px rgba(0,0,0,.12);
}

.announcement-meta{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.announcement-badge{
    background:#fee2e2;
    color:#dc2626;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.announcement-date{
    color:#64748b;
    font-size:13px;
}

.announcement-title{
    font-size:1.1rem;
    font-weight:700;
    color:#0f172a;
    margin-bottom:12px;
}

.announcement-text{
    color:#64748b;
    line-height:1.7;
}

.announcement-file{
    display:inline-block;
    margin-top:15px;
    color:#0284c7;
    font-weight:600;
}

/* ==================== BUTTON ==================== */

.section-button{
    text-align:center;
    margin-top:10px;
}

.btn-lihat-semua{
    display:inline-block;
    background:#FFD41D;
    color:white;
    font-size: 13px;
    padding:12px 22px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
}

.btn-lihat-semua:hover{
    background:#F9E400;
    color:white;
    transform:translateY(-2px);
}

/* ==================== RESPONSIVE ==================== */

@media(max-width:992px){

    .news-grid,
    .announcement-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:768px){

    .news-grid,
    .announcement-grid{
        grid-template-columns:1fr;
    }

    .section-header-custom h2{
        font-size:1.8rem;
    }

}
</style>

    <!-- Kontak & Maps Section -->
    <section class="contact-maps" id="contact" style="background: #ffffff; padding: 1rem 0;">
        <div class="contact-bg-decoration"></div>
        <div class="section-container">
            <div class="contact-maps-grid">
                <!-- Contact Information -->
                <div class="contact-info-card glass-card">
                    <div class="section-label">Hubungi Kami</div>
                    <h2 class="section-title">Informasi lebih lanjut mengenai <span class="highlight">PPDB</span></h2>
                    <p class="section-description">Panitia PPDB kami siap membantu menjawab pertanyaan Anda mengenai pendaftaran, biaya, dan fasilitas sekolah.</p>

                    <div class="contact-details">
                        @if ($contact)
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                </div>
                                <div class="contact-text">
                                    <h4>Email Resmi</h4>
                                    <p>{{ $contact->email }}</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 1 .7 2.81 2 2 0 0 1-.45 1.11L7.82 9.17a16 16 0 0 0 6 6l1.58-1.58a2 2 0 0 1 1.11-.45 12.84 12.84 0 0 1 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                </div>
                                <div class="contact-text">
                                    <h4>WhatsApp Panitia</h4>
                                    <p>+{{ $contact->whatsapp }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div style="margin-top: 2rem;">
                        @if ($contact)
                            <a href="https://wa.me/{{ $contact->whatsapp }}?text=Halo%20Panitia%20PPDB%2C%20saya%20ingin%20bertanya%20mengenai%20pendaftaran."
                                target="_blank" class="btn-primary-wa"
                                style="display:flex;align-items:center;gap:8px;text-decoration:none;border:none;justify-content:center;">
                                <span>Hubungi via WhatsApp</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="maps-wrapper">
                    <div class="map-info-card glass-card">
                        <h3 class="info-title">Lokasi Sekolah</h3>
                        <p class="info-text">
                            {{ $contact ? $contact->address : 'Jl. Raya Kaliwungu - Kudus, Kabupaten Kudus, Jawa Tengah.' }}
                        </p>
                    </div>

                    <div class="maps-container glass-card">
                    
                       
                        
                            <iframe
                                width="100%"
                                height="100%"
                                style="border:0;"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://maps.google.com/maps?q=SMA%20PGRI%20Kaliwungu%20Kudus&t=h&z=18&ie=UTF8&iwloc=&output=embed">
                            </iframe>
                        
                        <div class="map-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
