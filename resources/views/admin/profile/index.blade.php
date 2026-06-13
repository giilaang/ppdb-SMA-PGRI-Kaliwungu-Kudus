@extends('layouts.admin')
@section('title', 'Profil Sekolah')
@section('page-title', 'Edit Profil Sekolah')

@section('content')
<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">🏫 Deskripsi & Visi Misi</h3></div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Sekolah *</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $profile->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visi *</label>
                        <textarea name="vision" class="form-control" rows="3" required>{{ old('vision', $profile->vision) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Misi * <span style="font-size:11px;color:#9ca3af;">(pisahkan per baris dengan angka)</span></label>
                        <textarea name="mission" class="form-control" rows="5" required>{{ old('mission', $profile->mission) }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Sejarah Sekolah *</label>
                        <textarea name="history" class="form-control" rows="4" required>{{ old('history', $profile->history) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-section">
                <div class="card-section-header"><h3 class="card-section-title">👤 Sambutan Kepala Sekolah</h3></div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kepala Sekolah *</label>
                        <input type="text" name="principal_welcome_name" class="form-control" value="{{ old('principal_welcome_name', $profile->principal_welcome_name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan / Gelar *</label>
                        <input type="text" name="principal_welcome_title" class="form-control" value="{{ old('principal_welcome_title', $profile->principal_welcome_title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teks Sambutan *</label>
                        <textarea name="principal_welcome_text" class="form-control" rows="5" required>{{ old('principal_welcome_text', $profile->principal_welcome_text) }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Foto Kepala Sekolah (Max 2MB)</label>
                        @if($profile->principal_welcome_photo)
                        <div style="margin-bottom:8px;">
                            <img src="{{ Str::startsWith($profile->principal_welcome_photo, 'http') ? $profile->principal_welcome_photo : asset($profile->principal_welcome_photo) }}" style="width:80px;height:80px;object-fit:cover;border-radius:50%;border:3px solid #e5e7eb;" onerror="this.style.display='none'">
                            <div style="font-size:11px;color:#6b7280;margin-top:4px;">Foto saat ini</div>
                        </div>
                        @endif
                        <input type="file" name="principal_welcome_photo" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            
            <div class="card-section mt-4">
                <div class="card-section-header"><h3 class="card-section-title">🎥 Video Profil Sekolah</h3></div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Upload File Video (Max 50MB)</label>
                        <input type="file" name="video" class="form-control @error('video') is-invalid @enderror" accept="video/*">
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div style="font-size:11px;color:#9ca3af;margin-top:6px;">
                            Format: <strong>MP4, WebM, Ogg, MOV, AVI</strong>. Ukuran maksimum file: <strong>50MB</strong>.
                        </div>
                    </div>
                    @if($profile->video_path)
                    <div class="mt-3">
                        <label class="form-label d-block">Video Saat Ini:</label>
                        <div style="border-radius:10px;overflow:hidden;border:1.5px solid #e5e7eb;background:#000;">
                            <video width="100%" controls style="max-height:300px;display:block;">
                                <source src="{{ asset($profile->video_path) }}">
                                Browser Anda tidak mendukung pemutar video HTML5.
                            </video>
                        </div>
                        <div style="font-size:11px;color:#6b7280;margin-top:6px;">
                            Path berkas: <code>{{ $profile->video_path }}</code>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn-primary-custom" style="padding:12px 32px;">💾 Simpan Profil Sekolah</button>
        </div>
    </div>
</form>
@endsection
