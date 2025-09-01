<?php
// Form HTML untuk input
if (!isset($_POST['submit'])) {
    ?>
    <form method="post">
        <label>Path folder/file:</label><br>
        <input type="text" name="path" value="<?php echo __DIR__; ?>" style="width:100%" required><br><br>

        <label>Waktu baru (format: YYYY-MM-DD HH:MM:SS):</label><br>
        <input type="text" name="new_time" placeholder="2025-01-01 00:00:00" style="width:100%" required><br><br>

        <input type="submit" name="submit" value="Ubah Semua Waktu">
    </form>
    <?php
    exit;
}

// Fungsi utama untuk ubah waktu secara rekursif
function updateTimeRecursive($target, $time, &$log) {
    if (is_file($target) || is_dir($target)) {
        touch($target, $time, $time);
        $log[] = $target;
    }

    if (is_dir($target)) {
        $items = scandir($target);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            $full = $target . DIRECTORY_SEPARATOR . $item;
            updateTimeRecursive($full, $time, $log);
        }
    }
}

// Validasi input
$path_input = $_POST['path'];
$real_path = realpath($path_input);
$new_time_str = $_POST['new_time'];
$new_time = strtotime($new_time_str);

// Validasi
if ($real_path === false || !file_exists($real_path)) {
    die("<strong>❌ Path tidak ditemukan atau tidak valid!</strong>");
}
if ($new_time === false) {
    die("<strong>❌ Format waktu salah! Gunakan format: YYYY-MM-DD HH:MM:SS</strong>");
}

// Proses perubahan waktu
$log = [];
updateTimeRecursive($real_path, $new_time, $log);

// Hasil
echo "<strong>✅ Berhasil mengubah waktu modifikasi ke:</strong> " . date("Y-m-d H:i:s", $new_time) . "<br>";
echo "<strong>Total file/folder yang diubah:</strong> " . count($log) . "<br><br>";

echo "<details><summary>Lihat daftar file yang diubah</summary><pre>";
foreach ($log as $item) {
    echo htmlspecialchars($item) . "\n";
}
echo "</pre></details>";
