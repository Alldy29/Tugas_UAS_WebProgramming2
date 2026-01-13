<?php
require_once "../config/session.php";

if (!isset($_SESSION['login'])) {
    header("location:../index.php");
    exit;
}
?>



<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="dashboard.php?page=dashboard" class="brand-link">
    <img src="../assets/dist/img/AdminLTELogo.png"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-bold">Perpustakaan LP3I</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <img src="../assets/dist/img/user2-160x160.jpg"
          class="img-circle elevation-2"
          alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">
          <strong><?php echo $_SESSION['nama_users']; ?></strong><br>
          <small class="text-muted"><?php echo $_SESSION['email']; ?></small>
        </a>
      </div>
    </div>

    <!-- Sidebar Search -->
    <div class="form-inline mb-3">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar"
          type="search"
          placeholder="Cari menu..."
          aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy"
        data-widget="treeview"
        role="menu"
        data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="dashboard.php?page=dashboard" class="nav-link">
            <i class="nav-icon fas fa-home text-info"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Master Data -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database text-warning"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="dashboard.php?page=buku" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                <p>Buku</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="dashboard.php?page=anggota" class="nav-link">
                <i class="far fa-circle nav-icon text-primary"></i>
                <p>Anggota</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="dashboard.php?page=kategori" class="nav-link">
                <i class="far fa-circle nav-icon text-warning"></i>
                <p>Kategori</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- Transaction -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart text-info"></i>
            <p>
              Transaction
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="dashboard.php?page=peminjaman" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                <p>Peminjaman</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
          <a href="../logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
