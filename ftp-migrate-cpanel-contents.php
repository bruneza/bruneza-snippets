<?php
/*
 * FTP Download via PHP cURL
 * Place in: /home2/adfinance/public_html/ftp_curl_pull.php
 * Will download to: /home2/adfinance/public_html/backup-6.28.2025_04-54-17_adfinance.tar.gz
 */

ini_set('max_execution_time', 0);

$ftp_server = "";
$ftp_user   = "";
$ftp_pass   = "";
$remote_file = "/";
$local_file = __DIR__ . "/....gz";

// --- cURL setup ---
$ch = curl_init();
$ftp_user_enc = rawurlencode($ftp_user);
$ftp_pass_enc = rawurlencode($ftp_pass);
$ftp_url = "ftp://{$ftp_user_enc}:{$ftp_pass_enc}@{$ftp_server}/{$remote_file}";

echo date('Y-m-d H:i:s') . " - Starting FTP cURL download...\n";
echo "FTP URL: $ftp_url\n";

echo date('Y-m-d H:i:s') . " - Starting FTP cURL download...\n";
echo "FTP URL: $ftp_url\n";

$fp = fopen($local_file, 'a'); // 'a' for append in case of resume
if (!$fp) {
    echo "ERROR: Cannot open $local_file for writing.\n";
    exit;
}

// Try to resume from current file size
$start = filesize($local_file);
if ($start > 0) {
    echo "Resuming download from byte $start...\n";
    curl_setopt($ch, CURLOPT_RESUME_FROM, $start);
}

curl_setopt($ch, CURLOPT_URL, $ftp_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

// Passive mode (default for cURL; not always needed)
curl_setopt($ch, CURLOPT_FTP_USE_EPSV, true);

$result = curl_exec($ch);

if ($result) {
    echo date('Y-m-d H:i:s') . " - Download completed (or resumed)!\n";
} else {
    echo date('Y-m-d H:i:s') . " - ERROR: Download failed! (" . curl_error($ch) . ")\n";
}

curl_close($ch);
fclose($fp);

echo date('Y-m-d H:i:s') . " - Done.\n";
?>
"
