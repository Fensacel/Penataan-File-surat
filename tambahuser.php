<?php
include "database.php"; // Include your database connection

if (isset($_POST['simpan'])) {
    // Get form data
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    // Prepare the SQL statement
    $stmt = $koneksi->prepare("INSERT INTO penguna (nis, nama, kelas) VALUES (?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("sss", $nis, $nama, $kelas);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Data user berhasil ditambahkan!');
                document.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data user: " . htmlspecialchars($stmt->error) . "');
              </script>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>alert('Form tidak disubmit dengan benar!');</script>";
}
?>