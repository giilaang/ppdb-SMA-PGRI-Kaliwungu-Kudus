@extends('layouts.admin')
@section('title', 'Tahun Ajaran')
@section('page-title', 'Manajemen Tahun Ajaran')

@section('content')
<div class="row g-3">
    <!-- Form Tambah -->
    <div class="col-lg-4">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">➕ Tambah Tahun Ajaran</h3></div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.academic-years.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="year" class="form-control" placeholder="cth: 2027/2028" value="{{ old('year') }}" required>
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Format: 2027/2028</div>
                        @error('year') <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">Buat Tahun Ajaran Baru</button>
                </form>
                <div style="background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:12px;margin-top:16px;font-size:12px;color:#78350f;">
                    ⚠️ <strong>Catatan:</strong> Saat Anda membuat tahun ajaran baru, sistem secara otomatis menyiapkan Hero Section dan pengaturan PPDB awal agar halaman depan tidak kosong.
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Tahun Ajaran -->
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">📅 Daftar Tahun Ajaran</h3></div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="padding:12px 20px;">Tahun Ajaran</th>
                            <th style="padding:12px 20px;">Status</th>
                            <th style="padding:12px 20px;">Arsip</th>
                            <th style="padding:12px 20px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($years as $year)
                        <tr>
                            <td style="padding:14px 20px;font-weight:700;font-size:15px;color:#111827;">
                                {{ $year->year }}
                            </td>
                            <td style="padding:14px 20px;">
                                @if($year->is_active)
                                <span class="status-badge badge-open">🟢 Aktif</span>
                                @else
                                <span class="status-badge" style="background:#f3f4f6;color:#374151;">⚫ Tidak Aktif</span>
                                @endif
                            </td>
                            <td style="padding:14px 20px;">
                                @if($year->is_archived)
                                <span class="status-badge" style="background:#f3f4f6;color:#6b7280;">📦 Diarsipkan</span>
                                @else
                                <span class="status-badge" style="background:#d1fae5;color:#065f46;">✅ Aktif</span>
                                @endif
                            </td>
                            <td style="padding:14px 20px;">
                                <div class="d-flex gap-2 flex-wrap">
                                    @if(!$year->is_active)
                                    <form method="POST" action="{{ route('admin.academic-years.activate', $year->id) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-weight:600;font-size:12px;" title="Jadikan Aktif">
                                            Aktifkan
                                        </button>
                                    </form>
                                    @endif
                                    @if(!$year->is_active)
                                    <form method="POST" action="{{ route('admin.academic-years.toggleArchive', $year->id) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm" style="background:#fef3c7;color:#92400e;border-radius:6px;font-weight:600;font-size:12px;">
                                            {{ $year->is_archived ? 'Buka Arsip' : 'Arsipkan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.academic-years.destroy', $year->id) }}" class="d-inline" onsubmit="return confirm('Hapus tahun ajaran {{ $year->year }}? SEMUA DATA terkait (pendaftar, hero, settings) akan ikut terhapus!')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border-radius:6px;font-weight:600;font-size:12px;">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:40px;color:#9ca3af;">Belum ada tahun ajaran.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
