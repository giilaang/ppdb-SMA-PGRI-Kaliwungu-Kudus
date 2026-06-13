@extends('layouts.admin')
@section('title', 'Gelombang Pendaftaran')
@section('page-title', 'Manajemen Gelombang Pendaftaran')

@section('content')

{{-- Flash Messages --}}
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
    {{-- Form Tambah Gelombang --}}
    <div class="col-lg-4">
        <div class="card-section h-100">
            <div class="card-section-header">
                <h3 class="card-section-title">➕ Tambah Gelombang</h3>
            </div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.ppdb-waves.store') }}">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $selectedYearId }}">

                    <div class="mb-3">
                        <label class="form-label">Nama Gelombang <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Gelombang I" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                               value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                               value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active_add"
                                   value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active_add" style="font-weight:500;">
                                Aktifkan Gelombang Ini
                            </label>
                        </div>
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">
                            Hanya satu gelombang yang aktif pada satu waktu.
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom w-100" style="padding:10px;">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Gelombang
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Gelombang --}}
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <h3 class="card-section-title">📋 Daftar Gelombang Pendaftaran</h3>
                <span style="font-size:12px;color:#9ca3af;font-weight:500;">
                    {{ count($waves) }} gelombang terdaftar
                </span>
            </div>
            <div class="card-section-body p-0">
                @if(count($waves) === 0)
                    <div style="padding:50px;text-align:center;color:#9ca3af;">
                        <i class="bi bi-calendar-x" style="font-size:40px;display:block;margin-bottom:12px;"></i>
                        <div style="font-size:14px;font-weight:500;">Belum ada gelombang untuk tahun ajaran ini.</div>
                        <div style="font-size:12px;margin-top:4px;">Gunakan form di sebelah kiri untuk menambahkan.</div>
                    </div>
                @else
                    @foreach($waves as $wave)
                    <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6;transition:background .15s;"
                         onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                            <div style="flex:1;min-width:200px;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span style="font-weight:700;font-size:15px;color:#111827;">{{ $wave->name }}</span>
                                    @if($wave->is_active)
                                        <span style="background:#d1fae5;color:#065f46;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;letter-spacing:.5px;">
                                            ✓ AKTIF
                                        </span>
                                    @else
                                        <span style="background:#f3f4f6;color:#9ca3af;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;">
                                            NONAKTIF
                                        </span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-3 flex-wrap" style="font-size:13px;color:#6b7280;">
                                    <span><i class="bi bi-calendar-event me-1"></i>
                                        {{ \Carbon\Carbon::parse($wave->start_date)->format('d M Y') }}
                                    </span>
                                    <span style="color:#d1d5db;">→</span>
                                    <span><i class="bi bi-calendar-check me-1"></i>
                                        {{ \Carbon\Carbon::parse($wave->end_date)->format('d M Y') }}
                                    </span>
                                </div>
                                @php
                                    $now = now();
                                    $start = \Carbon\Carbon::parse($wave->start_date);
                                    $end = \Carbon\Carbon::parse($wave->end_date);
                                    $isOngoing = $now->between($start, $end);
                                    $isPast = $now->isAfter($end);
                                    $isUpcoming = $now->isBefore($start);
                                @endphp
                                <div style="margin-top:6px;">
                                    @if($isOngoing)
                                        <span style="font-size:11px;color:#0284c7;font-weight:600;">
                                            <i class="bi bi-clock me-1"></i>Sedang Berlangsung
                                        </span>
                                    @elseif($isPast)
                                        <span style="font-size:11px;color:#9ca3af;">
                                            <i class="bi bi-check2-all me-1"></i>Sudah Selesai
                                        </span>
                                    @elseif($isUpcoming)
                                        <span style="font-size:11px;color:#7c3aed;font-weight:600;">
                                            <i class="bi bi-hourglass me-1"></i>Akan Datang — {{ $start->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center flex-shrink-0">
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $wave->id }}"
                                        style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-size:12px;font-weight:600;padding:5px 12px;border-radius:8px;">
                                    <i class="bi bi-pencil-fill me-1"></i>Edit
                                </button>
                                <form method="POST" action="{{ route('admin.ppdb-waves.destroy', $wave->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus gelombang \'{{ $wave->name }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                            style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;font-size:12px;font-weight:600;padding:5px 12px;border-radius:8px;">
                                        <i class="bi bi-trash-fill me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editModal{{ $wave->id }}" tabindex="-1"
                         aria-labelledby="editModalLabel{{ $wave->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15);">
                                <div class="modal-header" style="background:linear-gradient(135deg,#1a56db,#1e40af);color:#fff;border-radius:16px 16px 0 0;border:none;">
                                    <h5 class="modal-title" id="editModalLabel{{ $wave->id }}" style="font-weight:700;">
                                        ✏️ Edit Gelombang
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.ppdb-waves.update', $wave->id) }}">
                                    @csrf @method('PATCH')
                                    <div class="modal-body" style="padding:24px;">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Gelombang <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $wave->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                            <input type="date" name="start_date" class="form-control"
                                                   value="{{ \Carbon\Carbon::parse($wave->start_date)->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control"
                                                   value="{{ \Carbon\Carbon::parse($wave->end_date)->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active"
                                                       id="is_active_{{ $wave->id }}" value="1"
                                                       {{ $wave->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active_{{ $wave->id }}" style="font-weight:500;">
                                                    Aktifkan Gelombang Ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border:none;padding:16px 24px;gap:8px;">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                                                style="border-radius:8px;font-weight:600;">Batal</button>
                                        <button type="submit" class="btn-primary-custom" style="padding:10px 24px;">
                                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
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
                    <div style="font-weight:700;font-size:14px;color:#1e40af;margin-bottom:4px;">Tentang Gelombang Pendaftaran</div>
                    <ul style="font-size:13px;color:#1d4ed8;margin:0;padding-left:16px;line-height:1.8;">
                        <li>Setiap tahun ajaran dapat memiliki beberapa gelombang pendaftaran.</li>
                        <li>Hanya <strong>satu gelombang aktif</strong> yang berlaku pada satu waktu — mengaktifkan gelombang baru akan menonaktifkan yang lain.</li>
                        <li>Gelombang yang sedang aktif akan ditampilkan di halaman publik sebagai periode pendaftaran yang berlaku.</li>
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
