<?php
include "../config/koneksi.php";

// =======================
// DATA STATISTIK
// =======================

$jml_anggota = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM anggota"))['total'];
$jml_buku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku"))['total'];
$jml_peminjaman = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM peminjaman"))['total'];
$jml_dipinjam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM peminjaman WHERE status='Dipinjam'"))['total'];

$q_terbaru = mysqli_query($koneksi, "
    SELECT 
        p.no_pinjam,
        p.tanggal_pinjam,
        a.nama_anggota,
        GROUP_CONCAT(b.judul SEPARATOR ', ') AS buku
    FROM peminjaman p
    LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
    LEFT JOIN detail_peminjaman d ON p.id_peminjaman = d.id_peminjaman
    LEFT JOIN buku b ON d.id_buku = b.id_buku
    GROUP BY p.id_peminjaman
    ORDER BY p.id_peminjaman DESC
    LIMIT 5
");
?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0">Dashboard</h1>
  </div>
</div>

<div class="content">
<div class="container-fluid">

  <div class="row">

    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $jml_anggota ?></h3>
          <p>Anggota</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $jml_buku ?></h3>
          <p>Buku</p>
        </div>
        <div class="icon">
          <i class="fas fa-book"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $jml_peminjaman ?></h3>
          <p>Total Peminjaman</p>
        </div>
        <div class="icon">
          <i class="fas fa-exchange-alt"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $jml_dipinjam ?></h3>
          <p>Sedang Dipinjam</p>
        </div>
        <div class="icon">
          <i class="fas fa-clock"></i>
        </div>
      </div>
    </div>

  </div>

  <div class="card">
    <div class="card-header bg-primary">
      <h3 class="card-title">📚 5 Peminjaman Terbaru</h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No Pinjam</th>
            <th>Nama Anggota</th>
            <th>Buku</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php while($t = mysqli_fetch_assoc($q_terbaru)) { ?>
          <tr>
            <td><b><?= $t['no_pinjam'] ?></b></td>
            <td><?= $t['nama_anggota'] ?></td>
            <td><?= $t['buku'] ?></td>
            <td><?= date('d-m-Y', strtotime($t['tanggal_pinjam'])) ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</div>
