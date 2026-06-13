@extends('layouts.frontend')

@section('title', 'Hubungi Kami & Pengaduan')

@section('content')
<section style="padding: 5rem 0; background: #ffffff;">
    <div class="section-container">
        <div class="section-header">
            <div class="section-label">Hubungi Kami</div>
            <h1 class="section-title">Kontak &amp; Layanan Pengaduan</h1>
            <p class="section-description">Panitia PPDB SMA PGRI Kaliwungu Kudus siap melayani pertanyaan, pengaduan, dan kendala pendaftaran Anda.</p>
        </div>

        <div class="contact-grid" style="align-items: start; margin-bottom: 4rem;">
            <!-- Contact details -->
            <div class="contact-card" style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.55rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem;">Informasi Kontak Resmi</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.75rem;">
                    @if($contact)
                        <div style="display: flex; gap: 1.25rem;">
                            <div style="width: 48px; height: 48px; background: rgba(0, 170, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;">
                                <i class="fa-solid fa-envelope" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">Surel Resmi (Email)</h4>
                                <p style="font-size: 1rem; color: var(--text-secondary); margin: 0;">{{ $contact->email }}</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1.25rem;">
                            <div style="width: 48px; height: 48px; background: rgba(37, 211, 102, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #25d366; flex-shrink: 0;">
                                <i class="fa-brands fa-whatsapp" style="font-size: 1.35rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">WhatsApp Panitia PPDB</h4>
                                <p style="font-size: 1rem; color: var(--text-secondary); margin: 0;">+{{ $contact->whatsapp }}</p>
                                <a href="https://wa.me/{{ $contact->whatsapp }}?text=Halo%20Panitia%20PPDB%2C%20saya%20ingin%20bertanya%20mengenai%20pendaftaran." 
                                   target="_blank" 
                                   style="font-size: 0.9rem; color: #25D366; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 4px;">
                                   Chat Sekarang →
                                </a>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1.25rem;">
                            <div style="width: 48px; height: 48px; background: rgba(0, 170, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;">
                                <i class="fa-solid fa-location-dot" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">Alamat Sekolah</h4>
                                <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin: 0;">{{ $contact->address }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Simple inquiry and complaint form -->
            <div class="contact-card" style="background: #f8fafc; border-radius: 28px; border: 1px solid #e2e8f0;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.55rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem;">Form Pengaduan &amp; Pertanyaan</h3>
                
                <form id="complaintForm" onsubmit="sendWhatsAppComplaint(event)">
                    <div class="form-group-ppdb">
                        <label for="comp_name">Nama Pengirim *</label>
                        <input type="text" id="comp_name" placeholder="Nama Lengkap Anda" required>
                    </div>
                    <div class="form-group-ppdb">
                        <label for="comp_phone">No. HP / WhatsApp *</label>
                        <input type="text" id="comp_phone" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group-ppdb">
                        <label for="comp_message">Pesan / Pengaduan *</label>
                        <textarea id="comp_message" rows="4" placeholder="Tuliskan kendala, saran, pengaduan, atau pertanyaan Anda di sini secara detail..." required></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width: 100%; border: none; justify-content: center; font-size: 15px; cursor: pointer;">
                        Kirim via WhatsApp →
                    </button>
                </form>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="maps-container" style="border-radius: 28px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm); position: relative;">
            @if($contact && $contact->google_maps_iframe)
                {!! $contact->google_maps_iframe !!}
            @else
                <iframe
                    width="100%"
                    height="100%"
                    style="border:0;"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://maps.google.com/maps?q=SMA%20PGRI%20Kaliwungu%20Kudus&t=h&z=18&ie=UTF8&iwloc=&output=embed">
                </iframe>
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
function sendWhatsAppComplaint(e) {
    e.preventDefault();
    const name = document.getElementById('comp_name').value;
    const phone = document.getElementById('comp_phone').value;
    const message = document.getElementById('comp_message').value;
    
    const waNumber = "{{ $contact ? $contact->whatsapp : '628812942590' }}";
    const waMessage = `Halo Panitia PPDB SMA PGRI Kaliwungu Kudus,%0A%0ASaya ingin mengirimkan pesan/pengaduan sebagai berikut:%0A%0A- Nama: ${encodeURIComponent(name)}%0A- No. HP: ${encodeURIComponent(phone)}%0A- Pesan: ${encodeURIComponent(message)}`;
    
    window.open(`https://wa.me/${waNumber}?text=${waMessage}`, '_blank');
}
</script>
@endpush
@endsection
