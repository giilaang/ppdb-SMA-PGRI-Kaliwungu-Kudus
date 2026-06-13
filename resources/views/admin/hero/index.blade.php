@extends('layouts.admin')
@section('title', 'Hero Section')
@section('page-title', 'Edit Hero Section')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
    <label style="font-weight:600;font-size:13px;white-space:nowrap;">Tahun Ajaran:</label>
    <form method="GET" class="d-inline">
        <select name="academic_year_id" class="form-select" style="width:200px;" onchange="this.form.submit()">
            @foreach($years as $y)
            <option value="{{ $y->id }}" {{ $selectedYearId == $y->id ? 'selected' : '' }}>{{ $y->year }} {{ $y->is_active ? '(Aktif)' : '' }}</option>
            @endforeach
        </select>
    </form>
</div>

@if($hero)

{{-- Tampilkan error validasi --}}
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan:</strong>
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="POST" action="{{ route('admin.hero.update', $hero->id) }}" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <input type="hidden" name="academic_year_id" value="{{ $selectedYearId }}">
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">🖊️ Teks Hero</h3></div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Utama *</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title) }}" required>
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Bisa menggunakan HTML sederhana, cth: SMA &lt;span class="highlight"&gt;PGRI&lt;/span&gt;</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtitle *</label>
                        <textarea name="subtitle" class="form-control" rows="3" required>{{ old('subtitle', $hero->subtitle) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teks Tombol Daftar *</label>
                        <input type="text" name="register_button_text" class="form-control" value="{{ old('register_button_text', $hero->register_button_text) }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Teks Tombol Brosur *</label>
                        <input type="text" name="brochure_button_text" class="form-control" value="{{ old('brochure_button_text', $hero->brochure_button_text) }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">🖼️ Banner Slider (Max. 3 Gambar, masing-masing maks. 5MB)</h3></div>
                <div class="card-section-body">
                    @foreach([1,2,3] as $i)
                    @php $field = 'banner_image_' . $i; @endphp
                    <div class="mb-3">
                        <label class="form-label fw-bold">Banner {{ $i }}</label>
                        @if($hero->$field)
                        <div style="margin-bottom:8px;">
                            <img src="{{ Str::startsWith($hero->$field, 'http') ? $hero->$field : asset($hero->$field) }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;" onerror="this.style.display='none'">
                            <div style="font-size:11px;color:#6b7280;margin-top:4px;">Gambar saat ini</div>
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="delete_banner_{{ $i }}" id="del_banner_{{ $i }}" value="1">
                                <label class="form-check-label text-danger" for="del_banner_{{ $i }}" style="font-size:12px;">Hapus banner ini</label>
                            </div>
                        </div>
                        @else
                        <div style="background:#f3f4f6;height:80px;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px;margin-bottom:8px;">Belum ada gambar</div>
                        @endif
                        <input type="file" name="banner_image_{{ $i }}" id="banner_image_{{ $i }}" class="form-control @error('banner_image_'.$i) is-invalid @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Format: JPG, PNG, GIF, WEBP. Maks. 5MB.</div>
                        @error('banner_image_'.$i)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn-primary-custom" style="padding:12px 32px;">💾 Simpan Hero Section</button>
        </div>
    </div>
</form>
@endif
@endsection
