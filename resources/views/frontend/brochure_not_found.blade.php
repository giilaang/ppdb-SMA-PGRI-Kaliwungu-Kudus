@extends('layouts.frontend')
@section('title', 'Brosur Tidak Tersedia')

@section('content')
<section style="
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 1.5rem;
    background: linear-gradient(135deg, #fefce8 0%, #fff7ed 100%);
">
    <div style="text-align: center; max-width: 520px; margin: 0 auto;">

        {{-- Icon --}}
        <div style="
            width: 100px; height: 100px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 40px rgba(245,158,11,.3);
        ">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 16 16">
                <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM8 6.982C9.664 6.309 11 4.986 11 3.5c0-1.38-1.32-2.5-3-2.5S5 2.12 5 3.5c0 1.486 1.336 2.809 3 3.482zM8 11a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0-7a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </svg>
        </div>

        {{-- Heading --}}
        <h1 style="
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 1rem;
            line-height: 1.3;
        ">Brosur Belum Tersedia</h1>

        <p style="
            font-size: 1rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2rem;
        ">{{ $message }}</p>

        {{-- Contact suggestion --}}
        @if($contact && $contact->whatsapp)
        <div style="
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            margin-bottom: 2rem;
        ">
            <p style="font-size: 13px; color: #94a3b8; margin-bottom: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em;">
                Hubungi Kami
            </p>
            <p style="font-size: 14px; color: #475569; margin-bottom: 1rem;">
                Untuk mendapatkan brosur, silakan hubungi panitia PPDB langsung melalui WhatsApp:
            </p>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->whatsapp) }}?text=Halo%20Panitia%20PPDB%2C%20saya%20ingin%20meminta%20brosur%20PPDB%202026/2027."
               target="_blank"
               style="
                   display: inline-flex;
                   align-items: center;
                   gap: .5rem;
                   background: #25d366;
                   color: white;
                   padding: .75rem 1.75rem;
                   border-radius: 50px;
                   text-decoration: none;
                   font-weight: 700;
                   font-size: 14px;
                   box-shadow: 0 4px 15px rgba(37,211,102,.35);
                   transition: transform .2s, box-shadow .2s;
               "
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 25px rgba(37,211,102,.45)'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 15px rgba(37,211,102,.35)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                </svg>
                Chat WhatsApp Sekarang
            </a>
        </div>
        @endif

        {{-- Back button --}}
        <a href="{{ url('/') }}" style="
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: .6rem 1.25rem;
            border-radius: 8px;
            background: white;
            border: 1.5px solid #e2e8f0;
            transition: all .2s;
        "
        onmouseover="this.style.borderColor='#f59e0b';this.style.color='#92400e'"
        onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b'">
            ← Kembali ke Beranda
        </a>
    </div>
</section>
@endsection
