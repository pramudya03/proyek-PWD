<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM tempat_wisata WHERE id='$id'");
$d = mysqli_fetch_array($data);

if (isset($_POST['update'])) {

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

        // HAPUS FOTO LAMA (jika bukan default)
        if ($d['foto'] != "default.jpg") {
            @unlink("upload/" . $d['foto']);
        }

        mysqli_query($conn,
            "UPDATE tempat_wisata SET
                nama='$nama',
                lokasi='$lokasi',
                harga='$harga',
                deskripsi='$deskripsi',
                foto='$foto_baru'
             WHERE id='$id'"
        );
    } else {
        // TANPA GANTI FOTO
        mysqli_query($conn,
            "UPDATE tempat_wisata SET
                nama='$nama',
                lokasi='$lokasi',
                harga='$harga',
                deskripsi='$deskripsi'
             WHERE id='$id'"
        );
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Tempat Wisata</title>

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
    background: #27ae60;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-box button:hover {
    background: #219150;
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

.preview {
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:6px;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="form-box">

<h2>Edit Tempat Wisata</h2>

<form method="POST" enctype="multipart/form-data">

    <!-- PREVIEW FOTO -->
    <img src="upload/<?= $d['foto'] ?>" class="preview">

    <label>Ganti Foto (opsional)</label>
    <input type="file" name="foto" accept="image/*">

    <label>Nama</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($d['nama']) ?>">

    <label>Lokasi</label>
    <input type="text" name="lokasi" value="<?= htmlspecialchars($d['lokasi']) ?>">

    <label>Harga</label>
    <input type="number" name="harga" value="<?= $d['harga'] ?>">

    <label>Deskripsi</label>
    <textarea name="deskripsi"><?= htmlspecialchars($d['deskripsi']) ?></textarea>

    <button type="submit" name="update">Update</button>
</form>

<a href="index.php" class="btn-back">Kembali</a>

</div>

</body>
</html>
