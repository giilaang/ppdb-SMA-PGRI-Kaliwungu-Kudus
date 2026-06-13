@extends('layouts.frontend')

@section('title', 'Layanan Pendaftaran PPDB Online')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Layanan Pendidikan</div>
            <h1 class="section-title">Pendaftaran PPDB Online</h1>
            <p class="section-description">Selamat datang di portal Penerimaan Peserta Didik Baru (PPDB) SMA PGRI Kaliwungu Kudus.</p>
        </div>

        <!-- Info Panels -->
        <div class="ppdb-info-grid" style="margin-bottom: 4rem;">
            <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2.5rem;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.45rem; font-weight: 700; margin-bottom: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                    📅 Jadwal Pendaftaran
                </h3>
                @if($ppdbSetting)
                    <div style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; white-space: pre-line;">
                        {{ $ppdbSetting->schedule_text }}
                    </div>
                @else
                    <p style="color: #64748b;">Belum ada jadwal yang diumumkan.</p>
                @endif
                
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.45rem; font-weight: 700; margin: 2rem 0 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                    💰 Biaya Pendaftaran
                </h3>
                @if($ppdbSetting)
                    <div style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; white-space: pre-line;">
                        {{ $ppdbSetting->fees_text }}
                    </div>
                @else
                    <p style="color: #64748b;">Biaya pendaftaran belum dikonfigurasi.</p>
                @endif
            </div>

            <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2.5rem;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.45rem; font-weight: 700; margin-bottom: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                    📄 Persyaratan Berkas
                </h3>
                @if($ppdbSetting)
                    <div style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; white-space: pre-line;">
                        {{ $ppdbSetting->requirements_text }}
                    </div>
                @else
                    <p style="color: #64748b;">Persyaratan pendaftaran belum diumumkan.</p>
                @endif

                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.45rem; font-weight: 700; margin: 2rem 0 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                    🔄 Alur Pendaftaran
                </h3>
                @if($ppdbSetting)
                    <div style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; white-space: pre-line;">
                        {{ $ppdbSetting->flow_text }}
                    </div>
                @else
                    <p style="color: #64748b;">Alur pendaftaran belum dikonfigurasi.</p>
                @endif
            </div>
        </div>

        <!-- PPDB Form Section -->
        <div id="pendaftaran-form" style="border-top: 1px solid #e2e8f0; padding-top: 4rem;">
            @if ($ppdbSetting && $ppdbSetting->status === 'open')
                <div class="section-header" style="margin-bottom: 3rem;">
                    <div class="section-label">Formulir Online</div>
                    <h2 style="font-family: 'Outfit', sans-serif; font-size: 2.25rem; font-weight: 800; color: #0f172a;">Isi Data Calon Siswa</h2>
                    <p class="section-description">Mohon lengkapi formulir pendaftaran di bawah ini dengan informasi yang sebenar-benarnya.</p>
                </div>

                @if (session('error'))
                    <div class="alert-ppdb error" style="max-width:800px; margin:0 auto 24px;">⚠️ {{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data"
                    style="max-width:800px;margin:0 auto;">
                    @csrf
                    <div class="form-card">
                        <h3 style="font-size:17px;font-weight:700;margin-bottom:24px;color:#1a1a2e;border-bottom:2px solid #e5e7eb;padding-bottom:12px;">
                            📋 Data Calon Siswa
                        </h3>

                        <div class="ppdb-form-row">
                            <div class="form-group-ppdb">
                                <label for="name">Nama Lengkap *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Sesuai Ijazah" required>
                                @error('name')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="nisn">NISN *</label>
                                <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="10 Digit NISN" maxlength="10" required>
                                @error('nisn')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="place_of_birth">Tempat Lahir *</label>
                                <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}" placeholder="Kudus" required>
                                @error('place_of_birth')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="date_of_birth">Tanggal Lahir *</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="gender">Jenis Kelamin *</label>
                                <select id="gender" name="gender" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="phone_number">Nomor HP / WhatsApp *</label>
                                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx" required>
                                @error('phone_number')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group-ppdb">
                            <label for="address">Alamat Lengkap *</label>
                            <textarea id="address" name="address" rows="2" placeholder="Jalan, Desa/Kelurahan, Kecamatan, Kabupaten/Kota" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ppdb-form-row">
                            <div class="form-group-ppdb">
                                <label for="previous_school">Asal Sekolah (SMP/MTs) *</label>
                                <input type="text" id="previous_school" name="previous_school" value="{{ old('previous_school') }}" placeholder="Nama SMP/MTs asal" required>
                                @error('previous_school')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="parent_name">Nama Orang Tua / Wali *</label>
                                <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" placeholder="Nama Ayah/Ibu/Wali" required>
                                @error('parent_name')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group-ppdb">
                            <label for="selected_major_id">Jurusan Pilihan *</label>
                            <select id="selected_major_id" name="selected_major_id" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}" {{ old('selected_major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                @endforeach
                            </select>
                            @error('selected_major_id')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <h3 style="font-size:16px;font-weight:700;margin:24px 0 16px;color:#1a1a2e;border-bottom:2px solid #e5e7eb;padding-bottom:12px;">
                            📄 Upload Berkas (Max. 2MB per file, format PDF/JPG/PNG)
                        </h3>

                        <div class="ppdb-form-row">
                            <div class="form-group-ppdb">
                                <label for="document_ijazah">Fotokopi Ijazah / SKHUN</label>
                                <input type="file" id="document_ijazah" name="document_ijazah" accept=".pdf,.jpg,.jpeg,.png">
                                @error('document_ijazah')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="document_akta">Fotokopi Akta Kelahiran</label>
                                <input type="file" id="document_akta" name="document_akta" accept=".pdf,.jpg,.jpeg,.png">
                                @error('document_akta')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="document_kk">Fotokopi Kartu Keluarga (KK)</label>
                                <input type="file" id="document_kk" name="document_kk" accept=".pdf,.jpg,.jpeg,.png">
                                @error('document_kk')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group-ppdb">
                                <label for="document_foto">Pas Foto 3x4 (Background Merah)</label>
                                <input type="file" id="document_foto" name="document_foto" accept=".jpg,.jpeg,.png">
                                @error('document_foto')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn-primary" style="width:100%;margin-top:12px;justify-content:center;font-size:15px; border: none; cursor: pointer;">
                            Kirim Pendaftaran →
                        </button>
                        <p style="text-align:center;font-size:12px;color:#888;margin-top:10px;">
                            Dengan mengirim formulir ini, Anda menyetujui data Anda akan diproses oleh panitia PPDB.
                        </p>
                    </div>
                </form>
            @else
                <div style="max-width: 600px; margin: 0 auto; text-align: center; background: #fff5f5; border: 1px solid #fee2e2; border-radius: 24px; padding: 3rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.45rem; font-weight: 700; color: #b91c1c; margin-bottom: 0.5rem;">Pendaftaran PPDB Ditutup</h3>
                    <p style="color: #991b1b; line-height: 1.6;">Pendaftaran online belum dibuka atau sudah ditutup untuk gelombang ini. Silakan hubungi panitia sekolah atau cek jadwal pendaftaran secara berkala.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
