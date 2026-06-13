@extends('layouts.admin')
@section('title', 'Galeri Foto')
@section('page-title', 'Kelola Galeri Foto Sekolah')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;border:none;background:#d1fae5;color:#065f46;font-weight:500;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card-section mb-4">
    <div class="card-section-header">
        <h3 class="card-section-title">🖼️ Galeri Foto Sekolah</h3>
        <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal" style="padding:8px 18px;font-size:13px;">
            <i class="bi bi-plus-lg me-1"></i>Tambah Foto
        </button>
    </div>
    <div class="card-section-body">
        @if($galleries->isEmpty())
        <div style="text-align:center;padding:50px;color:#9ca3af;">
            <i class="bi bi-images" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;font-weight:500;">Belum ada foto di galeri.</div>
            <div style="font-size:12px;margin-top:4px;">Klik tombol "Tambah Foto" di atas untuk menambahkan foto pertama Anda.</div>
        </div>
        @else
        <div class="row g-4">
            @foreach($galleries as $g)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;background:#fff;border:1px solid #e5e7eb !important;">
                    <div style="position:relative;padding-top:66%;background:#f3f4f6;overflow:hidden;">
                        <img src="{{ asset($g->image_path) }}" alt="{{ $g->title ?? 'Foto Galeri' }}"
                             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .3s;"
                             onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <span style="position:absolute;top:10px;left:10px;background:rgba(0,0,0,.6);color:#fff;font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;backdrop-filter:blur(4px);letter-spacing:.3px;text-transform:uppercase;">
                            {{ $g->category }}
                        </span>
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <h5 style="font-size:13.5px;font-weight:700;color:#111827;margin-bottom:12px;line-height:1.4;flex:1;">
                            {{ $g->title ?: '(Tanpa Judul)' }}
                        </h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#editModal{{ $g->id }}" style="font-size:11px;font-weight:600;border-radius:6px;padding:5px;">
                                <i class="bi bi-pencil-fill me-1"></i>Edit
                            </button>
                            <form method="POST" action="{{ route('admin.galleries.destroy', $g->id) }}" class="flex-fill" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" style="font-size:11px;font-weight:600;border-radius:6px;padding:5px;">
                                    <i class="bi bi-trash-fill me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModal{{ $g->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $g->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15);">
                        <div class="modal-header" style="background:linear-gradient(135deg,#1a56db,#1e40af);color:#fff;border-radius:16px 16px 0 0;border:none;">
                            <h5 class="modal-title" id="editModalLabel{{ $g->id }}" style="font-weight:700;">✏️ Edit Foto Galeri</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.galleries.update', $g->id) }}" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="modal-body" style="padding:24px;">
                                <div class="mb-3">
                                    <label class="form-label">Judul Foto (Opsional)</label>
                                    <input type="text" name="title" class="form-control" value="{{ $g->title }}" placeholder="Masukkan judul foto...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="category" class="form-select" required>
                                        <option value="Kegiatan" {{ $g->category == 'Kegiatan' ? 'selected' : '' }}>Kegiatan Sekolah</option>
                                        <option value="Fasilitas" {{ $g->category == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                        <option value="Prestasi" {{ $g->category == 'Prestasi' ? 'selected' : '' }}>Prestasi & Alumni</option>
                                        <option value="Lingkungan" {{ $g->category == 'Lingkungan' ? 'selected' : '' }}>Lingkungan Sekolah</option>
                                        <option value="Lainnya" {{ !in_array($g->category, ['Kegiatan', 'Fasilitas', 'Prestasi', 'Lingkungan']) ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div class="mb-3 text-field-category-edit" style="display:{{ !in_array($g->category, ['Kegiatan', 'Fasilitas', 'Prestasi', 'Lingkungan']) ? 'block' : 'none' }};">
                                    <label class="form-label">Kategori Kustom</label>
                                    <input type="text" name="custom_category" class="form-control" value="{{ $g->category }}" placeholder="Tulis nama kategori...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ganti Foto (Kosongkan jika tidak ingin mengganti)</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <div style="font-size:11px;color:#9ca3af;margin-top:6px;">Format: JPG, JPEG, PNG. Maks: 2MB.</div>
                                </div>
                                <div class="mt-2 text-center">
                                    <label class="form-label d-block text-start">Foto Saat Ini:</label>
                                    <img src="{{ asset($g->image_path) }}" style="max-height:150px;border-radius:8px;border:1px solid #e5e7eb;">
                                </div>
                            </div>
                            <div class="modal-footer" style="border:none;padding:16px 24px;gap:8px;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:8px;font-weight:600;">Batal</button>
                                <button type="submit" class="btn-primary-custom" style="padding:10px 24px;">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15);">
            <div class="modal-header" style="background:linear-gradient(135deg,#1a56db,#1e40af);color:#fff;border-radius:16px 16px 0 0;border:none;">
                <h5 class="modal-title" id="createModalLabel" style="font-weight:700;">➕ Tambah Foto Galeri</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding:24px;">
                    <div class="mb-3">
                        <label class="form-label">Judul Foto (Opsional)</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul foto...">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" id="categorySelectCreate" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="Kegiatan" selected>Kegiatan Sekolah</option>
                            <option value="Fasilitas">Fasilitas</option>
                            <option value="Prestasi">Prestasi & Alumni</option>
                            <option value="Lingkungan">Lingkungan Sekolah</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3" id="customCategoryWrapperCreate" style="display:none;">
                        <label class="form-label">Kategori Kustom <span class="text-danger">*</span></label>
                        <input type="text" name="custom_category" id="customCategoryInputCreate" class="form-control" placeholder="Tulis nama kategori...">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Foto <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div style="font-size:11px;color:#9ca3af;margin-top:6px;">Format: JPG, JPEG, PNG. Maks: 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:16px 24px;gap:8px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:8px;font-weight:600;">Batal</button>
                    <button type="submit" class="btn-primary-custom" style="padding:10px 24px;">Tambah Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Create Modal Category Switcher
        const categorySelectCreate = document.getElementById('categorySelectCreate');
        const customCategoryWrapperCreate = document.getElementById('customCategoryWrapperCreate');
        const customCategoryInputCreate = document.getElementById('customCategoryInputCreate');

        categorySelectCreate.addEventListener('change', () => {
            if (categorySelectCreate.value === 'Lainnya') {
                customCategoryWrapperCreate.style.display = 'block';
                customCategoryInputCreate.setAttribute('required', 'required');
            } else {
                customCategoryWrapperCreate.style.display = 'none';
                customCategoryInputCreate.removeAttribute('required');
            }
        });

        // Form Submit Category processing for create modal
        customCategoryWrapperCreate.closest('form').addEventListener('submit', function(e) {
            if (categorySelectCreate.value === 'Lainnya') {
                // Temporarily set the value of the main category select to the custom input's value
                // Or better, let's create a hidden input or do it with JS by setting option value.
                const customVal = customCategoryInputCreate.value.trim();
                if (customVal) {
                    const option = document.createElement('option');
                    option.value = customVal;
                    option.text = customVal;
                    option.selected = true;
                    categorySelectCreate.appendChild(option);
                }
            }
        });

        // Edit Modal Category Switcher mapping
        document.querySelectorAll('[id^="editModal"]').forEach(modal => {
            const select = modal.querySelector('select[name="category"]');
            const customWrapper = modal.querySelector('.text-field-category-edit');
            const customInput = modal.querySelector('input[name="custom_category"]');

            select.addEventListener('change', () => {
                if (select.value === 'Lainnya') {
                    customWrapper.style.display = 'block';
                    customInput.setAttribute('required', 'required');
                } else {
                    customWrapper.style.display = 'none';
                    customInput.removeAttribute('required');
                }
            });

            modal.querySelector('form').addEventListener('submit', function(e) {
                if (select.value === 'Lainnya') {
                    const customVal = customInput.value.trim();
                    if (customVal) {
                        const option = document.createElement('option');
                        option.value = customVal;
                        option.text = customVal;
                        option.selected = true;
                        select.appendChild(option);
                    }
                }
            });
        });
    });
</script>
@endpush
