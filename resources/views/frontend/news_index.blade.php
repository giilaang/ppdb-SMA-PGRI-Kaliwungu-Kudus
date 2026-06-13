@extends('layouts.frontend')

@section('title', 'Kabar & Berita')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Kabar Sekolah</div>
            <h1 class="section-title">Berita Rilis Terkini</h1>
            <p class="section-description">Ikuti perkembangan kegiatan, prestasi, dan aktivitas terbaru di SMA PGRI Kaliwungu Kudus.</p>
        </div>

        <div class="news-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 3rem;">
            @forelse($news as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="news-card" style="text-decoration: none;">
                    <div class="news-image-wrapper">
                        <img src="{{ $item->image_path ? (Str::startsWith($item->image_path, 'http') ? $item->image_path : asset($item->image_path)) : asset('images/ppdb/logo-smakaliwungu.jpeg') }}" 
                             alt="{{ $item->title }}">
                    </div>
                    <div class="news-content-wrapper">
                        <span class="news-date">
                            📅 {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                        </span>
                        <h3 class="news-title">
                            {{ $item->title }}
                        </h3>
                        <p class="news-excerpt">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                    </div>
                </a>
            @empty
                <div style="grid-column: span 2; text-align: center; padding: 4rem; color: var(--text-muted);">
                    <i class="fa-regular fa-newspaper" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: var(--accent);"></i>
                    <p>Belum ada berita yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $news->links() }}
        </div>
    </div>
</section>
@endsection
