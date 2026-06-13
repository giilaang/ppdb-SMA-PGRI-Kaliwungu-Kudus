@extends('layouts.admin')
@section('title', 'Fasilitas')
@section('page-title', 'Manajemen Fasilitas Sekolah')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">➕ Tambah Fasilitas</h3></div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.facilities.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3"><label class="form-label">Nama Fasilitas *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                    <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Foto Fasilitas * (Max 2MB)</label><input type="file" name="image" class="form-control" accept="image/*" required></div>
                    <button type="submit" class="btn-primary-custom w-100">Tambah Fasilitas</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">🏫 Daftar Fasilitas ({{ $facilities->count() }})</h3></div>
            <div class="card-section-body row g-3">
                @forelse($facilities as $facility)
                <div class="col-md-6">
                    <div style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                        <img src="{{ Str::startsWith($facility->image_path, 'http') ? $facility->image_path : asset($facility->image_path ?? '') }}" style="width:100%;height:130px;object-fit:cover;" alt="{{ $facility->name }}" onerror="this.style.background='#f3f4f6';this.src=''">
                        <div style="padding:12px;">
                            <div style="font-weight:700;font-size:14px;margin-bottom:4px;">{{ $facility->name }}</div>
                            <div style="font-size:12px;color:#6b7280;">{{ Str::limit($facility->description, 80) }}</div>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;font-weight:600;" data-bs-toggle="modal" data-bs-target="#editFac{{ $facility->id }}">Edit</button>
                                <form method="POST" action="{{ route('admin.facilities.destroy', $facility->id) }}" onsubmit="return confirm('Hapus fasilitas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border-radius:6px;font-size:12px;font-weight:600;">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editFac{{ $facility->id }}" tabindex="-1">
                        <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;">
                            <div class="modal-header border-0"><h5 class="modal-title fw-bold">Edit Fasilitas</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                            <form method="POST" action="{{ route('admin.facilities.update', $facility->id) }}" enctype="multipart/form-data">
                                @csrf @method('PATCH')
                                <div class="modal-body">
                                    <div class="mb-3"><label class="form-label">Nama *</label><input type="text" name="name" class="form-control" value="{{ $facility->name }}" required></div>
                                    <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea name="description" class="form-control" rows="4" required>{{ $facility->description }}</textarea></div>
                                    <div class="mb-0"><label class="form-label">Foto Baru (opsional)</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn-primary-custom">Simpan</button>
                                </div>
                            </form>
                        </div></div>
                    </div>
                </div>
                @empty
                <p style="text-align:center;color:#9ca3af;padding:20px;grid-column:span 2;">Belum ada data fasilitas.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
