<?php
include "database.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Get the file name first to delete the physical file
$result = mysqli_query($koneksi, "SELECT surat FROM surat WHERE id_surat = $id");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $file_path = "uploads/" . $row['surat'];
    if (file_exists($file_path)) {
        unlink($file_path); // Delete the file
    }
}

// Delete the database record
mysqli_query($koneksi, "DELETE FROM surat WHERE id_surat = $id");

header("Location: index.php");
exit;