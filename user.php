<?php

include "database.php";

$muncul = mysqli_query($koneksi, "SELECT * FROM penguna ORDER BY id DESC");
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $search = mysqli_real_escape_string($koneksi, $search); // Sanitize the input
    $muncul = mysqli_query($koneksi, "SELECT * FROM penguna WHERE 
          nama LIKE '%$search%' OR 
          kelas LIKE '%$search%' OR 
          nis LIKE '%$search%' 
          ORDER BY id DESC");
} else {
    $muncul = mysqli_query($koneksi, "SELECT * FROM penguna ORDER BY id DESC");
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
<div class="content">
<div class="row">
<div class="col-lg-12 col-sm-12 col-12 d-flex">
<div class="card flex-fill">
<div class="card-header">
<h5 class="card-title mb-0">User</h5>
</div>
<div class="card-body">
<table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
<div class="d-flex justify-content-between align-items-center mb-3">
<form method="GET" action="" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by Nama or Kelas " value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="btn btn-primary">Search</button>
</form>
</div>
        <a href="adduser.php" class="btn btn-primary btn-icon-split">
            <span class="text">Tambah User Baru</span>
        </a>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th width="15%">Update</th>
                </tr>
            </thead>
            <tbody>
               <?php
                  $no = 1;
                  while ($data = mysqli_fetch_array($muncul)) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($data['nis']) ?></td>
                        <td><?= htmlspecialchars($data['nama']) ?></td>
                        <td><?= htmlspecialchars($data['kelas']) ?></td>
                        <td>
                            <a href="edituser.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-success text-white">Edit</a>
                            <a href="deleteuser.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
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