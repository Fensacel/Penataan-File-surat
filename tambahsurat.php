<?php


include "database.php";
$tampil = mysqli_query($koneksi, "SELECT * FROM surat ORDER BY id_surat DESC");
$muncul = mysqli_query($koneksi, "SELECT * FROM penguna ORDER BY id DESC");
$username = mysqli_query($koneksi,"SELECT * FROM users ORDER BY id");

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

<li class="nav-item dropdown has-arrow main-drop">
<a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
<span class="user-img"><img src="assets/jiwoooo.jpg" alt="">
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
<a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My Profile</a>
<a class="dropdown-item" href="generalsettings.html"><i class="me-2" data-feather="settings"></i>Settings</a>
<hr class="m-0">
<a class="dropdown-item logout pb-0" href="logout.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
</div>
</div>
</li>
</ul>


<div class="dropdown mobile-user-menu">
<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item" href="profile.html">My Profile</a>
<a class="dropdown-item" href="generalsettings.html">Settings</a>
<a class="dropdown-item" href="logout.php">Logout</a>
</div>
</div>

</div>


<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="bgcolor-white">
<a href="index.php"><img src="assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
</li>
<li class="active">
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
    <h2>Add File</h2>
<form method="POST" action="surattambah.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" name="tnomorsurat" placeholder="Masukan Nomor Surat" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Surat</label>
                            <input type="text" class="form-control" name="tnamasurat" placeholder="Masukan Nama Surat" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Surat</label>
                            <select class="form-select" name="jsurat" required>
                                <option>Pilih Jenis Surat</option>
                                <option value="Surat Pribadi">Surat Pribadi</option>
                                <option value="Surat Dinas">Surat Dinas</option>
                                <option value="Surat NIaga">Surat Niaga</option>
                            </select>
                       </div>
                    <div class="mb-3">
                        <label class="form-label">File Surat</label>
                        <input type="file" class="form-control" name="surat" accept=".pdf,.doc,.docx" required>
                    </div>
                    <div class="modal-footer">
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" name="bsimpan">Simpan</button>
                    </div>
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