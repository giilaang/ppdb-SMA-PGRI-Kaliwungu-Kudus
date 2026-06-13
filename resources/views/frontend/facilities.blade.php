@extends('layouts.frontend')

@section('title', 'Sarana & Prasarana')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Fasilitas Sekolah</div>
            <h1 class="section-title">Sarana &amp; Prasarana</h1>
            <p class="section-description">Kami berkomitmen menyediakan fasilitas terbaik untuk mendukung proses belajar mengajar yang efektif dan menyenangkan.</p>
        </div>

        <div class="facilities-grid">
            @forelse($facilities as $facility)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 28px; padding: 1.25rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='var(--shadow-lg)';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-sm)';">
                    <div style="width: 100%; aspect-ratio: 16/10; border-radius: 18px; overflow: hidden; margin-bottom: 1.25rem;">
                        <img src="{{ Str::startsWith($facility->image_path, 'http') ? $facility->image_path : asset($facility->image_path) }}" 
                             alt="{{ $facility->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 0.5rem 0.5rem 1rem;">
                        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.35rem; font-weight: 700; margin-bottom: 0.75rem; color: #0f172a;">{{ $facility->name }}</h3>
                        <p style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 0;">{{ $facility->description }}</p>
                    </div>
                </div>
            @empty
                <p style="grid-column: span 3; text-align: center; color: #888;">Belum ada data fasilitas.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
