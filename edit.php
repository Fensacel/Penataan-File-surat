<?php

include "database.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch the existing record
$result = mysqli_query($koneksi, "SELECT * FROM surat WHERE id_surat = $id");
if (mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $nomor_surat = $_POST['tnomorsurat'];
    $nama_surat = $_POST['tnamasurat'];
    $tanggal = $_POST['tanggal'];
    $jenis_surat = $_POST['jsurat'];
    $file_name = $data['surat']; // Existing file name

    // Handle file upload if a new file is submitted
    if (isset($_FILES['surat']) && $_FILES['surat']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $uploaded_file_tmp = $_FILES['surat']['tmp_name'];
        // Sanitize new file name and prepend timestamp
        $new_file_name =preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['surat']['name']));

        // Move the new uploaded file
        if (move_uploaded_file($uploaded_file_tmp, $upload_dir . $new_file_name)) {
            // Delete old file if exists
            if ($file_name && file_exists($upload_dir . $file_name)) {
                unlink($upload_dir . $file_name);
            }
            $file_name = $new_file_name;
        } else {
            echo "Gagal mengupload file baru.";
            exit;
        }
    }

    // Update in database
    $stmt = $koneksi->prepare("UPDATE surat SET nomor_surat=?, nama_surat=?, tanggal=?, jenis_surat=?, surat=? WHERE id_surat=?");
    $stmt->bind_param("sssssi", $nomor_surat, $nama_surat, $tanggal, $jenis_surat, $file_name, $id);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . htmlspecialchars($stmt->error);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="robots" content="noindex, nofollow">
<title>E- Arsip | XI PPLG 1</title>

<link rel="icon" href="logoarsip.png" type="image/png">

<link rel="stylesheet" href="assets/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/css/animate.css">

<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">

<div class="header">

<div class="header-left active">
<a href="index.php" class="logo">
<img src="12.png" alt="">
</a>
</div>

<a id="mobile_btn" class="mobile_btn" href="#sidebar">
<span class="bar-icon">
<span></span>
<span></span>
<span></span>
</span>
</a>

<ul class="nav user-menu">

<li class="nav-item">
<div class="top-nav-search">
<a href="javascript:void(0);" class="responsive-search">
<i class="fa fa-search"></i>
</a>
<form action="#">
<div class="searchinputs">
<input type="text" placeholder="Search Here ...">
<div class="search-addon">
<span><img src="assets/img/icons/closes.svg" alt="img"></span>
</div>
</div>
<a class="btn" id="searchdiv"><img src="assets/img/icons/search.svg" alt="img"></a>
</form>
</div>
</li>


<li class="nav-item dropdown has-arrow flag-nav">
<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
<img src="assets/image.png" alt="" height="20">
</a>
<div class="dropdown-menu dropdown-menu-right">
<a href="javascript:void(0);" class="dropdown-item">
<img src="assets/image.png" alt="" height="16"> Indonesia
</a>
</div>
</li>


<li class="nav-item dropdown">
<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
<img src="assets/img/icons/notification-bing.svg" alt="img"> <span class="badge rounded-pill">4</span>
</a>
<div class="dropdown-menu notifications">
<div class="topnav-dropdown-header">
<span class="notification-title">Notifications</span>
<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
</div>
<div class="noti-content">
<ul class="notification-list">
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="assets/img/profiles/avatar-02.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="assets/img/profiles/avatar-03.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="assets/img/profiles/avatar-06.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="assets/img/profiles/avatar-17.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="assets/img/profiles/avatar-13.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
<p class="noti-time"><span class="notification-time">2 days ago</span></p>
</div>
</div>
</a>
</li>
</ul>
</div>
<div class="topnav-dropdown-footer">
<a href="activities.html">View all Notifications</a>
</div>
</div>
</li>

<li class="nav-item dropdown has-arrow main-drop">
<a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
<span class="user-img"><img src="assets/jiwoooo.jpg"  alt="">
<span class="status online"></span></span>
</a>
<div class="dropdown-menu menu-drop-user">
<div class="profilename">
<div class="profileset">
<span class="user-img"><img src="assets/jiwoooo.jpg" alt="">
<span class="status online"></span></span>
<div class="profilesets">
<h6></h6>
<h5>Admin</h5>
</div>
</div>
<hr class="m-0">
<a class="dropdown-item" href="#"> <i class="me-2" data-feather="user"></i> My Profile</a>
<a class="dropdown-item" href="#"><i class="me-2" data-feather="settings"></i>Settings</a>
<hr class="m-0">
<a class="dropdown-item logout pb-0" href="logout.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
</div>
</div>
</li>
</ul>


<div class="dropdown mobile-user-menu">
<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item" href="#">My Profile</a>
<a class="dropdown-item" href="#">Settings</a>
<a class="dropdown-item" href="logout.php">Logout</a>
</div>
</div>

</div>


<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="active">
<a href="index.php"><img src="assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
</li>
<li class="bgcolor-white">
<a href="tambahsurat.php"><img src="assets/add-file.png" alt="img"><span> Add File</span> </a>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="assets/profile.png" alt="img"><span> Manage</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="surat.php">Surat</a></li>
<li><a href="user.php">User</a></li>
</ul>
</div>
</div>
</div>

<div class="page-wrapper">
    <h2>Edit File</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nomor Surat</label>
            <input type="text" name="tnomorsurat" class="form-control" required value="<?= htmlspecialchars($data['nomor_surat']) ?>">
        </div>
        <div class="mb-3">
            <label>Nama Surat</label>
            <input type="text" name="tnamasurat" class="form-control" required value="<?= htmlspecialchars($data['nama_surat']) ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required value="<?= htmlspecialchars($data['tanggal']) ?>">
        </div>
        <div class="mb-3">
            <label>Jenis Surat</label>
            <select name="jsurat" class="form-control" required>
                <option value="Surat Dinas" <?= $data['jenis_surat'] == 'Surat Dinas' ? 'selected' : '' ?>>Surat Dinas</option>
                <option value="Surat Pribadi" <?= $data['jenis_surat'] == 'Surat Pribadi' ? 'selected' : '' ?>>Surat Pribadi</option>
                <option value="Surat Niaga" <?= $data['jenis_surat'] == 'Surat Niaga' ? 'selected' : '' ?>>Surat Niaga</option>
            </select>
        </div>
        <div class="mb-3">
            <label>File Surat Sekarang</label><br>
            <?php if ($data['surat'] && file_exists("uploads/" . $data['surat'])): ?>
                <a href="uploads/<?= htmlspecialchars($data['surat']) ?>" download><?= htmlspecialchars($data['surat']) ?></a>
            <?php else: ?>
                Tidak ada file
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Unggah File Baru (jika ingin mengganti)</label>
            <input type="file" name="surat" accept=".pdf,.doc,.docx" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/js/jquery.slimscroll.min.js"></script>

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>