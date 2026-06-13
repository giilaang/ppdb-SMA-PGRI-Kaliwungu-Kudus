@extends('layouts.admin')
@section('title', 'Brosur Sekolah')
@section('page-title', 'Kelola Brosur Sekolah')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;border:none;background:#d1fae5;color:#065f46;font-weight:500;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Year Selector --}}
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

@if($selectedYearId)

<div class="row g-4">
    {{-- Form Unggah Brosur --}}
    <div class="col-lg-4">
        <div class="card-section h-100">
            <div class="card-section-header">
                <h3 class="card-section-title">📤 Unggah Brosur</h3>
            </div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.brochures.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $selectedYearId }}">

                    <div class="mb-3">
                        <label class="form-label">Judul Brosur <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="Contoh: Brosur Resmi PPDB 2026" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">File Brosur (PDF) <span class="text-danger">*</span></label>
                        <input type="file" name="brochure_file" class="form-control @error('brochure_file') is-invalid @enderror"
                               accept="application/pdf" required>
                        @error('brochure_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div style="font-size:11px;color:#9ca3af;margin-top:6px;">
                            Format: <strong>PDF</strong>, Maks: <strong>5MB</strong>.
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom w-100" style="padding:10px;">
                        <i class="bi bi-cloud-upload me-2"></i>Unggah Brosur
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Brosur --}}
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <h3 class="card-section-title">📄 Daftar Brosur Pendaftaran</h3>
                <span style="font-size:12px;color:#9ca3af;font-weight:500;">
                    {{ count($brochures) }} brosur terdaftar
                </span>
            </div>
            <div class="card-section-body p-0">
                @if(count($brochures) === 0)
                    <div style="padding:50px;text-align:center;color:#9ca3af;">
                        <i class="bi bi-file-earmark-pdf" style="font-size:40px;display:block;margin-bottom:12px;"></i>
                        <div style="font-size:14px;font-weight:500;">Belum ada brosur untuk tahun ajaran ini.</div>
                        <div style="font-size:12px;margin-top:4px;">Gunakan form di sebelah kiri untuk mengunggah.</div>
                    </div>
                @else
                    @foreach($brochures as $b)
                    <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6;transition:background .15s;"
                         onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                            <div style="flex:1;min-width:200px;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span style="font-weight:700;font-size:15px;color:#111827;">{{ $b->title }}</span>
                                    @if($b->is_active)
                                        <span style="background:#d1fae5;color:#065f46;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;letter-spacing:.5px;">
                                            ✓ AKTIF
                                        </span>
                                    @else
                                        <span style="background:#f3f4f6;color:#9ca3af;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;">
                                            NONAKTIF
                                        </span>
                                    @endif
                                </div>
                                <div style="font-size:12px;color:#6b7280;margin-top:4px;">
                                    <span class="me-3"><i class="bi bi-clock me-1"></i>Diunggah: {{ $b->created_at ? $b->created_at->format('d M Y H:i') : '-' }}</span>
                                    @php
                                        $fileOk = $b->file_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($b->file_path);
                                    @endphp
                                    @if($fileOk)
                                    <span style="background:#d1fae5;color:#065f46;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;">
                                        <i class="bi bi-check-circle-fill me-1"></i>File OK
                                    </span>
                                    @else
                                    <span style="background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>File Hilang — Hapus &amp; upload ulang
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center flex-shrink-0">
                                @if(!$b->is_active)
                                <form method="POST" action="{{ route('admin.brochures.activate', $b->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                            style="font-size:12px;font-weight:600;padding:5px 12px;border-radius:8px;">
                                        <i class="bi bi-check-lg me-1"></i>Aktifkan
                                    </button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('admin.brochures.destroy', $b->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus brosur \'{{ $b->title }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            style="font-size:12px;font-weight:600;padding:5px 12px;border-radius:8px;">
                                        <i class="bi bi-trash3-fill me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Info Box --}}
        <div class="card-section mt-4" style="background:linear-gradient(135deg,#eff6ff,#f0f9ff);border:1px solid #bfdbfe;">
            <div class="card-section-body" style="display:flex;align-items:flex-start;gap:12px;">
                <div style="font-size:24px;flex-shrink:0;">💡</div>
                <div>
                    <div style="font-weight:700;font-size:14px;color:#1e40af;margin-bottom:4px;">Tentang Brosur Sekolah</div>
                    <ul style="font-size:13px;color:#1d4ed8;margin:0;padding-left:16px;line-height:1.8;">
                        <li>Brosur yang diunggah harus berupa file berformat PDF.</li>
                        <li>Hanya ada <strong>satu brosur aktif</strong> untuk satu tahun ajaran. Brosur aktif adalah brosur yang akan diunduh oleh calon siswa di halaman pendaftaran.</li>
                        <li>Menghapus brosur aktif akan menghentikan fitur unduhan brosur di halaman utama sampai brosur lain diaktifkan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<div style="text-align:center;padding:60px;background:#fff;border-radius:14px;border:1px solid #e5e7eb;color:#9ca3af;">
    <i class="bi bi-exclamation-circle" style="font-size:40px;display:block;margin-bottom:12px;"></i>
    Tidak ada tahun ajaran yang tersedia. Silakan buat tahun ajaran terlebih dahulu.
</div>
@endif

@endsection
