@extends('layouts.frontend')

@section('title', 'Tentang SMA')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Profil Sekolah</div>
            <h1 class="section-title">Kenal Lebih Dekat Dengan Kami</h1>
            <p class="section-description">SMA PGRI Kaliwungu Kudus berkomitmen membentuk generasi cerdas, berkarakter, dan berprestasi.</p>
        </div>

        <div class="about-welcome-grid" style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 3rem; margin-bottom: 4rem; align-items: center;">
            <div>
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 700; margin-bottom: 1.5rem; color: #0f172a;">Sambutan Kepala Sekolah</h3>
                <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; margin-bottom: 1.5rem;">
                    {{ $profile ? $profile->principal_welcome_text : 'Selamat datang di SMA PGRI Kaliwungu Kudus. Kami menyambut hangat kehadiran Anda di website resmi kami.' }}
                </p>
                <div style="border-left: 4px solid var(--accent); padding-left: 1.25rem;">
                    <h5 style="font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">{{ $profile ? $profile->principal_welcome_name : 'Drs. H. Sukarno, M.Pd.' }}</h5>
                    <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">{{ $profile ? $profile->principal_welcome_title : 'Kepala Sekolah' }}</p>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ $profile && $profile->principal_welcome_photo ? (Str::startsWith($profile->principal_welcome_photo, 'http') ? $profile->principal_welcome_photo : asset($profile->principal_welcome_photo)) : asset('images/ppdb/logo-smakaliwungu.jpeg') }}" 
                     alt="Kepala Sekolah" 
                     style="width: 100%; max-width: 280px; border-radius: 24px; box-shadow: var(--shadow-md); border: 8px solid #ffffff;">
            </div>
        </div>

        <div class="about-vision-grid" style="margin-bottom: 4rem;">
            <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2.5rem;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; margin-bottom: 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                    👁️ Visi
                </h3>
                <p style="font-size: 1.1rem; color: var(--text-secondary); line-height: 1.7; font-weight: 500;">
                    {{ $profile ? $profile->vision : 'Mewujudkan generasi yang berakhlak mulia, unggul dalam prestasi, dan siap menghadapi tantangan global.' }}
                </p>
            </div>
            <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2.5rem;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; margin-bottom: 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                    📋 Misi
                </h3>
                <div style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; white-space: pre-line;">
                    {{ $profile ? $profile->mission : "1. Menyelenggarakan proses pembelajaran yang berbasis karakter dan keagamaan.\n2. Mengembangkan bakat akademik dan non-akademik siswa.\n3. Meningkatkan kualitas sarana prasarana penunjang." }}
                </div>
            </div>
        </div>

        <div style="margin-bottom: 4rem;">
            <div style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0; padding: 3rem;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; margin-bottom: 1.25rem; color: #0f172a;">📜 Sejarah Singkat</h3>
                <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75;">
                    {{ $profile ? $profile->history : 'SMA PGRI Kaliwungu didirikan untuk melayani kebutuhan pendidikan menengah atas di Kudus. Kami terus bertransformasi untuk memberikan pendidikan berkualitas tinggi bagi setiap anak didik.' }}
                </p>
            </div>
        </div>

        <div>
            <div class="section-header" style="margin-bottom: 3rem;">
                <div class="section-label">Keunggulan Kami</div>
                <h2 style="font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #0f172a;">Mengapa Memilih SMA PGRI Kaliwungu?</h2>
            </div>
            <div class="about-advantages-grid">
                @forelse($advantages as $adv)
                    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 24px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.3s;"
                         onmouseover="this.style.borderColor='var(--accent)'; this.style.transform='translateY(-5px)'"
                         onmouseout="this.style.borderColor='#e5e7eb'; this.style.transform='none'">
                        <div style="width: 50px; height: 50px; background: rgba(255, 204, 0, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; color: var(--accent);">
                            {!! $adv->icon !!}
                        </div>
                        <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $adv->title }}</h4>
                        <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;">{{ $adv->description }}</p>
                    </div>
                @empty
                    <p style="grid-column: span 3; text-align: center; color: #888;">Belum ada data keunggulan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
