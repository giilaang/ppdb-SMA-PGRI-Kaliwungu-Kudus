@extends('layouts.frontend')

@section('title', $announcement->title)

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <!-- Breadcrumb / Back button -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('announcements.index') }}" style="text-decoration: none; color: var(--text-secondary); font-weight: 600; display: inline-flex; align-items: center; gap: 8px; font-family: 'Outfit', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-secondary)'">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pengumuman
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1.4fr 0.6fr; gap: 3.5rem;" class="ppdb-info-grid">
            <!-- Main Content -->
            <div>
                <div style="margin-bottom: 2.5rem; background: #fff8e6; padding: 2.5rem; border-radius: 28px; border: 1px solid rgba(255, 204, 0, 0.3);">
                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 1rem; flex-wrap: wrap;">
                        <span style="background: #ef4444; color: white; font-weight: 700; padding: 3px 10px; border-radius: 8px; font-size: 0.8rem; text-transform: uppercase;">
                            PENTING
                        </span>
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
                            📅 {{ $announcement->published_at ? $announcement->published_at->format('d M Y') : $announcement->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <h1 style="font-family: 'Outfit', sans-serif; font-size: clamp(1.85rem, 3.5vw, 2.5rem); font-weight: 800; color: #0f172a; line-height: 1.3; margin: 0;">
                        {{ $announcement->title }}
                    </h1>
                </div>

                <div style="font-size: 1.1rem; color: var(--text-secondary); line-height: 1.8; white-space: pre-line; font-family: 'Plus Jakarta Sans', sans-serif; margin-bottom: 3rem;">
                    {!! $announcement->content !!}
                </div>

                @if($announcement->file_path)
                    <div style="background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0; padding: 1.75rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background: rgba(255, 204, 0, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.5rem;">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 2px 0;">Lampiran Dokumen</h4>
                                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Unduh berkas resmi pengumuman ini.</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $announcement->file_path) }}" target="_blank" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: none; font-size: 0.85rem; padding: 0.85rem 1.5rem; border-radius: 12px;">
                            <i class="fa-solid fa-download"></i> Unduh Lampiran
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside>
                <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2rem; position: sticky; top: 100px;">
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; border-bottom: 2px solid var(--accent); padding-bottom: 0.5rem;">
                        Pengumuman Lainnya
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        @forelse($latestAnnouncements as $latest)
                            <a href="{{ route('announcements.show', $latest->id) }}" style="text-decoration: none; display: block; group" class="sidebar-ann-link">
                                <h4 style="font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #0f172a; line-height: 1.35; margin: 0 0 4px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.3s;" class="latest-title">
                                    {{ $latest->title }}
                                </h4>
                                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">
                                    📅 {{ $latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y') }}
                                </span>
                            </a>
                        @empty
                            <p style="font-size: 0.9rem; color: var(--text-muted); text-align: center; margin: 0;">Tidak ada pengumuman lainnya.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
.sidebar-ann-link:hover .latest-title {
    color: var(--accent) !important;
}
</style>
@endsection
