@extends('layouts.admin')
@section('title', 'Manajemen Pengumuman')
@section('page-title', 'Manajemen Pengumuman Resmi')

@section('content')
<div class="row g-3">
    <!-- Form Tambah Pengumuman (Kiri) -->
    <div class="col-lg-4">
        <div class="card-section" style="position: sticky; top: 80px;">
            <div class="card-section-header">
                <h3 class="card-section-title">📢 Tambah Pengumuman</h3>
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
                <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Pengumuman *</label>
                        <input type="text" name="title" class="form-control" required value="{{ old('title') }}" placeholder="Masukkan judul pengumuman...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten / Isi Pengumuman *</label>
                        <textarea name="content" class="form-control" rows="8" required placeholder="Tulis isi pengumuman di sini...">{{ old('content') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lampiran Berkas <span style="font-size:11px;color:#9ca3af;">(Opsional, Maks 5MB)</span></label>
                        <input type="file" name="file" class="form-control">
                        <div class="form-text">Bisa berupa PDF, Gambar, atau Dokumen.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Publikasi *</label>
                        <input type="datetime-local" name="published_at" class="form-control" required value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold" for="is_active" style="font-size: 13.5px; color: #1e293b;">
                            Aktifkan / Tampilkan Pengumuman
                        </label>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">Tambah Pengumuman</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Pengumuman (Kanan) -->
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <h3 class="card-section-title">📢 Daftar Pengumuman ({{ $announcements->total() }})</h3>
            </div>
            <div class="card-section-body">
                <div class="table-responsive">
                    <table class="table table-modern align-middle" style="min-width: 600px;">
                        <thead>
                            <tr>
                                <th>Pengumuman</th>
                                <th style="width: 100px; text-align: center;">Status</th>
                                <th style="width: 140px;">Tanggal Publikasi</th>
                                <th style="width: 120px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $ann)
                            <tr>
                                <td>
                                    <div class="fw-bold" style="font-size: 14px; color: #1e293b;">{{ $ann->title }}</div>
                                    @if($ann->file_path)
                                    <div style="margin-top: 4px;">
                                        <a href="{{ asset($ann->file_path) }}" target="_blank"
                                           class="badge bg-light text-primary border border-primary text-decoration-none d-inline-flex align-items-center gap-1"
                                           style="font-size: 10.5px; padding: 4px 8px;">
                                            <i class="bi bi-paperclip"></i> Lihat Lampiran
                                        </a>
                                    </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($ann->is_active)
                                    <span class="status-badge badge-open">Aktif</span>
                                    @else
                                    <span class="status-badge badge-closed">Mati</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-size: 12px; font-weight: 500; color: #475569;">
                                        {{ $ann->published_at ? $ann->published_at->format('d M Y, H:i') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-sm"
                                                style="background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 12px; font-weight: 600;"
                                                onclick="openAnnPanel({{ $ann->id }})">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.announcements.destroy', $ann->id) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
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
                                    Belum ada data pengumuman. Tulis pengumuman pertama Anda di form sebelah kiri.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($announcements->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $announcements->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     EDIT PANEL — single panel, AJAX-loaded content
     ============================================================ --}}
<div id="annEditPanel" style="
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
        <button onclick="closeAnnPanel()" style="
            position: absolute; top: 1rem; right: 1rem;
            background: #f1f5f9; border: none; border-radius: 8px;
            width: 36px; height: 36px; font-size: 18px;
            cursor: pointer; color: #64748b;
            display: flex; align-items: center; justify-content: center;
        ">×</button>

        <h5 class="fw-bold mb-4">✏️ Edit Pengumuman</h5>

        <div id="annSpinner" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="mt-2 text-muted" style="font-size:13px;">Memuat data pengumuman...</div>
        </div>

        <form id="annEditForm" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Judul Pengumuman *</label>
                <input type="text" id="annTitle" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konten / Isi Pengumuman *</label>
                <textarea id="annContent" name="content" class="form-control" rows="10" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ganti Berkas Lampiran <span style="font-size:11px;color:#9ca3af;">(opsional)</span></label>
                    <div id="annCurrentFile" style="margin-bottom:8px;"></div>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Publikasi *</label>
                    <input type="datetime-local" id="annPublishedAt" name="published_at" class="form-control" required>
                </div>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="is_active" id="annIsActive" value="1">
                <label class="form-check-label fw-semibold" for="annIsActive" style="font-size: 13.5px; color: #1e293b;">
                    Aktifkan / Tampilkan Pengumuman
                </label>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" onclick="closeAnnPanel()" class="btn btn-light" style="border-radius:8px;">Batal</button>
                <button type="submit" class="btn-primary-custom">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const annRouteBase = '{{ url("admin/pengumuman") }}';

async function openAnnPanel(id) {
    const panel   = document.getElementById('annEditPanel');
    const spinner = document.getElementById('annSpinner');
    const form    = document.getElementById('annEditForm');

    panel.style.display = 'block';
    document.body.style.overflow = 'hidden';
    spinner.style.display = 'block';
    form.style.display = 'none';

    try {
        const resp = await fetch(`${annRouteBase}/${id}/edit-data`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        if (!resp.ok) throw new Error('Gagal memuat data pengumuman.');
        const data = await resp.json();

        form.action = `${annRouteBase}/${id}`;
        document.getElementById('annTitle').value       = data.title;
        document.getElementById('annContent').value     = data.content;
        document.getElementById('annPublishedAt').value = data.published_at_local;
        document.getElementById('annIsActive').checked  = data.is_active;

        const fileDiv = document.getElementById('annCurrentFile');
        if (data.file_url) {
            fileDiv.innerHTML = `<a href="${data.file_url}" target="_blank" class="badge bg-light text-primary border border-primary text-decoration-none d-inline-flex align-items-center gap-1" style="font-size:11px;padding:4px 8px;"><i class="bi bi-paperclip"></i> ${data.file_name}</a><div style="font-size:11px;color:#6b7280;margin-top:4px;">Berkas saat ini</div>`;
        } else {
            fileDiv.innerHTML = '';
        }

        spinner.style.display = 'none';
        form.style.display = 'block';

    } catch (e) {
        spinner.innerHTML = `<div class="text-danger">${e.message}</div>`;
    }
}

function closeAnnPanel() {
    document.getElementById('annEditPanel').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('annEditPanel').addEventListener('click', function(e) {
    if (e.target === this) closeAnnPanel();
});
</script>
@endpush
