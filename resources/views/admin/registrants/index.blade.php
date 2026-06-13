@extends('layouts.admin')
@section('title', 'Data Pendaftar')
@section('page-title', 'Manajemen Data Pendaftar')

@section('content')
<div class="card-section">
    <!-- Filters -->
    <div class="card-section-header flex-wrap gap-3">
        <h3 class="card-section-title">📋 Daftar Pendaftar</h3>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.registrants.export.csv', ['academic_year_id' => $selectedYearId, 'status' => $selectedStatus, 'major_id' => $selectedMajorId, 'search' => $search]) }}" class="btn btn-sm d-flex align-items-center gap-2" style="background:#10b981;color:#fff;border-radius:8px;font-weight:600;">
                <i class="bi bi-download"></i> Export CSV
            </a>
        </div>
    </div>
    <div style="padding:16px 24px;border-bottom:1px solid #f3f4f6;background:#f9fafb;">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Tahun Ajaran</label>
                <select name="academic_year_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                    <option value="{{ $y->id }}" {{ $selectedYearId == $y->id ? 'selected' : '' }}>
                        {{ $y->year }} {{ $y->is_active ? '(Aktif)' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Status</label>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="verified" {{ $selectedStatus === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ $selectedStatus === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Jurusan</label>
                <select name="major_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Jurusan</option>
                    @foreach($majors as $m)
                    <option value="{{ $m->id }}" {{ $selectedMajorId == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama, NISN, No. Daftar..." value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100" style="height:32px;">Cari</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th style="padding:12px 20px;">#</th>
                    <th style="padding:12px 20px;">No. Daftar</th>
                    <th style="padding:12px 20px;">Nama Siswa</th>
                    <th style="padding:12px 20px;">Asal Sekolah</th>
                    <th style="padding:12px 20px;">Jurusan</th>
                    <th style="padding:12px 20px;">Status</th>
                    <th style="padding:12px 20px;">Tanggal</th>
                    <th style="padding:12px 20px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($registrants as $i => $reg)
                <tr>
                    <td style="padding:12px 20px;color:#9ca3af;font-size:12px;">{{ $registrants->firstItem() + $i }}</td>
                    <td style="padding:12px 20px;">
                        <span style="font-weight:700;font-size:12px;color:#1a56db;font-family:monospace;">{{ $reg->registration_number }}</span>
                    </td>
                    <td style="padding:12px 20px;">
                        <div style="font-weight:600;font-size:13px;color:#111827;">{{ $reg->name }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $reg->nisn }}</div>
                    </td>
                    <td style="padding:12px 20px;font-size:13px;">{{ $reg->previous_school }}</td>
                    <td style="padding:12px 20px;font-size:13px;">{{ $reg->major ? $reg->major->name : '-' }}</td>
                    <td style="padding:12px 20px;">
                        <span class="status-badge badge-{{ $reg->status }}">
                            {{ $reg->status === 'pending' ? 'Menunggu' : ($reg->status === 'verified' ? 'Terverifikasi' : 'Ditolak') }}
                        </span>
                    </td>
                    <td style="padding:12px 20px;font-size:12px;color:#6b7280;">{{ $reg->created_at ? $reg->created_at->format('d/m/Y') : '-' }}</td>
                    <td style="padding:12px 20px;">
                        <a href="{{ route('admin.registrants.show', $reg->id) }}" class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-weight:600;font-size:12px;">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#9ca3af;">
                        <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                        Tidak ada data pendaftar.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($registrants->hasPages())
    <div style="padding:16px 24px;border-top:1px solid #f3f4f6;">
        {{ $registrants->links() }}
    </div>
    @endif
</div>
@endsection
