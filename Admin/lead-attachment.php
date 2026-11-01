<?php
/* ============================================================
   Shows a lead's reference image (Contact form upload).
   Files in /lead_attachments are not public; only logged-in
   admins can open them through this script.
   Usage: lead-attachment.php?id=42   (&download=1 to save)
   ============================================================ */
session_start();
include_once "connect.php";
require_once __DIR__ . '/../lib/bosk-leads.php';

if (!bosk_leads_is_admin($con)) {
    header('Location: index.php');
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$file = null;
$original = null;

if ($id > 0 && bosk_leads_prepare_db($con)) {
    $stmt = mysqli_prepare($con, 'SELECT attachment, attachment_name FROM leads WHERE id = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $file, $original);
            mysqli_stmt_fetch($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

$types = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
$path  = '';
if (is_string($file) && preg_match('/^[A-Za-z0-9_]+\.(jpg|png|webp)$/', $file)) {
    $path = dirname(__DIR__) . '/lead_attachments/' . $file;
}
if ($path === '' || !is_file($path)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Attachment not found.';
    exit;
}

$ext          = strtolower(pathinfo($path, PATHINFO_EXTENSION));
$downloadName = preg_replace('/[^\w.\- ]+/', '', (string) $original);
if ($downloadName === '') {
    $downloadName = $file;
}

header('Content-Type: ' . $types[$ext]);
header('Content-Length: ' . filesize($path));
header('X-Content-Type-Options: nosniff');
header('Content-Disposition: ' . (isset($_GET['download']) ? 'attachment' : 'inline') . '; filename="' . $downloadName . '"');
readfile($path);
exit;
