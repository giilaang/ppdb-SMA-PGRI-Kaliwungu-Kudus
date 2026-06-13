@extends('layouts.frontend')

@section('title', 'Brosur & Informasi')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Layanan Informasi</div>
            <h1 class="section-title">Download Brosur &amp; Alur</h1>
            <p class="section-description">Unduh brosur resmi Penerimaan Peserta Didik Baru (PPDB) SMA PGRI Kaliwungu Kudus untuk melihat detail program, biaya, dan panduan lengkap.</p>
        </div>

        <div class="brochure-container" style="max-width: 700px; margin: 0 auto; background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; text-align: center;">
            <div style="width: 80px; height: 80px; background: rgba(0, 170, 255, 0.1); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 2rem; color: var(--accent);">
                <i class="fa-solid fa-file-pdf" style="font-size: 2.5rem; color: #ef4444;"></i>
            </div>
            
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-bottom: 0.75rem;">Brosur Resmi PPDB Tahun {{ $activeYear ? $activeYear->year : '' }}</h3>
            <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.7; max-width: 500px; margin: 0 auto 2.5rem;">
                Brosur ini berisi informasi program keahlian, program beasiswa, fasilitas, rincian biaya pendaftaran, serta persyaratan pendaftaran fisik dan online.
            </p>

            @if(session('error'))
                <div class="alert-ppdb error" style="margin-bottom: 20px; text-align: left;">⚠️ {{ session('error') }}</div>
            @endif

            <div class="brochure-actions">
                <a href="{{ route('brochure.download') }}" class="btn-primary" style="padding: 1rem 2.5rem; border: none; cursor: pointer; text-decoration: none;">
                    📥 Download Sekarang (PDF)
                </a>
                <a href="{{ route('home') }}" class="btn-secondary" style="padding: 1rem 2.5rem; text-decoration: none;">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
