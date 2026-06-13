@extends('layouts.admin')
@section('title', 'Kontak Sekolah')
@section('page-title', 'Kelola Kontak & Informasi Sosial Sekolah')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;border:none;background:#d1fae5;color:#065f46;font-weight:500;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="POST" action="{{ route('admin.contacts.update') }}">
    @csrf @method('PATCH')
    <div class="row g-4">
        {{-- Kontak Utama --}}
        <div class="col-lg-6">
            <div class="card-section h-100">
                <div class="card-section-header">
                    <h3 class="card-section-title">📞 Kontak Utama</h3>
                </div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                               placeholder="Contoh: 628812942590" value="{{ old('whatsapp', $contact->whatsapp) }}" required>
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">
                            Masukkan nomor dengan format kode negara tanpa karakter '+' atau spasi (contoh: 628812942590).
                        </div>
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Sekolah <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="Contoh: info@smapgrikaliwungu.sch.id" value="{{ old('email', $contact->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                  rows="4" required placeholder="Tuliskan alamat lengkap sekolah...">{{ old('address', $contact->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sosial Media --}}
        <div class="col-lg-6">
            <div class="card-section h-100">
                <div class="card-section-header">
                    <h3 class="card-section-title">🌐 Media Sosial (Opsional)</h3>
                </div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-instagram me-1 text-danger"></i> Link Instagram</label>
                        <input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror"
                               placeholder="https://instagram.com/smapgri..." value="{{ old('instagram', $contact->instagram) }}">
                        @error('instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-facebook me-1 text-primary"></i> Link Facebook</label>
                        <input type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror"
                               placeholder="https://facebook.com/smapgri..." value="{{ old('facebook', $contact->facebook) }}">
                        @error('facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-youtube me-1 text-danger"></i> Link YouTube</label>
                        <input type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror"
                               placeholder="https://youtube.com/c/smapgri..." value="{{ old('youtube', $contact->youtube) }}">
                        @error('youtube')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label"><i class="bi bi-tiktok me-1 text-dark"></i> Link TikTok</label>
                        <input type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror"
                               placeholder="https://tiktok.com/@smapgri..." value="{{ old('tiktok', $contact->tiktok) }}">
                        @error('tiktok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Google Maps --}}
        <div class="col-12">
            <div class="card-section">
                <div class="card-section-header">
                    <h3 class="card-section-title">📍 Google Maps Embed Iframe</h3>
                </div>
                <div class="card-section-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Iframe Google Maps</label>
                        <textarea name="google_maps_iframe" class="form-control @error('google_maps_iframe') is-invalid @enderror"
                                  rows="4" placeholder='Masukkan tag <iframe ...></iframe> dari Google Maps'>{{ old('google_maps_iframe', $contact->google_maps_iframe) }}</textarea>
                        @error('google_maps_iframe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div style="font-size:11px;color:#9ca3af;margin-top:6px;">
                            Buka Google Maps, cari lokasi sekolah, klik <strong>Bagikan (Share)</strong> -> <strong>Sematkan Peta (Embed a map)</strong>, lalu salin kode HTML-nya ke sini.
                        </div>
                    </div>

                    @if($contact->google_maps_iframe)
                    <div class="mt-3">
                        <label class="form-label d-block">Pratinjau Peta:</label>
                        <div style="height:300px;border-radius:10px;overflow:hidden;border:1.5px solid #e5e7eb;background:#f3f4f6;">
                            {!! $contact->google_maps_iframe !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="col-12">
            <button type="submit" class="btn-primary-custom" style="padding:12px 32px;">
                <i class="bi bi-save me-2"></i>Simpan Perubahan Kontak
            </button>
        </div>
    </div>
</form>

@endsection
