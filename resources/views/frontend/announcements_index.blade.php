@extends('layouts.frontend')

@section('title', 'Daftar Pengumuman')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Informasi Penting</div>
            <h1 class="section-title">Pengumuman Resmi</h1>
            <p class="section-description">Informasi terbaru mengenai sistem PPDB, jadwal akademik, dan pengumuman resmi lainnya dari SMA PGRI Kaliwungu Kudus.</p>
        </div>

        <div class="announcement-grid" style="margin-bottom: 3rem;">
            @forelse($announcements as $ann)
                <a href="{{ route('announcements.show', $ann->id) }}" class="announcement-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div class="announcement-meta" style="margin-bottom: 1rem;">
                            <span class="announcement-badge" style="background: #fff2f2; color: #ef4444; font-weight: 700; padding: 2px 8px; border-radius: 6px; font-size: 0.75rem; text-transform: uppercase;">
                                PENTING
                            </span>
                            <span class="announcement-date" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">
                                {{ $ann->published_at ? $ann->published_at->format('d M Y') : $ann->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <h4 class="announcement-title" style="font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 0.75rem; line-height: 1.4;">
                            {{ $ann->title }}
                        </h4>
                        <p class="announcement-text" style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 1.5rem;">
                            {{ Str::limit(strip_tags($ann->content), 140) }}
                        </p>
                    </div>

                    @if($ann->file_path)
                        <span class="announcement-file" style="font-size: 0.85rem; color: var(--accent-dark); font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                            📎 Lampiran tersedia
                        </span>
                    @endif
                </a>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 4rem; color: var(--text-muted);">
                    <i class="fa-solid fa-bullhorn" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: var(--accent);"></i>
                    <p>Belum ada pengumuman yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $announcements->links() }}
        </div>
    </div>
</section>
@endsection
