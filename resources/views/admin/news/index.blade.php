@extends('layouts.admin')
@section('title', 'Manajemen Berita')
@section('page-title', 'Manajemen Berita Sekolah')

@section('content')
<div class="row g-3">
    <!-- Form Tambah Berita (Kiri) -->
    <div class="col-lg-4">
        <div class="card-section" style="position: sticky; top: 80px;">
            <div class="card-section-header">
                <h3 class="card-section-title">📰 Tambah Berita Rilis</h3>
            </div>
            <div class="card-section-body">
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <strong>Kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Berita *</label>
                        <input type="text" name="title" class="form-control" required value="{{ old('title') }}" placeholder="Masukkan judul berita...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten / Isi Berita *</label>
                        <textarea name="content" class="form-control" rows="8" required placeholder="Tulis isi berita di sini...">{{ old('content') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Utama (Maks 2MB)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Publikasi *</label>
                        <input type="datetime-local" name="published_at" class="form-control" required value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">Tambah Berita</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Berita (Kanan) -->
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <h3 class="card-section-title">📰 Daftar Berita ({{ $news->total() }})</h3>
            </div>
            <div class="card-section-body">
                <div class="table-responsive">
                    <table class="table table-modern align-middle" style="min-width: 600px;">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Gambar</th>
                                <th>Berita</th>
                                <th style="width: 140px;">Tanggal Publikasi</th>
                                <th style="width: 120px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($news as $item)
                            <tr>
                                <td>
                                    <img loading="lazy"
                                         src="{{ $item->image_path ? (Str::startsWith($item->image_path, 'http') ? $item->image_path : asset($item->image_path)) : asset('images/ppdb/logo-smakaliwungu.jpeg') }}"
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                         alt="{{ $item->title }}"
                                         onerror="this.src='{{ asset('images/ppdb/logo-smakaliwungu.jpeg') }}'">
                                </td>
                                <td>
                                    <div class="fw-bold" style="font-size: 14px; color: #1e293b;">{{ $item->title }}</div>
                                    <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                                        Slug: <code>{{ $item->slug }}</code>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size: 12px; font-weight: 500; color: #475569;">
                                        {{ $item->published_at ? $item->published_at->format('d M Y, H:i') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-sm"
                                                style="background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 12px; font-weight: 600;"
                                                onclick="openEditPanel({{ $item->id }})">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.news.destroy', $item->id) }}" onsubmit="return confirm('Hapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4" style="color: #94a3b8;">
                                    Belum ada data berita. Tulis berita pertama Anda di form sebelah kiri.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($news->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $news->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     EDIT PANEL — single panel, loaded via AJAX, no heavy modals
     ============================================================ --}}
<div id="editPanel" style="
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px);
    z-index: 9999;
    overflow-y: auto;
    padding: 2rem 1rem;
">
    <div style="
        background: #fff;
        border-radius: 16px;
        max-width: 720px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        box-shadow: 0 20px 60px rgba(0,0,0,.25);
    ">
        <button onclick="closeEditPanel()" style="
            position: absolute; top: 1rem; right: 1rem;
            background: #f1f5f9; border: none; border-radius: 8px;
            width: 36px; height: 36px; font-size: 18px;
            cursor: pointer; color: #64748b;
            display: flex; align-items: center; justify-content: center;
        ">×</button>

        <h5 class="fw-bold mb-4">✏️ Edit Berita</h5>

        {{-- Spinner shown while loading --}}
        <div id="editSpinner" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="mt-2 text-muted" style="font-size:13px;">Memuat data berita...</div>
        </div>

        {{-- Form shown after data loaded --}}
        <form id="editNewsForm" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Judul Berita *</label>
                <input type="text" id="editTitle" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konten / Isi Berita *</label>
                <textarea id="editContent" name="content" class="form-control" rows="10" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ganti Gambar <span style="font-size:11px;color:#9ca3af;">(opsional, maks 2MB)</span></label>
                    <div id="editCurrentImage" style="margin-bottom:8px;"></div>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Publikasi *</label>
                    <input type="datetime-local" id="editPublishedAt" name="published_at" class="form-control" required>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" onclick="closeEditPanel()" class="btn btn-light" style="border-radius:8px;">Batal</button>
                <button type="submit" class="btn-primary-custom">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// News data map: loaded on demand via fetch, not pre-rendered in HTML
const newsRouteBase = '{{ url("admin/berita") }}';

async function openEditPanel(id) {
    const panel = document.getElementById('editPanel');
    const spinner = document.getElementById('editSpinner');
    const form = document.getElementById('editNewsForm');

    panel.style.display = 'block';
    document.body.style.overflow = 'hidden';
    spinner.style.display = 'block';
    form.style.display = 'none';

    try {
        const resp = await fetch(`${newsRouteBase}/${id}/edit-data`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        if (!resp.ok) throw new Error('Gagal memuat data berita.');
        const data = await resp.json();

        form.action = `${newsRouteBase}/${id}`;
        document.getElementById('editTitle').value = data.title;
        document.getElementById('editContent').value = data.content;
        document.getElementById('editPublishedAt').value = data.published_at_local;

        const imgDiv = document.getElementById('editCurrentImage');
        if (data.image_url) {
            imgDiv.innerHTML = `<img src="${data.image_url}" style="width:100%;height:80px;object-fit:cover;border-radius:8px;" loading="lazy"><div style="font-size:11px;color:#6b7280;margin-top:4px;">Gambar saat ini</div>`;
        } else {
            imgDiv.innerHTML = `<div style="background:#f3f4f6;height:60px;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px;">Belum ada gambar</div>`;
        }

        spinner.style.display = 'none';
        form.style.display = 'block';

    } catch (e) {
        spinner.innerHTML = `<div class="text-danger">${e.message}</div>`;
    }
}

function closeEditPanel() {
    document.getElementById('editPanel').style.display = 'none';
    document.body.style.overflow = '';
}

// Close panel when clicking backdrop
document.getElementById('editPanel').addEventListener('click', function(e) {
    if (e.target === this) closeEditPanel();
});
</script>
@endpush
