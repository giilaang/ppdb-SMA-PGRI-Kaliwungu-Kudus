@extends('layouts.admin')
@section('title', 'Prestasi & Alumni')
@section('page-title', 'Manajemen Prestasi & Alumni')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">➕ Tambah Prestasi</h3></div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.achievements.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3"><label class="form-label">Nama / Judul *</label><input type="text" name="title" class="form-control" required value="{{ old('title') }}" placeholder="Nama siswa atau judul prestasi"></div>
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6"><label class="form-label">Tahun *</label><input type="text" name="year" class="form-control" required value="{{ old('year', date('Y')) }}" maxlength="4"></div>
                            <div class="col-6"><label class="form-label">Tingkat *</label><input type="text" name="level" class="form-control" required value="{{ old('level') }}" placeholder="Kabupaten / Provinsi"></div>
                        </div>
                    </div>
                    <div class="mb-3"><label class="form-label">Deskripsi / Kutipan *</label><textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Foto *</label><input type="file" name="image" class="form-control" accept="image/*" required></div>
                    <button type="submit" class="btn-primary-custom w-100">Tambah Prestasi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">🏆 Daftar Prestasi ({{ $achievements->count() }})</h3></div>
            <div class="card-section-body row g-3">
                @forelse($achievements as $ach)
                <div class="col-md-6">
                    <div style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                        <img src="{{ Str::startsWith($ach->image_path, 'http') ? $ach->image_path : asset($ach->image_path ?? '') }}" style="width:100%;height:120px;object-fit:cover;" onerror="this.style.display='none'" alt="{{ $ach->title }}">
                        <div style="padding:12px;">
                            <div style="font-weight:700;font-size:14px;">{{ $ach->title }}</div>
                            <div style="font-size:12px;color:#6b7280;">{{ $ach->year }} | {{ $ach->level }}</div>
                            <div style="font-size:12px;color:#9ca3af;margin-top:4px;">{{ Str::limit($ach->description, 70) }}</div>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;" data-bs-toggle="modal" data-bs-target="#editAch{{ $ach->id }}">Edit</button>
                                <form method="POST" action="{{ route('admin.achievements.destroy', $ach->id) }}" onsubmit="return confirm('Hapus prestasi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border-radius:6px;font-size:12px;">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editAch{{ $ach->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content" style="border-radius:16px;">
                        <div class="modal-header border-0"><h5 class="modal-title fw-bold">Edit Prestasi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <form method="POST" action="{{ route('admin.achievements.update', $ach->id) }}" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="modal-body">
                                <div class="mb-3"><label class="form-label">Nama/Judul *</label><input type="text" name="title" class="form-control" value="{{ $ach->title }}" required></div>
                                <div class="mb-3 row g-2">
                                    <div class="col-6"><label class="form-label">Tahun *</label><input type="text" name="year" class="form-control" value="{{ $ach->year }}" required maxlength="4"></div>
                                    <div class="col-6"><label class="form-label">Tingkat *</label><input type="text" name="level" class="form-control" value="{{ $ach->level }}" required></div>
                                </div>
                                <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea name="description" class="form-control" rows="4" required>{{ $ach->description }}</textarea></div>
                                <div class="mb-0"><label class="form-label">Foto Baru (opsional)</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                            </div>
                            <div class="modal-footer border-0"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom">Simpan</button></div>
                        </form>
                    </div></div></div>
                </div>
                @empty
                <p style="text-align:center;color:#9ca3af;padding:20px;">Belum ada data prestasi.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
