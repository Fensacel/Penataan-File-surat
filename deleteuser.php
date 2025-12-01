<?php
include "database.php"; // Include your database connection

if (!isset($_GET['id'])) {
    header("Location: index.php"); // Redirect if no ID is provided
    exit;
}

$id = intval($_GET['id']); // Get the user ID from the URL

// Prepare a statement to delete the user record from the database
$stmt = $koneksi->prepare("DELETE FROM penguna WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Optionally, you can add a success message here
    header("Location: index.php?message=User  deleted successfully");
} else {
    // Optionally, you can add an error message here
    header("Location: index.php?error=Failed to delete user");
}

$stmt->close();
$koneksi->close();
exit;
?>