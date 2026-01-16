<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}


if (isset($_GET['cari'])) {

    // input pencarian dari SQL Injection
    $cari = mysqli_real_escape_string($conn, $_GET['cari']);
    $query = mysqli_query($conn,
        "SELECT * FROM tempat_wisata 
         WHERE nama LIKE '%$cari%' 
         OR lokasi LIKE '%$cari%'"
    );

   
    $judul = "Laporan Tempat Wisata : " . htmlspecialchars($cari);

} else {


    $query = mysqli_query($conn, "SELECT * FROM tempat_wisata");
    $judul = "Laporan Semua Tempat Wisata";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Cetak Data Tempat Wisata</title>

<style>
/* Style dasar halaman cetak */
body {
    font-family: Arial, sans-serif;
    margin: 30px;
}

/* Judul laporan */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Style tabel */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

/* Border dan padding tabel */
table th, table td {
    border: 1px solid #000;
    padding: 8px;
}

/* Warna header tabel */
table th {
    background-color: #f0f0f0;
}


.footer {
    margin-top: 40px;
    text-align: right;
}

/* merapikan halaman print */
@media print {
    body {
        margin: 0;
    }
}
</style>

</head>


<body onload="window.print()">


<h2><?= $judul ?></h2>

<table>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Lokasi</th>
    <th>Harga Tiket</th>
    <th>Deskripsi</th>
</tr>

<?php

$no = 1;
// Menampilkan data dari database ke tabel
while ($d = mysqli_fetch_array($query)) {
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($d['nama']) ?></td>
    <td><?= htmlspecialchars($d['lokasi']) ?></td>
    <td>Rp <?= number_format($d['harga']) ?></td>
    <td><?= htmlspecialchars($d['deskripsi']) ?></td>
</tr>
<?php } ?>
</table>


<div class="footer">
    <p>
        Dicetak pada: <?= date("d-m-Y") ?>
    </p>
</div>

</body>
</html>
