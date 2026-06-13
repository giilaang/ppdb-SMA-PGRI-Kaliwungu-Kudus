@extends('layouts.frontend')

@section('title', $newsItem->title)

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <!-- Breadcrumb / Back button -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('news.index') }}" style="text-decoration: none; color: var(--text-secondary); font-weight: 600; display: inline-flex; align-items: center; gap: 8px; font-family: 'Outfit', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-secondary)'">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Berita
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1.4fr 0.6fr; gap: 3.5rem;" class="ppdb-info-grid">
            <!-- Main Content -->
            <div>
                <div style="margin-bottom: 1.5rem;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0.75rem;">
                        📅 {{ $newsItem->published_at ? $newsItem->published_at->format('d M Y') : $newsItem->created_at->format('d M Y') }}
                    </span>
                    <h1 style="font-family: 'Outfit', sans-serif; font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 800; color: #0f172a; line-height: 1.25; margin-bottom: 0;">
                        {{ $newsItem->title }}
                    </h1>
                </div>

                @if($newsItem->image_path)
                    <div style="border-radius: 24px; overflow: hidden; margin-bottom: 2.5rem; border: 1px solid #e2e8f0; box-shadow: var(--shadow-md);">
                        <img src="{{ Str::startsWith($newsItem->image_path, 'http') ? $newsItem->image_path : asset($newsItem->image_path) }}" 
                             alt="{{ $newsItem->title }}" 
                             style="width: 100%; height: auto; max-height: 480px; object-fit: cover; display: block;">
                    </div>
                @endif

                <div style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.8; white-space: pre-line; font-family: 'Plus Jakarta Sans', sans-serif;">
                    {!! $newsItem->content !!}
                </div>
            </div>

            <!-- Sidebar -->
            <aside>
                <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2rem; position: sticky; top: 100px;">
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; border-bottom: 2px solid var(--accent); padding-bottom: 0.5rem;">
                        Berita Lainnya
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @forelse($latestNews as $latest)
                            <a href="{{ route('news.show', $latest->slug) }}" style="text-decoration: none; display: flex; gap: 12px; align-items: start; group" class="sidebar-news-link">
                                <div style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden; flex-shrink: 0; border: 1px solid #e2e8f0;">
                                    <img src="{{ $latest->image_path ? (Str::startsWith($latest->image_path, 'http') ? $latest->image_path : asset($latest->image_path)) : asset('images/ppdb/logo-smakaliwungu.jpeg') }}" 
                                         alt="{{ $latest->title }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="flex-grow: 1;">
                                    <h4 style="font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #0f172a; line-height: 1.3; margin: 0 0 4px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.3s;" class="latest-title">
                                        {{ $latest->title }}
                                    </h4>
                                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">
                                        📅 {{ $latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p style="font-size: 0.9rem; color: var(--text-muted); text-align: center; margin: 0;">Tidak ada berita lainnya.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
.sidebar-news-link:hover .latest-title {
    color: var(--accent) !important;
}
</style>
@endsection
