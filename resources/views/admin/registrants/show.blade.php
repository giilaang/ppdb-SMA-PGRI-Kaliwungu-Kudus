@extends('layouts.admin')
@section('title', 'Detail Pendaftar - ' . $registrant->registration_number)
@section('page-title', 'Detail Pendaftar')

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <h3 class="card-section-title">📋 Data Lengkap Pendaftar</h3>
                <span class="status-badge badge-{{ $registrant->status }}" style="font-size:13px;padding:6px 14px;">
                    {{ $registrant->status === 'pending' ? '⏳ Menunggu' : ($registrant->status === 'verified' ? '✅ Terverifikasi' : '❌ Ditolak') }}
                </span>
            </div>
            <div class="card-section-body">
                <div style="background:#f0f9ff;border:2px solid #0ea5e9;border-radius:12px;padding:16px 24px;text-align:center;margin-bottom:24px;">
                    <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#0369a1;margin:0 0 4px;">Nomor Pendaftaran</p>
                    <p style="font-size:26px;font-weight:900;color:#0c4a6e;margin:0;font-family:monospace;letter-spacing:2px;">{{ $registrant->registration_number }}</p>
                    <a href="{{ route('receipt', $registrant->registration_number) }}" target="_blank" style="font-size:12px;color:#0369a1;margin-top:6px;display:inline-block;">🖨️ Cetak Bukti Pendaftaran</a>
                </div>

                <div class="row g-3">
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Nama Lengkap</label><p style="font-weight:600;margin:0;">{{ $registrant->name }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">NISN</label><p style="font-weight:600;margin:0;font-family:monospace;">{{ $registrant->nisn }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Tempat Lahir</label><p style="margin:0;">{{ $registrant->place_of_birth }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Tanggal Lahir</label><p style="margin:0;">{{ $registrant->date_of_birth ? $registrant->date_of_birth->format('d/m/Y') : '-' }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Jenis Kelamin</label><p style="margin:0;">{{ $registrant->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">No. HP</label><p style="margin:0;">{{ $registrant->phone_number }}</p></div></div>
                    <div class="col-12"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Alamat</label><p style="margin:0;">{{ $registrant->address }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Asal Sekolah</label><p style="margin:0;">{{ $registrant->previous_school }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Nama Orang Tua/Wali</label><p style="margin:0;">{{ $registrant->parent_name }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Jurusan Pilihan</label><p style="font-weight:700;color:#1a56db;margin:0;">{{ $registrant->major ? $registrant->major->name : '-' }}</p></div></div>
                    <div class="col-md-6"><div class="receipt-field"><label style="font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;">Tahun Ajaran</label><p style="margin:0;">{{ $registrant->academicYear ? $registrant->academicYear->year : '-' }}</p></div></div>
                </div>

                @if($registrant->status === 'rejected' && $registrant->rejection_reason)
                <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:10px;padding:14px 18px;margin-top:20px;">
                    <strong style="color:#991b1b;font-size:13px;">Alasan Penolakan:</strong>
                    <p style="margin:4px 0 0;color:#991b1b;font-size:13px;">{{ $registrant->rejection_reason }}</p>
                </div>
                @endif

                <!-- Documents -->
                <div style="margin-top:24px;padding-top:20px;border-top:1px solid #e5e7eb;">
                    <h4 style="font-size:14px;font-weight:700;color:#374151;margin-bottom:14px;">📄 Berkas Dokumen</h4>
                    <div class="row g-2">
                        @foreach(['ijazah' => 'Ijazah/SKHUN', 'akta' => 'Akta Lahir', 'kk' => 'Kartu Keluarga', 'foto' => 'Pas Foto'] as $type => $label)
                        @php $docField = 'document_' . $type; @endphp
                        <div class="col-md-6">
                            <div style="border:1.5px solid #e5e7eb;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                <span style="font-size:13px;font-weight:600;">{{ $label }}</span>
                                @if($registrant->$docField)
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.registrants.document.view', [$registrant->id, $type]) }}" target="_blank" class="btn btn-sm" style="background:#dbeafe;color:#1e40af;border-radius:6px;font-size:11px;font-weight:600;padding:4px 10px;">Lihat</a>
                                    <a href="{{ route('admin.registrants.document.download', [$registrant->id, $type]) }}" class="btn btn-sm" style="background:#d1fae5;color:#065f46;border-radius:6px;font-size:11px;font-weight:600;padding:4px 10px;">Unduh</a>
                                </div>
                                @else
                                <span style="font-size:11px;color:#9ca3af;">Belum diunggah</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Panel -->
    <div class="col-lg-4">
        <div class="card-section mb-3">
            <div class="card-section-header">
                <h3 class="card-section-title">✅ Verifikasi Status</h3>
            </div>
            <div class="card-section-body">
                <form method="POST" action="{{ route('admin.registrants.verify', $registrant->id) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select name="status" id="verifyStatus" class="form-select" onchange="toggleRejectionReason(this.value)">
                            <option value="verified" {{ $registrant->status === 'verified' ? 'selected' : '' }}>✅ Terverifikasi</option>
                            <option value="rejected" {{ $registrant->status === 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>
                    <div id="rejectionReasonDiv" class="mb-3" style="{{ $registrant->status !== 'rejected' ? 'display:none;' : '' }}">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Tulis alasan penolakan...">{{ $registrant->rejection_reason }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">Simpan Status</button>
                </form>
            </div>
        </div>

        <div class="card-section">
            <div class="card-section-header">
                <h3 class="card-section-title">🔗 Aksi</h3>
            </div>
            <div class="card-section-body" style="display:flex;flex-direction:column;gap:10px;">
                <a href="{{ route('receipt', $registrant->registration_number) }}" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2 justify-content-center" style="border-radius:8px;font-weight:600;">
                    <i class="bi bi-printer"></i> Cetak Bukti
                </a>
                <a href="{{ route('admin.registrants.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2 justify-content-center" style="border-radius:8px;font-weight:600;">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
                @if(auth()->user()->role === 'super_admin')
                <form method="POST" action="{{ route('admin.registrants.destroy', $registrant->id) }}" onsubmit="return confirm('Hapus pendaftar ini? Semua berkasnya juga akan ikut terhapus.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm w-100 d-flex align-items-center gap-2 justify-content-center" style="background:#fee2e2;color:#dc2626;border:none;border-radius:8px;font-weight:600;padding:8px;">
                        <i class="bi bi-trash"></i> Hapus Data
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleRejectionReason(value) {
    document.getElementById('rejectionReasonDiv').style.display = value === 'rejected' ? 'block' : 'none';
}
</script>
@endpush
@endsection
