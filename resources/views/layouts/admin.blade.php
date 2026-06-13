<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | CMS PPDB SMA PGRI Kaliwungu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--  Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/ppdb/favicon.png') }}">
    <link rel="stylesheet"
href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00AAFF;
            --primary-dark: #007ACC;
            --sidebar-width: 260px;
            --sidebar-bg: #021525; /* Deep dark sky-blue navy */
            --sidebar-hover: #052d4a; /* Hover dark blue */
            --sidebar-active: #00AAFF;
            --topbar-h: 64px;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; margin: 0; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-width); height: 100vh;
            background: var(--sidebar-bg); z-index: 1000;
            display: flex; flex-direction: column;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand img { width: 38px; height: 38px; border-radius: 8px; object-fit: cover; }
        .sidebar-brand .brand-text { color: #fff; font-weight: 700; font-size: 13px; line-height: 1.3; }
        .sidebar-brand .brand-sub { color: #6b7fa3; font-size: 11px; font-weight: 400; }

        .sidebar-nav { padding: 12px 0; flex: 1; }
        .nav-section-label {
            color: #4a5568; font-size: 10px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; padding: 12px 20px 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px; color: #8a9ab5; font-size: 13.5px;
            font-weight: 500; text-decoration: none; border-radius: 0;
            transition: all 0.2s; position: relative;
        }
        .sidebar-link:hover { color: #fff; background: var(--sidebar-hover); }
        .sidebar-link.active { color: #fff; background: var(--sidebar-active); }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; background: #7dd3fc; border-radius: 0 2px 2px 0;
        }
        .sidebar-link i { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-link .badge-count {
            margin-left: auto; background: #ef4444; color: #fff;
            font-size: 10px; padding: 1px 6px; border-radius: 10px;
        }

        .sidebar-footer {
            padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-user { display: flex; align-items: center; gap: 10px; }
        .sidebar-avatar {
            width: 36px; height: 36px; border-radius: 50%; background: var(--primary);
            display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px;
        }
        .sidebar-user-info .user-name { color: #fff; font-size: 13px; font-weight: 600; }
        .sidebar-user-info .user-role { color: #6b7fa3; font-size: 11px; }
        .role-badge {
            display: inline-block; padding: 1px 7px; border-radius: 20px; font-size: 10px; font-weight: 600;
        }
        .role-super_admin { background: #fef3c7; color: #92400e; }
        .role-admin_ppdb { background: #fef9c3; color: #854d0e; }
        .role-editor_content { background: #d1fae5; color: #065f46; }

        /* Topbar */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-h); background: #fff;
            border-bottom: 1px solid #e5e7eb; z-index: 900;
            display: flex; align-items: center; padding: 0 24px; gap: 16px;
        }
        .topbar-title { font-size: 17px; font-weight: 700; color: #111827; flex: 1; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .btn-topbar-logout {
            display: flex; align-items: center; gap: 6px;
            color: #ef4444; font-size: 13.5px; font-weight: 500;
            border: 1px solid #fee2e2; background: #fff;
            padding: 7px 14px; border-radius: 8px; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
        }
        .btn-topbar-logout:hover { background: #fee2e2; }
        .topbar-site-link {
            display: flex; align-items: center; gap: 6px;
            color: var(--primary); font-size: 13.5px; font-weight: 500;
            border: 1px solid #bae6fd; background: #fff;
            padding: 7px 14px; border-radius: 8px; text-decoration: none;
            transition: all 0.2s;
        }
        .topbar-site-link:hover { background: #e0f4ff; }
        .hamburger { display: none; background: none; border: none; cursor: pointer; padding: 4px; }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-h);
            min-height: calc(100vh - var(--topbar-h));
            padding: 28px;
        }

        /* Cards */
        .stat-card {
            background: #fff; border-radius: 14px; padding: 22px 24px;
            border: 1px solid #e5e7eb; transition: box-shadow 0.2s;
        }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.07); }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 22px;
        }
        .stat-card .stat-value { font-size: 28px; font-weight: 800; color: #111827; margin: 8px 0 2px; }
        .stat-card .stat-label { font-size: 13px; color: #6b7280; font-weight: 500; }

        /* Alerts */
        .alert-fixed {
            position: fixed; top: 80px; right: 20px; z-index: 9999;
            min-width: 300px; max-width: 400px;
            animation: slideInRight 0.3s ease;
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Table styles */
        .table-modern thead th {
            background: #f8fafc; border-bottom: 2px solid #e5e7eb;
            color: #374151; font-weight: 600; font-size: 12px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .table-modern tbody tr:hover td { background: #f9fafb; }

        /* Form styles */
        .form-label { font-weight: 600; font-size: 13px; color: #374151; }
        .form-control, .form-select {
            border: 1.5px solid #e5e7eb; border-radius: 8px;
            font-size: 14px; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0, 170, 255, 0.15);
        }
        .btn-primary-custom {
            background: var(--primary); color: #fff; border: none;
            border-radius: 8px; font-weight: 600; font-size: 14px;
            padding: 10px 22px; transition: all 0.2s;
        }
        .btn-primary-custom:hover { background: var(--primary-dark); color: #fff; transform: translateY(-1px); }

        .card-section { background: #fff; border-radius: 14px; border: 1px solid #e5e7eb; overflow: hidden; }
        .card-section-header { padding: 18px 24px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; }
        .card-section-title { font-size: 15px; font-weight: 700; color: #111827; margin: 0; }
        .card-section-body { padding: 24px; }

        /* Status badges */
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-verified { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .badge-open { background: #d1fae5; color: #065f46; }
        .badge-closed { background: #fee2e2; color: #991b1b; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }

        /* Overlay when sidebar open on mobile */
        .sidebar-overlay { display: none; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .hamburger { display: block; }
            .sidebar-overlay {
                display: block; position: fixed; inset: 0;
                background: rgba(0,0,0,.4); z-index: 999; opacity: 0;
                pointer-events: none; transition: opacity 0.3s;
            }
            .sidebar-overlay.show { opacity: 1; pointer-events: auto; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/ppdb/logo-smakaliwungu.jpeg') }}" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=SMA+PGRI&background=1a56db&color=fff&size=38'">
        <div>
            <div class="brand-text">SMA PGRI Kaliwungu</div>
            <div class="brand-sub">Panel Admin CMS PPDB</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-globe"></i> Lihat Website
        </a>

        @if(auth()->user()->role !== 'editor_content')
        <div class="nav-section-label">Sistem PPDB</div>
        @if(auth()->user()->role === 'super_admin')
        <a href="{{ route('admin.academic-years.index') }}" class="sidebar-link {{ request()->routeIs('admin.academic-years.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Tahun Ajaran
        </a>
        @endif
        <a href="{{ route('admin.ppdb-settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.ppdb-settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i> Pengaturan PPDB
        </a>
        <a href="{{ route('admin.ppdb-waves.index') }}" class="sidebar-link {{ request()->routeIs('admin.ppdb-waves.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-range"></i> Gelombang Daftar
        </a>
        <a href="{{ route('admin.registrants.index') }}" class="sidebar-link {{ request()->routeIs('admin.registrants.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Data Pendaftar
        </a>
        <a href="{{ route('admin.brochures.index') }}" class="sidebar-link {{ request()->routeIs('admin.brochures.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-pdf"></i> Brosur
        </a>
        @endif

        @if(auth()->user()->role !== 'admin_ppdb')
        <div class="nav-section-label">Konten Website</div>
        <a href="{{ route('admin.hero.index') }}" class="sidebar-link {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
            <i class="bi bi-window"></i> Hero Section
        </a>
        <a href="{{ route('admin.profile.index') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Profil Sekolah
        </a>
        <a href="{{ route('admin.advantages.index') }}" class="sidebar-link {{ request()->routeIs('admin.advantages.*') ? 'active' : '' }}">
            <i class="bi bi-stars"></i> Keunggulan
        </a>
        <a href="{{ route('admin.facilities.index') }}" class="sidebar-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
            <i class="bi bi-building-check"></i> Fasilitas
        </a>
        <a href="{{ route('admin.majors.index') }}" class="sidebar-link {{ request()->routeIs('admin.majors.*') ? 'active' : '' }}">
            <i class="bi bi-mortarboard"></i> Jurusan
        </a>
        <a href="{{ route('admin.achievements.index') }}" class="sidebar-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
            <i class="bi bi-trophy"></i> Prestasi & Alumni
        </a>
        <a href="{{ route('admin.galleries.index') }}" class="sidebar-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Galeri Foto
        </a>
        <a href="{{ route('admin.news.index') }}" class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Manajemen Berita
        </a>
        <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Manajemen Pengumuman
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <i class="bi bi-telephone"></i> Kontak Sekolah
        </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">
                    @php $roleMap = ['super_admin'=>'Super Admin','admin_ppdb'=>'Admin PPDB','editor_content'=>'Editor Konten']; @endphp
                    <span class="role-badge role-{{ auth()->user()->role }}">{{ $roleMap[auth()->user()->role] ?? auth()->user()->role }}</span>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <button class="hamburger" id="hamburgerBtn">
        <i class="bi bi-list fs-5"></i>
    </button>
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-actions">
        <a href="{{ route('home') }}" class="topbar-site-link" target="_blank">
            <i class="bi bi-globe"></i> Website
        </a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn-topbar-logout">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</header>

<!-- Main Content -->
<main class="main-content">
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @yield('content')
</main>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar toggle
    const hamburger = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    // Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('.alert-fixed').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });
</script>
@stack('scripts')
</body>
</html>
