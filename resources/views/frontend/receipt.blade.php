@extends('layouts.frontend')

@section('title', 'Bukti Pendaftaran - ' . $registrant->registration_number)

@push('styles')
<style>
  body { background: #f0f2f5; }
  .receipt-wrapper {
    max-width: 720px; margin: 30px auto; padding: 0 16px;
  }
  .receipt-card {
    background: #fff; border-radius: 16px; overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,.12);
  }
  .receipt-header {
    background: linear-gradient(135deg, #1c1917 0%, var(--accent) 100%);
    color: #fff; padding: 28px 36px; display: flex; align-items: center; gap: 20px;
  }
  .receipt-header img { width: 64px; height: 64px; border-radius: 12px; object-fit: cover; border: 3px solid rgba(255,255,255,.3); }
  .receipt-header-text h2 { font-size: 18px; font-weight: 800; margin: 0 0 4px; font-family: 'Outfit', 'Poppins', sans-serif; }
  .receipt-header-text p { font-size: 13px; opacity: 0.85; margin: 0; }
  .receipt-body { padding: 32px 36px; }
  .receipt-number {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 2px solid #f59e0b; border-radius: 12px; padding: 16px 24px;
    text-align: center; margin-bottom: 28px;
  }
  .receipt-number p { font-size: 12px; color: #b45309; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 4px; }
  .receipt-number h3 { font-size: 24px; font-weight: 900; color: #78350f; margin: 0; font-family: 'Outfit', 'Poppins', sans-serif; letter-spacing: 2px; }
  .receipt-status {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; margin-top: 8px;
  }
  .status-pending { background: #fef3c7; color: #92400e; }
  .status-verified { background: #d1fae5; color: #065f46; }
  .status-rejected { background: #fee2e2; color: #991b1b; }
 
  .receipt-section { margin-bottom: 24px; }
  .receipt-section h4 { font-size: 14px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 14px; }
  .receipt-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px 24px; }
  .receipt-field label { font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 3px; }
  .receipt-field p { font-size: 14px; color: #111827; font-weight: 500; margin: 0; }
 
  .receipt-notice {
    background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px;
    font-size: 13px; color: #78350f;
  }
  .btn-print { background: var(--accent); color: #fff; border: none; border-radius: 10px; padding: 12px 28px; font-size: 14px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-family: 'Outfit', 'Poppins', sans-serif; transition: all 0.3s ease; }
  .btn-print:hover { background: var(--accent-dark); color: #fff; }
  .btn-back { background: #f3f4f6; color: #374151; border: none; border-radius: 10px; padding: 12px 22px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif; transition: all 0.3s ease; }
  .btn-back:hover { background: #e5e7eb; color: #0f172a; }
  .receipt-footer { padding: 20px 36px; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }

  @media print {
    body { background: #fff; }
    .no-print { display: none !important; }
    .receipt-card { box-shadow: none; border: 1px solid #ccc; }
    .receipt-wrapper { margin: 0; max-width: 100%; }
  }
</style>
@endpush

@section('content')
<div class="receipt-wrapper">
  <div class="receipt-card">
    <!-- Header -->
    <div class="receipt-header">
      <img src="{{ asset('images/ppdb/logo-smakaliwungu.jpeg') }}" alt="Logo" onerror="this.style.display='none'">
      <div class="receipt-header-text">
        <h2>BUKTI PENDAFTARAN PPDB</h2>
        <p>SMA PGRI KALIWUNGU KUDUS &bull; Tahun Ajaran {{ $registrant->academicYear->year ?? '-' }}</p>
      </div>
    </div>

    <!-- Body -->
    <div class="receipt-body">
      <!-- Registration Number -->
      <div class="receipt-number">
        <p>Nomor Pendaftaran Anda</p>
        <h3>{{ $registrant->registration_number }}</h3>
        <div class="receipt-status status-{{ $registrant->status }}">
          @if($registrant->status === 'pending') ⏳ Menunggu Verifikasi
          @elseif($registrant->status === 'verified') ✅ Terverifikasi
          @else ❌ Ditolak @endif
        </div>
      </div>

      <!-- Notice -->
      <div class="receipt-notice">
        ⚠️ <strong>Penting:</strong> Simpan atau cetak bukti pendaftaran ini. Tunjukkan nomor pendaftaran <strong>{{ $registrant->registration_number }}</strong> kepada panitia saat datang ke sekolah untuk verifikasi berkas.
      </div>

      <!-- Data Siswa -->
      <div class="receipt-section">
        <h4>📋 Data Calon Siswa</h4>
        <div class="receipt-grid">
          <div class="receipt-field">
            <label>Nama Lengkap</label>
            <p>{{ $registrant->name }}</p>
          </div>
          <div class="receipt-field">
            <label>NISN</label>
            <p>{{ $registrant->nisn }}</p>
          </div>
          <div class="receipt-field">
            <label>Tempat, Tanggal Lahir</label>
            <p>{{ $registrant->place_of_birth }}, {{ $registrant->date_of_birth ? $registrant->date_of_birth->format('d/m/Y') : '-' }}</p>
          </div>
          <div class="receipt-field">
            <label>Jenis Kelamin</label>
            <p>{{ $registrant->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
          </div>
          <div class="receipt-field">
            <label>Nomor HP</label>
            <p>{{ $registrant->phone_number }}</p>
          </div>
          <div class="receipt-field">
            <label>Nama Orang Tua/Wali</label>
            <p>{{ $registrant->parent_name }}</p>
          </div>
          <div class="receipt-field" style="grid-column:span 2;">
            <label>Alamat</label>
            <p>{{ $registrant->address }}</p>
          </div>
          <div class="receipt-field">
            <label>Asal Sekolah</label>
            <p>{{ $registrant->previous_school }}</p>
          </div>
          <div class="receipt-field">
            <label>Jurusan Pilihan</label>
            <p>{{ $registrant->major->name ?? '-' }}</p>
          </div>
        </div>
      </div>

      <!-- Info -->
      <div class="receipt-section">
        <h4>📞 Informasi Kontak Panitia</h4>
        <div class="receipt-grid">
          @if($contact)
          <div class="receipt-field">
            <label>WhatsApp Panitia</label>
            <p>+{{ $contact->whatsapp }}</p>
          </div>
          <div class="receipt-field">
            <label>Email Resmi</label>
            <p>{{ $contact->email }}</p>
          </div>
          <div class="receipt-field" style="grid-column:span 2;">
            <label>Alamat Sekolah</label>
            <p>{{ $contact->address }}</p>
          </div>
          @endif
        </div>
      </div>

      <div style="font-size:12px;color:#9ca3af;border-top:1px solid #e5e7eb;padding-top:14px;">
        Terdaftar pada: {{ $registrant->created_at ? $registrant->created_at->format('d/m/Y H:i') : '-' }}
      </div>
    </div>

    <!-- Footer Buttons -->
    <div class="receipt-footer no-print">
      <a href="{{ route('home') }}" class="btn-back">← Kembali ke Beranda</a>
      <button onclick="window.print()" class="btn-print">🖨️ Cetak Bukti Pendaftaran</button>
    </div>
  </div>
</div>
@endsection
