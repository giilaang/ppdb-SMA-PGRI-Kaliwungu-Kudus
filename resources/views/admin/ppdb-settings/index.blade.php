@extends('layouts.admin')
@section('title', 'Pengaturan PPDB')
@section('page-title', 'Pengaturan Informasi PPDB')

@section('content')
<!-- Year Selector -->
<div class="card-section mb-4">
    <div class="card-section-body">
        <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
            <label style="font-weight:600;font-size:13px;white-space:nowrap;">Pilih Tahun Ajaran:</label>
            <select name="academic_year_id" class="form-select" style="width:220px;" onchange="this.form.submit()">
                @foreach($years as $y)
                <option value="{{ $y->id }}" {{ $selectedYearId == $y->id ? 'selected' : '' }}>
                    {{ $y->year }} {{ $y->is_active ? '(Aktif)' : '' }}
                </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

@if($setting)
<form method="POST" action="{{ route('admin.ppdb-settings.update', $setting->id) }}">
    @csrf @method('PATCH')
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">⚙️ Status & Kuota</h3></div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Status Pendaftaran</label>
                        <select name="status" class="form-select">
                            <option value="open" {{ $setting->status === 'open' ? 'selected' : '' }}>🟢 Buka (Calon siswa bisa mendaftar)</option>
                            <option value="closed" {{ $setting->status === 'closed' ? 'selected' : '' }}>🔴 Tutup (Pendaftaran dinonaktifkan)</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Kuota Penerimaan Siswa</label>
                        <input type="number" name="quota" class="form-control" min="1" value="{{ $setting->quota }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">📅 Jadwal Pendaftaran</h3></div>
                <div class="card-section-body">
                    <div class="mb-0">
                        <label class="form-label">Teks Jadwal (ditampilkan di popup Info Pendaftaran)</label>
                        <textarea name="schedule_text" class="form-control" rows="5" placeholder="Contoh:&#10;Gelombang I: Januari - Maret&#10;Gelombang II: April - Juni">{{ $setting->schedule_text }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">📄 Syarat Pendaftaran</h3></div>
                <div class="card-section-body">
                    <label class="form-label">Persyaratan (ditampilkan di popup)</label>
                    <textarea name="requirements_text" class="form-control" rows="6" required>{{ $setting->requirements_text }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">🔄 Alur Pendaftaran</h3></div>
                <div class="card-section-body">
                    <label class="form-label">Alur/Langkah Pendaftaran (ditampilkan di popup)</label>
                    <textarea name="flow_text" class="form-control" rows="6" required>{{ $setting->flow_text }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">💰 Informasi Biaya</h3></div>
                <div class="card-section-body">
                    <textarea name="fees_text" class="form-control" rows="3" placeholder="Informasi biaya pendaftaran...">{{ $setting->fees_text }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn-primary-custom" style="padding:12px 32px;">
                💾 Simpan Pengaturan PPDB
            </button>
        </div>
    </div>
</form>
@else
<div style="text-align:center;padding:60px;background:#fff;border-radius:14px;border:1px solid #e5e7eb;color:#9ca3af;">
    <i class="bi bi-exclamation-circle" style="font-size:40px;display:block;margin-bottom:12px;"></i>
    Tidak ada tahun ajaran yang dipilih.
</div>
@endif
@endsection
