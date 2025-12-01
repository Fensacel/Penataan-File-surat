<?php
include "database.php"; // Include your database connection

if (isset($_POST['bsimpan'])) {
    // Get form data
    $nomor_surat = $_POST['tnomorsurat'];
    $nama_surat = $_POST['tnamasurat'];
    $tanggal = $_POST['tanggal'];
    $jenis_surat = $_POST['jsurat'];

    // Handle file upload
    if (isset($_FILES['surat']) && $_FILES['surat']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        
        // Create the uploads directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Sanitize and build the new file name
        $file_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['surat']['name']));
        $tmp_file = $_FILES['surat']['tmp_name'];

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($tmp_file, $upload_dir . $file_name)) {
            // Prepare the SQL statement
            $stmt = $koneksi->prepare("INSERT INTO surat (nomor_surat, nama_surat, tanggal, jenis_surat, surat) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nomor_surat, $nama_surat, $tanggal, $jenis_surat, $file_name);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>
                        alert('Data surat berhasil ditambahkan!');
                        document.location='index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal menambahkan data surat: " . htmlspecialchars($stmt->error) . "');
                      </script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengupload file!');</script>";
        }
    } else {
        echo "<script>alert('Tidak ada file yang diupload!');</script>";
    }
} else {
    echo "<script>alert('Form tidak disubmit dengan benar!');</script>";
}
?>