@extends('layouts.frontend')

@section('title', 'Program Pilihan')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Pilihan Program</div>
            <h1 class="section-title">Jurusan / Program Studi</h1>
            <p class="section-description">Pilih jalur pendidikan yang sesuai dengan minat dan cita-citamu untuk masa depan yang gemilang.</p>
        </div>

        <div class="majors-grid" style="max-width: 900px; margin: 0 auto;">
            @forelse($majors as $major)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 28px; padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='var(--shadow-lg)';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-sm)';">
                    <div style="width: 100%; aspect-ratio: 16/10; border-radius: 20px; overflow: hidden; margin-bottom: 1.5rem;">
                        <img src="{{ Str::startsWith($major->image_path, 'http') ? $major->image_path : asset($major->image_path ?? '') }}" 
                             alt="{{ $major->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 0.5rem 0.5rem 1rem;">
                        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 0.75rem; color: #0f172a;">{{ $major->name }}</h3>
                        <p style="font-size: 1rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 0;">{{ $major->description }}</p>
                    </div>
                </div>
            @empty
                <p style="grid-column: span 2; text-align: center; color: #888;">Belum ada data jurusan.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
