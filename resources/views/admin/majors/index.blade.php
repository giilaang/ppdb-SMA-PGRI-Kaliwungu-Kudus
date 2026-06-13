@extends('layouts.admin')
@section('title', 'Jurusan')
@section('page-title', 'Manajemen Jurusan / Program Studi')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">➕ Tambah Jurusan</h3></div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.majors.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3"><label class="form-label">Nama Jurusan *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="Misal: MIPA, IPS, Bahasa">@error('name')<div style="color:#ef4444;font-size:12px;">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Foto Jurusan * (Max 2MB)</label><input type="file" name="image" class="form-control" accept="image/*" required></div>
                    <button type="submit" class="btn-primary-custom w-100">Tambah Jurusan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">🎓 Daftar Jurusan ({{ $majors->count() }})</h3></div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead><tr><th style="padding:12px 20px;">Jurusan</th><th style="padding:12px 20px;">Slug</th><th style="padding:12px 20px;">Deskripsi</th><th style="padding:12px 20px;">Aksi</th></tr></thead>
                    <tbody>
                    @forelse($majors as $major)
                        <tr>
                            <td style="padding:12px 20px;">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ Str::startsWith($major->image_path, 'http') ? $major->image_path : asset($major->image_path ?? '') }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;" onerror="this.style.display='none'">
                                    <span style="font-weight:700;">{{ $major->name }}</span>
                                </div>
                            </td>
                            <td style="padding:12px 20px;"><code style="font-size:12px;background:#f3f4f6;padding:2px 6px;border-radius:4px;">{{ $major->slug }}</code></td>
                            <td style="padding:12px 20px;font-size:13px;color:#6b7280;">{{ Str::limit($major->description, 80) }}</td>
                            <td style="padding:12px 20px;">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;" data-bs-toggle="modal" data-bs-target="#editMajor{{ $major->id }}">Edit</button>
                                    <form method="POST" action="{{ route('admin.majors.destroy', $major->id) }}" onsubmit="return confirm('Hapus jurusan {{ $major->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border-radius:6px;font-size:12px;">Hapus</button>
                                    </form>
                                </div>
                                <div class="modal fade" id="editMajor{{ $major->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content" style="border-radius:16px;">
                                    <div class="modal-header border-0"><h5 class="modal-title fw-bold">Edit Jurusan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <form method="POST" action="{{ route('admin.majors.update', $major->id) }}" enctype="multipart/form-data">
                                        @csrf @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3"><label class="form-label">Nama *</label><input type="text" name="name" class="form-control" value="{{ $major->name }}" required></div>
                                            <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea name="description" class="form-control" rows="4" required>{{ $major->description }}</textarea></div>
                                            <div class="mb-0"><label class="form-label">Foto Baru (opsional)</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                                        </div>
                                        <div class="modal-footer border-0"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom">Simpan</button></div>
                                    </form>
                                </div></div></div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:40px;color:#9ca3af;">Belum ada data jurusan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
