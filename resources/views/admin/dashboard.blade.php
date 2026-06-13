@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Utama')

@section('content')

@if(auth()->user()->role !== 'editor_content')
<!-- PPDB Stats Row -->
<div class="row g-3 mb-4">
    <!-- Total Pendaftar -->
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value">{{ $totalRegistrants }}</div>
                    <div class="stat-label">Total Pendaftar</div>
                </div>
                <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            @if($activeYear)
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">
                Tahun Ajaran {{ $activeYear->year }}
            </div>
            @endif
        </div>
    </div>
    <!-- Menunggu Verifikasi -->
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value" style="color:#f59e0b;">{{ $pendingRegistrants }}</div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                </div>
                <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            @if($pendingRegistrants > 0)
            <div style="font-size:11px;color:#f59e0b;margin-top:8px;font-weight:600;">
                ⚠️ Perlu tindakan segera
            </div>
            @else
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">Tidak ada yang menunggu</div>
            @endif
        </div>
    </div>
    <!-- Terverifikasi -->
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value" style="color:#10b981;">{{ $verifiedRegistrants }}</div>
                    <div class="stat-label">Terverifikasi</div>
                </div>
                <div class="stat-icon" style="background:#d1fae5;color:#059669;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            @if($quota > 0)
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">
                Kuota: {{ $verifiedRegistrants }}/{{ $quota }}
                <div style="height:4px;background:#e5e7eb;border-radius:2px;margin-top:4px;">
                    <div style="height:4px;background:#10b981;border-radius:2px;width:{{ min(100, ($verifiedRegistrants / $quota) * 100) }}%;"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Ditolak -->
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value" style="font-size:22px;color:#ef4444;">{{ $rejectedRegistrants }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
                <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
            @if($activeYear)
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">{{ $activeYear->year }}</div>
            @endif
        </div>
    </div>
</div>
@endif

<!-- General Stats Row -->
<div class="row g-3 mb-4">
    @php
        $cols = auth()->user()->role === 'editor_content' ? 'col-12 col-md-4' : 'col-6 col-lg-3';
    @endphp
    <!-- Status PPDB -->
    <div class="{{ $cols }}">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value">
                        <span class="status-badge {{ $ppdbOpen ? 'badge-open' : 'badge-closed' }}" style="font-size:13px;padding:6px 12px;">
                            {{ $ppdbOpen ? '🟢 Buka' : '🔴 Tutup' }}
                        </span>
                    </div>
                    <div class="stat-label" style="margin-top:8px;">Status PPDB</div>
                </div>
                <div class="stat-icon" style="background:{{ $ppdbOpen ? '#d1fae5' : '#fee2e2' }};color:{{ $ppdbOpen ? '#059669' : '#dc2626' }};">
                    <i class="bi bi-{{ $ppdbOpen ? 'unlock-fill' : 'lock-fill' }}"></i>
                </div>
            </div>
            @if($activeYear)
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">{{ $activeYear->year }}</div>
            @endif
        </div>
    </div>
    <!-- Pengunjung Website -->
    <div class="{{ $cols }}">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value" style="font-size:22px;color:#8b5cf6;">{{ number_format($visitorCount) }}</div>
                    <div class="stat-label">Pengunjung Website</div>
                </div>
                <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;">
                    <i class="bi bi-eye-fill"></i>
                </div>
            </div>
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">Total kunjungan unik</div>
        </div>
    </div>
    @if(auth()->user()->role !== 'editor_content')
    <!-- Kuota Tersedia -->
    <div class="{{ $cols }}">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value" style="font-size:22px;">{{ $quota }}</div>
                    <div class="stat-label">Kuota Tersedia</div>
                </div>
                <div class="stat-icon" style="background:#e0f4ff;color:#00AAFF;">
                    <i class="bi bi-person-check-fill"></i>
                </div>
            </div>
            @if($activeYear)
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">{{ $activeYear->year }}</div>
            @endif
        </div>
    </div>
    @endif
    <!-- Tahun Ajaran Aktif -->
    <div class="{{ $cols }}">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-value" style="font-size:22px;">{{ $activeYear ? $activeYear->year : '-' }}</div>
                    <div class="stat-label">Tahun Ajaran Aktif</div>
                </div>
                <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8;">
                    <i class="bi bi-calendar3"></i>
                </div>
            </div>
            @if($activeYear && $activeYear->is_active)
            <div style="font-size:11px;color:#10b981;margin-top:8px;font-weight:600;">🟢 Status: Aktif</div>
            @else
            <div style="font-size:11px;color:#9ca3af;margin-top:8px;">Status: Nonaktif</div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions + Recent Activity -->
<div class="row g-3">
    <!-- Quick Actions -->
    <div class="{{ auth()->user()->role === 'editor_content' ? 'col-12' : 'col-lg-4' }}">
        <div class="card-section h-100">
            <div class="card-section-header">
                <h3 class="card-section-title">⚡ Aksi Cepat</h3>
            </div>
            <div class="card-section-body" style="display:flex;flex-direction:column;gap:10px;">
                @if(auth()->user()->role !== 'editor_content')
                <a href="{{ route('admin.registrants.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;transition:all .2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#f0f9ff'">
                    <i class="bi bi-people-fill fs-5"></i>
                    <div>
                        <div style="font-weight:700;font-size:13px;">Data Pendaftar</div>
                        <div style="font-size:11px;opacity:.8;">Lihat & verifikasi pendaftar</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto"></i>
                </a>
                <a href="{{ route('admin.ppdb-settings.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;transition:all .2s;" onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'">
                    <i class="bi bi-gear-fill fs-5"></i>
                    <div>
                        <div style="font-weight:700;font-size:13px;">Pengaturan PPDB</div>
                        <div style="font-size:11px;opacity:.8;">Buka/tutup pendaftaran</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto"></i>
                </a>
                <a href="{{ route('admin.registrants.export.csv', request()->only(['academic_year_id'])) }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background:#faf5ff;border:1px solid #e9d5ff;color:#7c3aed;transition:all .2s;" onmouseover="this.style.background='#ede9fe'" onmouseout="this.style.background='#faf5ff'">
                    <i class="bi bi-download fs-5"></i>
                    <div>
                        <div style="font-weight:700;font-size:13px;">Export CSV</div>
                        <div style="font-size:11px;opacity:.8;">Download data pendaftar</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto"></i>
                </a>
                @endif
                @if(auth()->user()->role !== 'admin_ppdb')
                <a href="{{ route('admin.hero.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background:#fff7ed;border:1px solid #fed7aa;color:#c2410c;transition:all .2s;" onmouseover="this.style.background='#ffedd5'" onmouseout="this.style.background='#fff7ed'">
                    <i class="bi bi-window fs-5"></i>
                    <div>
                        <div style="font-weight:700;font-size:13px;">Edit Hero Section</div>
                        <div style="font-size:11px;opacity:.8;">Ubah tampilan halaman depan</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto"></i>
                </a>
                @endif
                <a href="{{ route('home') }}" target="_blank" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background:#f9fafb;border:1px solid #e5e7eb;color:#374151;transition:all .2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#f9fafb'">
                    <i class="bi bi-globe fs-5"></i>
                    <div>
                        <div style="font-weight:700;font-size:13px;">Lihat Website</div>
                        <div style="font-size:11px;opacity:.8;">Preview halaman publik</div>
                    </div>
                    <i class="bi bi-box-arrow-up-right ms-auto"></i>
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->role !== 'editor_content')
    <!-- Recent Registrations -->
    <div class="col-lg-8">
        <div class="card-section h-100">
            <div class="card-section-header">
                <h3 class="card-section-title">🕐 Pendaftaran Terbaru</h3>
                @if(auth()->user()->role !== 'editor_content')
                <a href="{{ route('admin.registrants.index') }}" style="font-size:13px;color:#1a56db;text-decoration:none;font-weight:600;">Lihat Semua →</a>
                @endif
            </div>
            <div class="card-section-body p-0">
                @if($recentRegistrations->isEmpty())
                <div style="padding:40px;text-align:center;color:#9ca3af;">
                    <i class="bi bi-inbox" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                    <div style="font-size:14px;">Belum ada pendaftaran masuk.</div>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th style="padding:12px 20px;">Nomor Daftar</th>
                                <th style="padding:12px 20px;">Nama</th>
                                <th style="padding:12px 20px;">Jurusan</th>
                                <th style="padding:12px 20px;">Status</th>
                                <th style="padding:12px 20px;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recentRegistrations as $reg)
                            <tr>
                                <td style="padding:12px 20px;">
                                    <span style="font-size:12px;font-weight:700;color:#1a56db;font-family:monospace;">{{ $reg->registration_number }}</span>
                                </td>
                                <td style="padding:12px 20px;">
                                    <div style="font-weight:600;font-size:13px;color:#111827;">{{ $reg->name }}</div>
                                    <div style="font-size:11px;color:#9ca3af;">{{ $reg->previous_school }}</div>
                                </td>
                                <td style="padding:12px 20px;font-size:13px;">{{ $reg->major ? $reg->major->name : '-' }}</td>
                                <td style="padding:12px 20px;">
                                    <span class="status-badge badge-{{ $reg->status }}">
                                        {{ $reg->status === 'pending' ? 'Menunggu' : ($reg->status === 'verified' ? 'Verified' : 'Ditolak') }}
                                    </span>
                                </td>
                                <td style="padding:12px 20px;font-size:12px;color:#6b7280;">{{ $reg->created_at ? $reg->created_at->format('d/m/Y') : '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
