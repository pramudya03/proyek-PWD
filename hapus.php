<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

/* AMBIL DATA FOTO */
$data = mysqli_query($conn, "SELECT foto FROM tempat_wisata WHERE id='$id'");
$d = mysqli_fetch_array($data);

/* HAPUS FOTO DARI FOLDER */
if ($d['foto'] != "default.jpg" && file_exists("upload/".$d['foto'])) {
    unlink("upload/".$d['foto']);
}

/* HAPUS DATA DARI DATABASE */
mysqli_query($conn, "DELETE FROM tempat_wisata WHERE id='$id'");

header("Location: index.php");
exit;
