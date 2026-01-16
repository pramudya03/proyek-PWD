<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    if ($_POST['nama']=="" || $_POST['lokasi']=="" || $_POST['harga']=="") {
        echo "<script>alert('Data tidak boleh kosong');</script>";
    } else {

        $nama = $_POST['nama'];
        $lokasi = $_POST['lokasi'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];

        /* === PROSES FOTO === */
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];

        if ($foto != "") {
            $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
            $foto_baru = uniqid() . "." . $ext;
            move_uploaded_file($tmp, "upload/" . $foto_baru);
        } else {
            $foto_baru = "default.jpg";
        }

        /* === SIMPAN KE DATABASE === */
        mysqli_query($conn,
            "INSERT INTO tempat_wisata 
             VALUES (
                NULL,
                '$nama',
                '$lokasi',
                '$harga',
                '$deskripsi',
                '$foto_baru'
             )"
        );

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Tempat Wisata</title>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f6fa;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-box {
    background: white;
    padding: 25px 30px;
    border-radius: 8px;
    width: 350px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
}

.form-box input,
.form-box textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
}

.form-box button {
    width: 100%;
    padding: 10px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-box button:hover {
    background: #2980b9;
}

.btn-back {
    display: block;
    width: 40%;
    margin: 12px auto 0;
    padding: 10px;
    text-align: center;
    background: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}

.btn-back:hover {
    background: #c0392b;
}
</style>
</head>

<body>

<div class="form-box">

<h2>Tambah Tempat Wisata</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nama</label>
    <input type="text" name="nama">

    <label>Lokasi</label>
    <input type="text" name="lokasi">

    <label>Harga</label>
    <input type="number" name="harga">

    <label>Deskripsi</label>
    <textarea name="deskripsi"></textarea>

    <label>Foto Wisata</label>
    <input type="file" name="foto" accept="image/*">

    <button type="submit" name="simpan">Simpan</button>
</form>

<a href="index.php" class="btn-back">Kembali</a>

</div>

</body>
</html>
