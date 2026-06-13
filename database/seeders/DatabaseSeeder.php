<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AcademicYear;
use App\Models\SchoolProfile;
use App\Models\HeroSection;
use App\Models\Advantage;
use App\Models\Facility;
use App\Models\Major;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\SchoolContact;
use App\Models\PpdbSetting;
use App\Models\PpdbWave;
use App\Models\Brochure;
use App\Models\News;
use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users with Roles
        User::create([
            'name' => 'Super Admin PPDB',
            'email' => 'admin@smapgrikaliwungu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Admin PPDB Sekolah',
            'email' => 'ppdb@smapgrikaliwungu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin_ppdb',
        ]);

        User::create([
            'name' => 'Editor Konten',
            'email' => 'editor@smapgrikaliwungu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'editor_content',
        ]);

        // 2. Seed Academic Year
        $academicYear = AcademicYear::create([
            'year' => '2026/2027',
            'is_active' => true,
            'is_archived' => false,
        ]);

        // 3. Seed Hero Section for Active Academic Year
        HeroSection::create([
            'academic_year_id' => $academicYear->id,
            'title' => 'SMA PGRI KALIWUNGU KUDUS',
            'subtitle' => 'Segera bergabung bersama sekolah unggulan yang membentuk generasi cerdas, berkarakter, dan berprestasi.',
            'register_button_text' => 'Daftar Sekarang',
            'brochure_button_text' => 'Download Brosur',
            'banner_image_1' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1200',
            'banner_image_2' => 'https://images.unsplash.com/photo-1491841573634-28fb1172bff1?auto=format&fit=crop&q=80&w=1200',
            'banner_image_3' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1200',
        ]);

        // 4. Seed School Profile
        SchoolProfile::create([
            'description' => 'SMA PGRI Kaliwungu Kudus adalah sekolah menengah atas swasta yang berkomitmen tinggi dalam mencetak lulusan berakhlak mulia, cerdas, berkarakter, dan memiliki daya saing tinggi. Kami menawarkan lingkungan pendidikan yang terintegrasi untuk mempersiapkan siswa menuju perguruan tinggi terbaik maupun karier profesional.',
            'vision' => 'Mewujudkan generasi yang berakhlak mulia, unggul dalam prestasi, dan siap menghadapi tantangan global.',
            'mission' => "1. Menyelenggarakan proses pembelajaran yang berbasis karakter dan keagamaan.\n2. Mengembangkan bakat akademik dan non-akademik siswa melalui kurikulum yang adaptif.\n3. Meningkatkan kompetensi guru dan kualitas sarana prasarana penunjang.\n4. Membangun kemitraan dengan instansi pendidikan dan industri dalam penyiapan karier siswa.",
            'principal_welcome_name' => 'Drs. H. Sukarno, M.Pd.',
            'principal_welcome_title' => 'Kepala Sekolah SMA PGRI Kaliwungu',
            'principal_welcome_text' => 'Selamat datang di portal PPDB online SMA PGRI Kaliwungu Kudus. Kami menyambut hangat putra-putri terbaik bangsa untuk bergabung bersama kami di lingkungan belajar yang nyaman, disiplin, dan kaya akan prestasi. Mari bersama mewujudkan masa depan yang gemilang.',
            'principal_welcome_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=500',
            'history' => 'SMA PGRI Kaliwungu Kudus didirikan sejak puluhan tahun lalu di bawah naungan Yayasan PGRI. Kami terus bertransformasi mengikuti perkembangan kurikulum nasional dan teknologi untuk memastikan pelayanan pendidikan yang optimal kepada masyarakat Kaliwungu dan sekitarnya.',
            'video_path' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);

        // 5. Seed Advantages (Keunggulan)
        $advantages = [
            [
                'title' => 'Akademik Unggul',
                'description' => 'Kurikulum Merdeka yang disesuaikan dengan minat dan bakat siswa untuk prestasi maksimal.',
                'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
                'order' => 1,
            ],
            [
                'title' => 'Laboratorium Modern',
                'description' => 'Fasilitas laboratorium komputer, bahasa, dan sains dengan peralatan terbaru.',
                'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
                'order' => 2,
            ],
            [
                'title' => 'Beasiswa Prestasi',
                'description' => 'Program beasiswa bagi siswa berprestasi di bidang akademik maupun non-akademik.',
                'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',
                'order' => 3,
            ],
            [
                'title' => 'Ekstrakurikuler Luas',
                'description' => 'Lebih dari 25 pilihan kegiatan untuk mengasah minat, bakat, dan jiwa kepemimpinan.',
                'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'order' => 4,
            ],
            [
                'title' => 'Lingkungan Aman',
                'description' => 'Area sekolah yang asri, aman, dan dilengkapi dengan pengawasan CCTV 24 jam.',
                'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'order' => 5,
            ],
            [
                'title' => 'Perpustakaan Digital',
                'description' => 'Akses ke ribuan koleksi buku fisik dan digital untuk mendukung riset siswa.',
                'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                'order' => 6,
            ],
        ];
        foreach ($advantages as $advantage) {
            Advantage::create($advantage);
        }

        // 6. Seed Facilities (Sarana & Prasarana)
        Facility::create([
            'name' => 'Laboratorium Komputer',
            'description' => 'Ruangan ber-AC dengan 40 unit komputer spesifikasi tinggi untuk praktik TIK, pemrograman dasar, dan ujian berbasis komputer.',
            'image_path' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800',
        ]);
        Facility::create([
            'name' => 'Perpustakaan Digital',
            'description' => 'Ribuan koleksi buku fisik dan akses ke portal e-library nasional untuk mempermudah referensi belajar dan riset bagi para siswa.',
            'image_path' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&q=80&w=800',
        ]);
        Facility::create([
            'name' => 'Sarana Olahraga',
            'description' => 'Lapangan basket, voli, dan futsal standar nasional untuk menunjang kesehatan fisik serta kegiatan ekstrakurikuler olahraga.',
            'image_path' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&q=80&w=800',
        ]);

        // 7. Seed Majors (Jurusan)
        $mipa = Major::create([
            'name' => 'MIPA',
            'slug' => 'mipa',
            'description' => 'Matematika & Ilmu Pengetahuan Alam. Berfokus pada penguasaan sains, logika, dan analisis kuantitatif untuk persiapan masuk fakultas Kedokteran, Teknik, Statistika, dan Sains Murni.',
            'image_path' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=400',
        ]);
        $ips = Major::create([
            'name' => 'IPS',
            'slug' => 'ips',
            'description' => 'Ilmu Pengetahuan Sosial. Mengembangkan kemampuan analisis sosial, ekonomi, sosiologi, dan hukum untuk persiapan karier di bidang Bisnis, Manajemen, Hukum, Hubungan Internasional, dan Sospol.',
            'image_path' => 'https://images.unsplash.com/photo-1454165833762-0204b28c6731?auto=format&fit=crop&q=80&w=400',
        ]);

        // 8. Seed Achievements (Kisah Sukses / Prestasi)
        Achievement::create([
            'title' => 'Andini Putri',
            'year' => '2024',
            'level' => 'Nasional (Kelulusan SNBP)',
            'description' => 'Berhasil lulus jalur SNBP di Kedokteran UNDIP. Lingkungan belajarnya sangat mendukung untuk meraih mimpi.',
            'image_path' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=400',
        ]);
        Achievement::create([
            'title' => 'Budi Santoso',
            'year' => '2025',
            'level' => 'Provinsi (Juara Robotik)',
            'description' => 'Ekstrakurikuler robotik di sekolah ini luar biasa. Kami berhasil menjuarai tingkat provinsi. Fasilitas labnya sangat memadai.',
            'image_path' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=400',
        ]);
        Achievement::create([
            'title' => 'Citra Lestari',
            'year' => '2023',
            'level' => 'Nasional (Beasiswa LPDP)',
            'description' => 'Alumni berprestasi yang menerima program beasiswa penuh LPDP. Sekolah sangat mengutamakan kedisiplinan dan karakter.',
            'image_path' => 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&q=80&w=400',
        ]);

        // 9. Seed Galleries
        Gallery::create([
            'title' => 'Gedung Sekolah & Lapangan Basket',
            'category' => 'Sarana',
            'image_path' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&q=80&w=800',
        ]);
        Gallery::create([
            'title' => 'Laboratorium TIK Terpadu',
            'category' => 'Sarana',
            'image_path' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800',
        ]);
        Gallery::create([
            'title' => 'Kegiatan Belajar Kurikulum Merdeka',
            'category' => 'Kegiatan',
            'image_path' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800',
        ]);

        // 10. Seed School Contacts
        SchoolContact::create([
            'whatsapp' => '628812942590',
            'email' => 'ppdb@smapgrikaliwungu.sch.id',
            'address' => 'Jl. Raya Kaliwungu - Kudus, Kaliwungu, Kabupaten Kudus, Jawa Tengah, 59332',
            'google_maps_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0805096538676!2d110.80336217499616!3d-6.797284693192089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70c57c4c015b67%3A0x633d266e7a256958!2sSMA%20PGRI%20Kaliwungu!5e0!3m2!1sid!2sid!4v1715680000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'instagram' => 'https://instagram.com/smapgrikaliwungu',
            'facebook' => 'https://facebook.com/smapgrikaliwungu',
            'youtube' => 'https://youtube.com/c/smapgrikaliwungukudus',
            'tiktok' => 'https://tiktok.com/@smapgrikaliwungu',
        ]);

        // 11. Seed PPDB Settings for active academic year
        PpdbSetting::create([
            'academic_year_id' => $academicYear->id,
            'status' => 'open',
            'quota' => 120,
            'requirements_text' => "1. Fotokopi Ijazah & SKHUN (3 Lembar)\n2. Fotokopi Akta Kelahiran & Kartu Keluarga (KK)\n3. Pas Foto 3x4 (Background Merah)\n4. Mengisi Formulir Pendaftaran Online/Offline",
            'flow_text' => "1. Mengisi form pendaftaran secara online melalui website atau datang langsung ke sekolah.\n2. Mengunggah dokumen persyaratan (Ijazah, Akta Kelahiran, KK, dan Pas Foto).\n3. Mengikuti tes seleksi tertulis dan wawancara sesuai jadwal yang ditentukan.\n4. Melakukan daftar ulang setelah dinyatakan lulus seleksi.",
            'fees_text' => 'Pendaftaran PPDB di SMA PGRI Kaliwungu tidak dipungut biaya (GRATIS). Rincian biaya daftar ulang, seragam, dan SPP akan disampaikan secara tertulis saat pengumuman seleksi.',
            'schedule_text' => "Pendaftaran terbagi menjadi beberapa gelombang:\n- **Gelombang I**: Januari - Maret 2026\n- **Gelombang II**: April - Juni 2026\n- **Gelombang III**: Juli 2026 (apabila kuota belum terpenuhi)",
        ]);

        // 12. Seed PPDB Waves
        PpdbWave::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Gelombang I',
            'start_date' => '2026-01-01',
            'end_date' => '2026-03-31',
            'is_active' => false,
        ]);
        PpdbWave::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Gelombang II',
            'start_date' => '2026-04-01',
            'end_date' => '2026-06-30',
            'is_active' => true,
        ]);

        // 13. Seed Brochure for Active Year
        Brochure::create([
            'academic_year_id' => $academicYear->id,
            'title' => 'Brosur Penerimaan Siswa Baru 2026/2027',
            'file_path' => 'brochures/brosur_ppdb_2026.pdf',
            'is_active' => true,
        ]);

        // 14. Seed News
        News::create([
            'title' => 'Pelepasan Siswa Kelas XII SMA PGRI Kaliwungu Tahun Ajaran 2025/2026',
            'slug' => 'pelepasan-siswa-kelas-xii-sma-pgri-kaliwungu-tahun-ajaran-2025-2026',
            'content' => 'SMA PGRI Kaliwungu Kudus menggelar acara pelepasan siswa kelas XII dengan khidmat dan penuh kegembiraan. Acara ini dihadiri oleh komite sekolah, wali murid, dan segenap civitas akademika. Kepala sekolah berpesan agar alumni senantiasa menjaga nama baik almamater dan terus berjuang menggapai cita-cita mereka.',
            'image_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=800',
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Kunjungan Industri & Studi Banding Siswa ke Universitas di Jawa Tengah',
            'slug' => 'kunjungan-industri-studi-banding-siswa-ke-universitas',
            'content' => 'Dalam rangka meningkatkan wawasan akademik dan motivasi belajar, siswa kelas XI SMA PGRI Kaliwungu mengadakan kunjungan studi banding ke beberapa kampus besar di Jawa Tengah. Siswa diajak berkeliling melihat fasilitas riset, perpustakaan utama, dan berdiskusi dengan mahasiswa berprestasi.',
            'image_path' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800',
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Penyuluhan Bahaya Narkoba & Kenakalan Remaja bersama BNN Kudus',
            'slug' => 'penyuluhan-bahaya-narkoba-kenakalan-remaja-bersama-bnn-kudus',
            'content' => 'SMA PGRI Kaliwungu Kudus bekerjasama dengan Badan Narkotika Nasional (BNN) Kabupaten Kudus menyelenggarakan kegiatan penyuluhan pencegahan penyalahgunaan narkoba bagi siswa. Diharapkan lewat edukasi ini, siswa memahami risiko serta menjauhkan diri dari pergaulan bebas yang merusak masa depan.',
            'image_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=800',
            'published_at' => now(),
        ]);

        // 15. Seed Announcements
        Announcement::create([
            'title' => 'Pengumuman Seleksi Berkas Gelombang I PPDB 2026/2027',
            'content' => 'Diberitahukan kepada seluruh calon peserta didik baru yang telah mendaftar pada Gelombang I, bahwa hasil seleksi administrasi/berkas telah diumumkan di mading sekolah dan portal ini. Calon siswa yang dinyatakan lolos diharapkan segera melakukan daftar ulang berkas fisik di sekretariat PPDB sekolah.',
            'is_active' => true,
            'published_at' => now(),
        ]);

        Announcement::create([
            'title' => 'Jadwal Pelaksanaan Tes Wawancara PPDB Gelombang II',
            'content' => 'Tes wawancara dan minat bakat bagi calon peserta didik baru Gelombang II akan diselenggarakan pada tanggal 10-12 Juni 2026 bertempat di aula utama sekolah. Harap membawa kartu bukti pendaftaran online dan fotokopi raport SMP/MTs semester terakhir.',
            'is_active' => true,
            'published_at' => now(),
        ]);

        Announcement::create([
            'title' => 'Pembagian Raport Semester Genap & Libur Akhir Tahun Pelajaran',
            'content' => 'Sehubungan dengan berakhirnya tahun pelajaran 2025/2026, pembagian raport semester genap dilaksanakan pada tanggal 20 Juni 2026 secara tatap muka dengan orang tua/wali kelas masing-masing. Libur akhir tahun ajaran berlangsung mulai 22 Juni hingga 13 Juli 2026.',
            'is_active' => true,
            'published_at' => now(),
        ]);
    }
}
