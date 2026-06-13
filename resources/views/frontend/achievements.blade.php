@extends('layouts.frontend')

@section('title', 'Prestasi Siswa')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Prestasi Siswa</div>
            <h1 class="section-title">Kisah Sukses &amp; Prestasi</h1>
            <p class="section-description">Siswa-siswi kami didorong untuk mengeksplorasi bakat mereka dan mengukir prestasi gemilang baik tingkat regional maupun nasional.</p>
        </div>

        <div class="achievements-grid">
            @forelse($achievements as $ach)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 28px; padding: 2.25rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='var(--shadow-lg)';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-sm)';">
                    <div>
                        <div style="color: var(--accent); font-size: 1.1rem; margin-bottom: 1.25rem;">★★★★★</div>
                        <p style="font-size: 1.05rem; font-style: italic; color: var(--text-secondary); line-height: 1.65; margin-bottom: 2rem;">"{{ $ach->description }}"</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1.25rem; border-top: 1px solid #e2e8f0; padding-top: 1.25rem;">
                        <div style="width: 54px; height: 54px; border-radius: 50%; overflow: hidden; border: 3px solid #ffffff; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                            <img src="{{ Str::startsWith($ach->image_path, 'http') ? $ach->image_path : asset($ach->image_path ?? '') }}" 
                                 alt="{{ $ach->title }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <div style="font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 0.15rem;">{{ $ach->title }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Tahun {{ $ach->year }}, {{ $ach->level }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <p style="grid-column: span 3; text-align: center; color: #888;">Belum ada data prestasi.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
