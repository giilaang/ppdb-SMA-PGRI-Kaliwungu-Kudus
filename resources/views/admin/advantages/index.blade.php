@extends('layouts.admin')
@section('title', 'Keunggulan')
@section('page-title', 'Manajemen Keunggulan Sekolah')

@section('content')
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">➕ Tambah Keunggulan</h3></div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.advantages.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul *</label>
                        <input type="text" name="title" class="form-control" placeholder="Misal: Akademik Unggul" required value="{{ old('title') }}">
                        @error('title') <div style="color:#ef4444;font-size:12px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi *</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ikon SVG *</label>
                        <textarea name="icon" class="form-control" rows="3" placeholder="Tempelkan kode SVG di sini..." required>{{ old('icon') }}</textarea>
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Bisa pakai kode SVG dari heroicons.com atau feathericons.com</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $advantages->count() + 1) }}" min="1">
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">Tambah Keunggulan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card-section">
            <div class="card-section-header"><h3 class="card-section-title">⭐ Daftar Keunggulan ({{ $advantages->count() }})</h3></div>
            <div class="card-section-body" style="display:flex;flex-direction:column;gap:12px;">
                @forelse($advantages as $adv)
                <div style="border:1.5px solid #e5e7eb;border-radius:12px;padding:16px;background:#fafafa;">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width:40px;height:40px;border-radius:10px;background:#dbeafe;color:#1d4ed8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{!! $adv->icon !!}</div>
                            <div>
                                <div style="font-weight:700;font-size:14px;color:#111827;">{{ $adv->title }}</div>
                                <div style="font-size:12px;color:#6b7280;margin-top:2px;">{{ $adv->description }}</div>
                                <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Urutan: {{ $adv->order }}</div>
                            </div>
                        </div>
                        <div class="d-flex gap-2" style="flex-shrink:0;">
                            <button type="button" class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;" data-bs-toggle="modal" data-bs-target="#editAdv{{ $adv->id }}">Edit</button>
                            <form method="POST" action="{{ route('admin.advantages.destroy', $adv->id) }}" onsubmit="return confirm('Hapus keunggulan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border-radius:6px;font-size:12px;">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editAdv{{ $adv->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="border-radius:16px;">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Keunggulan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.advantages.update', $adv->id) }}">
                                @csrf @method('PATCH')
                                <div class="modal-body">
                                    <div class="mb-3"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ $adv->title }}" required></div>
                                    <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea name="description" class="form-control" rows="3" required>{{ $adv->description }}</textarea></div>
                                    <div class="mb-3"><label class="form-label">Ikon SVG *</label><textarea name="icon" class="form-control" rows="3" required>{{ $adv->icon }}</textarea></div>
                                    <div class="mb-0"><label class="form-label">Urutan</label><input type="number" name="order" class="form-control" value="{{ $adv->order }}" min="1"></div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn-primary-custom">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align:center;color:#9ca3af;padding:20px;">Belum ada data keunggulan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
