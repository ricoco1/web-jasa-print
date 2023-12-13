<?php
include '../koneksi.php';

if (isset($_GET['file_type']) && isset($_GET['file_name'])) {
    $fileType = $_GET['file_type'];
    $fileName = $_GET['file_name'];

    $filePath = '';

    if ($fileType === 'bukti_pembayaran') {
        $filePath = "../bukti_pembayaran/{$fileName}";
    } elseif ($fileType === 'file_print') {
        $filePath = "../file_print/{$fileName}";
    }

    if (file_exists($filePath)) {
        $contentType = mime_content_type($filePath);

        header("Content-type: {$contentType}");

        // Baca dan tampilkan isi file
        readfile($filePath);
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "Parameter tidak valid.";
}
?>
