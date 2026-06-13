<?php

/**
 * Script Perbaikan Storage Link & Migrasi File untuk Hosting (InfinityFree)
 * Jalankan file ini melalui browser (http://domain-anda.com/link_manual.php)
 * untuk memindahkan symlink yang rusak menjadi folder fisik dan memigrasikan file lama.
 */

// Konfigurasi path
$targetFolder = realpath(__DIR__ . '/../storage/app/public');
$linkFolder = __DIR__ . '/storage';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Link Fixer & File Migration</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        h1 {
            color: #1e3a8a;
            font-size: 24px;
            margin-top: 0;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .step {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 6px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
        }
        .step-title {
            font-weight: 600;
            color: #475569;
        }
        .success {
            color: #15803d;
            background-color: #f0fdf4;
            border-left: 4px solid #22c55e;
        }
        .warning {
            color: #b45309;
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
        }
        .error {
            color: #b91c1c;
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
        }
        pre {
            background-color: #1e293b;
            color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            font-size: 13px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Storage Link Fixer & File Migration Tool</h1>
    
    <div class="info-box">
        <strong>Informasi Path:</strong><br>
        • Folder Sumber Asli (Target): <code><?php echo $targetFolder ?: 'TIDAK DITEMUKAN'; ?></code><br>
        • Folder Tujuan Browser (Link): <code><?php echo $linkFolder; ?></code>
    </div>

    <?php
    if (!$targetFolder) {
        echo "<div class='step error'>";
        echo "<span class='step-title'>Error Fatal:</span> Folder sumber <code>storage/app/public</code> tidak ditemukan. Pastikan Anda mengunggah seluruh struktur proyek Laravel dengan benar.";
        echo "</div>";
        exit;
    }

    // Fungsi rekursif untuk menyalin file
    function copyRecursive($src, $dst) {
        if (!file_exists($src)) return 0;
        
        if (!file_exists($dst)) {
            @mkdir($dst, 0777, true);
        }

        $dir = opendir($src);
        if (!$dir) return 0;
        
        $copiedCount = 0;
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $srcFile = $src . '/' . $file;
                $dstFile = $dst . '/' . $file;

                if (is_dir($srcFile)) {
                    $copiedCount += copyRecursive($srcFile, $dstFile);
                } else {
                    if (copy($srcFile, $dstFile)) {
                        @chmod($dstFile, 0666);
                        $copiedCount++;
                    }
                }
            }
        }
        closedir($dir);
        return $copiedCount;
    }

    echo "<h3>Memulai Proses Perbaikan:</h3>";

    // Langkah 1: Deteksi dan Hapus Symlink Rusak / Folder Lama
    echo "<div class='step'>";
    echo "<span class='step-title'>Langkah 1: Memeriksa folder 'public/storage'...</span><br>";
    
    // Memeriksa keberadaan folder/link/junction
    $existsOrLink = file_exists($linkFolder) || is_link($linkFolder) || (is_string(@filetype($linkFolder)) && @filetype($linkFolder) !== '');
    
    if ($existsOrLink) {
        if (is_link($linkFolder) || @filetype($linkFolder) === 'unknown') {
            if (@unlink($linkFolder) || @rmdir($linkFolder)) {
                echo "✓ Symlink/Junction lama yang rusak berhasil dihapus.<br>";
            } else {
                echo "⚠ Gagal menghapus symlink/junction <code>public/storage</code> secara otomatis. Silakan hapus file/symlink bernama <code>public/storage</code> secara manual menggunakan File Manager cPanel/FTP.<br>";
            }
        } else if (is_dir($linkFolder)) {
            echo "ℹ Folder 'public/storage' sudah berupa direktori fisik.<br>";
        } else {
            // Berupa file lain
            if (@unlink($linkFolder)) {
                echo "✓ File pemblokir 'public/storage' berhasil dihapus.<br>";
            } else {
                echo "⚠ Gagal menghapus file pemblokir secara otomatis.<br>";
            }
        }
    } else {
        echo "✓ Folder 'public/storage' belum ada. Bagus.<br>";
    }
    echo "</div>";

    // Langkah 2: Buat Folder Fisik
    echo "<div class='step'>";
    echo "<span class='step-title'>Langkah 2: Membuat direktori fisik 'public/storage'...</span><br>";
    if (!file_exists($linkFolder)) {
        if (@mkdir($linkFolder, 0777, true)) {
            @chmod($linkFolder, 0777);
            echo "✓ Berhasil membuat folder fisik <code>public/storage</code> dengan izin penuh (0777).<br>";
        } else {
            echo "<span style='color:red;'>✗ Gagal membuat folder public/storage. Silakan buat folder bernama <code>storage</code> di dalam folder <code>public</code> secara manual menggunakan FTP/cPanel dan berikan izin tulis (write permission / CHMOD 777).</span><br>";
        }
    } else {
        @chmod($linkFolder, 0777);
        echo "✓ Folder fisik <code>public/storage</code> sudah ada dan siap digunakan.<br>";
    }
    echo "</div>";

    // Langkah 3: Migrasi File Lama
    echo "<div class='step'>";
    echo "<span class='step-title'>Langkah 3: Memigrasikan file lama dari storage/app/public ke public/storage...</span><br>";
    $copied = copyRecursive($targetFolder, $linkFolder);
    if ($copied > 0) {
        echo "✓ Berhasil memindahkan/menyalin <strong>{$copied} berkas</strong> lama ke folder publik agar muncul kembali di browser.<br>";
    } else {
        echo "ℹ Tidak ada berkas lama yang perlu dimigrasikan atau folder sumber kosong.<br>";
    }
    echo "</div>";

    // Kesimpulan
    if (file_exists($linkFolder) && is_dir($linkFolder) && is_writable($linkFolder)) {
        echo "<div class='step success'>";
        echo "<strong>Status: SUKSES!</strong><br>";
        echo "Direktori fisik storage sudah siap. Mulai sekarang, file, gambar, dan video yang diunggah oleh Admin akan langsung tersimpan di folder publik dan langsung dapat diakses oleh browser.";
        echo "</div>";
    } else {
        echo "<div class='step warning'>";
        echo "<strong>Status: Butuh Perhatian!</strong><br>";
        echo "Sistem mendeteksi folder <code>public/storage</code> belum siap atau tidak writable. Silakan periksa kembali izin folder (chmod 755 atau 777) melalui File Manager di InfinityFree.";
        echo "</div>";
    }
    ?>

    <div style="text-align: center;">
        <a href="/" class="btn">Kembali ke Beranda</a>
    </div>

    <div class="footer">
        &copy; <?php echo date('Y'); ?> PPDB SMA PGRI Kaliwungu Kudus. All rights reserved.
    </div>
</div>

</body>
</html>
