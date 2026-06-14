<?php
// lib/upload.php
declare(strict_types=1);

function ensureUploadsDir(string $dir): void
{
    if (!is_dir($dir)) mkdir($dir, 0755, true);
}

function sanitizeFileName(string $name): string
{
    $name = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $name);
    return substr($name, 0, 200);
}

function handleImageUpload(array $file, string $targetDir, array $options = []): ?string
{
    if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) return null;

    $allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!isset($allowedMime[$mime])) return null;

    $maxSize = $options['max_size'] ?? 4 * 1024 * 1024; // 4MB
    if ($file['size'] > $maxSize) return null;

    ensureUploadsDir($targetDir);
    $ext = $allowedMime[$mime];
    $base = bin2hex(random_bytes(8));
    $filename = $base . '.' . $ext;
    $dest = rtrim($targetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) return null;
    // set safe perms
    @chmod($dest, 0644);
    return $filename;
}
