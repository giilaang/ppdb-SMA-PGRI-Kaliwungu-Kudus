<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penerimaan Peserta Didik Baru') | SMA PGRI Kaliwungu Kudus</title>
    <meta name="description" content="@yield('meta-description', 'Penerimaan Peserta Didik Baru (PPDB) SMA PGRI Kaliwungu Kudus. Daftar sekarang dan bergabunglah bersama kami.')">
    <meta name="keywords" content="PPDB, SMA PGRI, Kaliwungu, Kudus, Pendaftaran Siswa Baru">
    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/ppdb/favicon.png') }}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('templatemo-606-string-master.css') }}">
    <style>
        /* Extra utility styles to complement template CSS */
        .form-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 3.5rem 3rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 50px -15px rgba(15, 23, 42, 0.08);
        }
        @media (max-width: 576px) {
            .form-card {
                padding: 2rem 1.5rem;
            }
        }
        .form-group-ppdb { margin-bottom: 22px; }
        .form-group-ppdb label {
            display: block;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: 0.02em;
        }
        .form-group-ppdb input,
        .form-group-ppdb select,
        .form-group-ppdb textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14.5px;
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            outline: none;
            background: #f8fafc;
            color: #0f172a;
        }
        .form-group-ppdb input::placeholder,
        .form-group-ppdb textarea::placeholder {
            color: #94a3b8;
        }
        .form-group-ppdb input:focus,
        .form-group-ppdb select:focus,
        .form-group-ppdb textarea:focus {
            background: #ffffff;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(0, 170, 255, 0.12);
        }
        .form-error {
            color: #ef4444;
            font-size: 12.5px;
            margin-top: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
        }
        .alert-ppdb {
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: var(--shadow-sm);
        }
        .alert-ppdb.success {
            background: #ecfdf5;
            color: #047857;
            border-left: 5px solid #10b981;
        }
        .alert-ppdb.error {
            background: #fff5f5;
            color: #b91c1c;
            border-left: 5px solid #ef4444;
        }

        /* Responsive Grid helper classes */
        .ppdb-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
        }
        .ppdb-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .about-welcome-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 3.5rem;
        }
        .about-vision-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }
        .about-advantages-grid, .facilities-grid, .achievements-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        .majors-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3rem;
        }
        .brochure-container {
            padding: 3rem;
        }
        .brochure-actions {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3.5rem;
        }
        .contact-card {
            padding: 3rem;
        }
        .maps-container {
            height: 450px;
        }

        /* Media Queries for responsive design */
        @media (max-width: 992px) {
            .about-advantages-grid, .facilities-grid, .achievements-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .ppdb-info-grid, .about-welcome-grid, .about-vision-grid, .majors-grid, .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .about-welcome-grid {
                padding: 2rem !important;
            }
            .about-welcome-grid img {
                max-width: 220px !important;
            }
            .about-vision-grid > div {
                padding: 2rem !important;
            }
        }
        @media (max-width: 576px) {
            .ppdb-form-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .about-advantages-grid, .facilities-grid, .achievements-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
            .brochure-container {
                padding: 2rem 1.25rem;
            }
            .brochure-actions {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            .brochure-actions a {
                width: 100%;
                padding: 1rem 1.5rem !important;
                text-align: center;
                margin: 0 !important;
            }
            .contact-card {
                padding: 2rem 1.25rem;
            }
            .maps-container {
                height: 300px;
            }
        }

        /* Hide Google Translate UI elements */
        .goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate,
        #goog-gt-tt,
        .goog-te-balloon-frame,
        .goog-te-preview-frame,
        .skiptranslate iframe {
            display: none !important;
            visibility: hidden !important;
        }
        body {
            top: 0 !important;
            position: static !important;
        }
        .goog-text-highlight {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
            box-sizing: border-box !important;
        }

        /* Responsive offset for fixed header */
        .content-offset {
            margin-top: 120px; /* desktop: top-bar 50px + navbar ~70px */
        }
        @media (max-width: 880px) {
            .content-offset {
                margin-top: 100px; /* mobile: top-bar 50px + compact navbar ~50px */
            }
        }
        @media (max-width: 480px) {
            .content-offset {
                margin-top: 95px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Wrapper to contain both Top Bar and Navbar -->
    <header class="main-header">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="top-bar-container">
                <!-- Left: Language Selection -->
                <div class="lang-dropdown">
                    <button class="lang-dropbtn">
                        <span class="lang-current-flag">🇮🇩</span> <span class="lang-current-text">Indonesia</span> <i class="fa-solid fa-chevron-down lang-icon"></i>
                    </button>
                    <div class="lang-dropdown-content">
                        <a href="javascript:void(0)" class="lang-item active" data-lang="id">
                            <span class="lang-flag">🇮🇩</span> Indonesia
                        </a>
                        <a href="javascript:void(0)" class="lang-item" data-lang="en">
                            <span class="lang-flag">🇬🇧</span> English
                        </a>
                        <a href="javascript:void(0)" class="lang-item" data-lang="ar">
                            <span class="lang-flag">🇸🇦</span> Arab
                        </a>
                    </div>
                </div>

                <!-- Right: WhatsApp Button -->
                <div class="top-bar-right">
                    <a href="https://wa.me/{{ ($contact && $contact->whatsapp) ? $contact->whatsapp : '628812942590' }}?text=Halo%20Admin%20PPDB%2C%20saya%20ingin%20berkonsultasi%20mengenai%20pendaftaran." 
                       target="_blank" 
                       class="top-bar-cta">
                        <i class="fa-brands fa-whatsapp"></i> <span data-translate="consult">Konsultasi Sekarang</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation (Main Navbar) -->
        <nav>
            <div class="nav-container">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/ppdb/logo-smakaliwungu.jpeg') }}" alt="Logo SMA PGRI Kaliwungu Kudus">
                    <div class="logo-content">
                        <span class="school-name">SMA PGRI KALIWUNGU KUDUS</span>
                        <span class="taglinee">Membentuk Generasi Cerdas, Berkarakter, dan Siap Masa Depan</span>
                    </div>
                </a>

                <!-- Desktop Links -->
                <ul class="nav-links desktop-only">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" data-translate="home">Beranda</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" data-translate="about">Tentang SMA</a></li>
                    <li class="nav-dropdown">
                        <a href="javascript:void(0)" class="dropdown-trigger {{ request()->routeIs(['facilities', 'majors', 'achievements']) ? 'active' : '' }}" data-translate="academics">Akademik &amp; Fasilitas <i class="fa-solid fa-chevron-down dropdown-icon"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('facilities') }}" class="{{ request()->routeIs('facilities') ? 'active' : '' }}" data-translate="facilities">Sarana &amp; Prasarana</a></li>
                            <li><a href="{{ route('majors') }}" class="{{ request()->routeIs('majors') ? 'active' : '' }}" data-translate="majors">Program Pilihan</a></li>
                            <li><a href="{{ route('achievements') }}" class="{{ request()->routeIs('achievements') ? 'active' : '' }}" data-translate="achievements">Prestasi Siswa</a></li>
                        </ul>
                    </li>
                    <li class="nav-dropdown">
                        <a href="javascript:void(0)" class="dropdown-trigger {{ request()->routeIs(['services.ppdb', 'services.brochure', 'services.contact']) ? 'active' : '' }}" data-translate="services">Layanan <i class="fa-solid fa-chevron-down dropdown-icon"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('services.ppdb') }}" class="{{ request()->routeIs('services.ppdb') ? 'active' : '' }}" data-translate="ppdb">Pendaftaran PPDB Online</a></li>
                            <li><a href="{{ route('services.brochure') }}" class="{{ request()->routeIs('services.brochure') ? 'active' : '' }}" data-translate="brochure">Download Brosur &amp; Alur</a></li>
                            <li><a href="{{ route('services.contact') }}" class="{{ request()->routeIs('services.contact') ? 'active' : '' }}" data-translate="contact">Kontak &amp; Pengaduan</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Right side: CTA + Hamburger -->
                <div class="nav-right">
                    <a href="javascript:void(0)" class="nav-cta info-modal-trigger">
                        <i class="fa-solid fa-calendar-days" style="margin-right: 5px;"></i>
                        <span data-translate="info">Info Pendaftaran</span>
                    </a>
                    <button class="mobile-menu-btn" aria-label="Buka menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Sidebar — dropdown di bawah navbar -->
<div class="sidebar-backdrop"></div>
    <aside class="mobile-sidebar">
        <ul class="sidebar-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" data-translate="home">Beranda</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" data-translate="about">Tentang SMA</a></li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)" class="sidebar-dropdown-trigger {{ request()->routeIs(['facilities', 'majors', 'achievements']) ? 'active' : '' }}" data-translate="academics">Akademik &amp; Fasilitas <i class="fa-solid fa-chevron-down sidebar-dropdown-icon"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('facilities') }}" class="{{ request()->routeIs('facilities') ? 'active' : '' }}" data-translate="facilities">Sarana &amp; Prasarana</a></li>
                    <li><a href="{{ route('majors') }}" class="{{ request()->routeIs('majors') ? 'active' : '' }}" data-translate="majors">Program Pilihan</a></li>
                    <li><a href="{{ route('achievements') }}" class="{{ request()->routeIs('achievements') ? 'active' : '' }}" data-translate="achievements">Prestasi Siswa</a></li>
                </ul>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)" class="sidebar-dropdown-trigger {{ request()->routeIs(['services.ppdb', 'services.brochure', 'services.contact']) ? 'active' : '' }}" data-translate="services">Layanan <i class="fa-solid fa-chevron-down sidebar-dropdown-icon"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('services.ppdb') }}" class="{{ request()->routeIs('services.ppdb') ? 'active' : '' }}" data-translate="ppdb">Pendaftaran PPDB Online</a></li>
                    <li><a href="{{ route('services.brochure') }}" class="{{ request()->routeIs('services.brochure') ? 'active' : '' }}" data-translate="brochure">Download Brosur &amp; Alur</a></li>
                    <li><a href="{{ route('services.contact') }}" class="{{ request()->routeIs('services.contact') ? 'active' : '' }}" data-translate="contact">Kontak &amp; Pengaduan</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0)" class="sidebar-cta info-modal-trigger" data-translate="info">
                    <i class="fa-solid fa-calendar-days" style="margin-right: 5px;"></i>
                    Info Pendaftaran
                </a>
            </li>
            <li><a href="{{ route('services.ppdb') }}#pendaftaran-form" class="sidebar-cta-daftar">
                    Daftar Sekarang
                      <span class="material-symbols-outlined" style="margin-right: 5px;">
arrow_right_alt
</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="content-offset">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('images/ppdb/logo-smakaliwungu.jpeg') }}" alt="Logo"
                            onerror="this.style.display='none'">
                        SMA PGRI KALIWUNGU KUDUS
                    </a>
                    <p>Sekolah menengah atas unggulan di Kudus yang berfokus pada pembentukan karakter dan prestasi akademik siswa.</p>
                </div>
                <div>
                    <h4 class="footer-title">Navigasi</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('about') }}">Tentang SMA</a></li>
                        <li><a href="{{ route('facilities') }}">Sarana &amp; Prasarana</a></li>
                        <li><a href="{{ route('majors') }}">Program Pilihan</a></li>
                        <li><a href="{{ route('achievements') }}">Prestasi Siswa</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-title">Media Sosial</h4>
                    <ul class="footer-links">
                        @if ($contact && $contact->instagram)
                            <li><a href="{{ $contact->instagram }}" target="_blank">Instagram</a></li>
                        @endif
                        @if ($contact && $contact->facebook)
                            <li><a href="{{ $contact->facebook }}" target="_blank">Facebook</a></li>
                        @endif
                        @if ($contact && $contact->youtube)
                            <li><a href="{{ $contact->youtube }}" target="_blank">YouTube</a></li>
                        @endif
                        @if ($contact && $contact->tiktok)
                            <li><a href="{{ $contact->tiktok }}" target="_blank">TikTok</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="footer-title">Alamat</h4>
                    <ul class="footer-links">
                        @if ($contact)
                            <li>{{ $contact->address }}</li>
                        @else
                            <li>Jl. Raya Kaliwungu - Kudus</li>
                            <li>Kabupaten Kudus, Jawa Tengah</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} SMA PGRI KALIWUNGU KUDUS. All rights reserved.</span>
                <span>Sistem PPDB Dinamis</span>
            </div>
        </div>
    </footer>

    <!-- Registration Info Modal -->
    <div class="modal-overlay" id="infoModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title-wrapper">
                    <div class="modal-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="16" x2="12" y2="12" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                        </svg>
                    </div>
                    <h3>Informasi Pendaftaran PPDB</h3>
                </div>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-badge">Tahun Ajaran {{ $activeYear ? $activeYear->year : '-' }}</div>

                <div class="info-grid">
                    @if ($ppdbSetting)
                        <div class="info-section">
                            <h4>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                Jadwal Pendaftaran
                            </h4>
                            <div style="font-size:13px;color:#555;white-space:pre-line;">{{ $ppdbSetting->schedule_text }}</div>
                        </div>
                        <div class="info-section">
                            <h4>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                Syarat Pendaftaran
                            </h4>
                            <div style="font-size:13px;color:#555;white-space:pre-line;">{{ $ppdbSetting->requirements_text }}</div>
                        </div>
                    @endif
                </div>

                <div class="modal-notice">
                    @if ($ppdbSetting)
                        <p style="white-space:pre-line;">{{ $ppdbSetting->flow_text }}</p>
                    @else
                        <p>Informasi PPDB belum tersedia. Hubungi panitia untuk informasi lebih lanjut.</p>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                @if ($brochure)
                    <a href="{{ route('brochure.download') }}" class="btn-download-modal">
                    
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Brosur
                    </a>
                @endif
                @if ($contact)
                    <a href="https://wa.me/{{ $contact->whatsapp }}" target="_blank" class="btn-wa-modal">
                        Hubungi Panitia
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Google Translate Element (hidden) -->
    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,ar',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script src="{{ asset('templatemo-606-string-scripts.js') }}"></script>
    @stack('scripts')
</body>
</html>
