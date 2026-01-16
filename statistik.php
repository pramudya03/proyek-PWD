<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$total = mysqli_fetch_array(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM tempat_wisata")
);


$rata = mysqli_fetch_array(
    mysqli_query($conn, "SELECT AVG(harga) AS rata FROM tempat_wisata")
);

$lokasi = mysqli_query($conn,
    "SELECT lokasi, COUNT(*) AS jumlah 
     FROM tempat_wisata 
     GROUP BY lokasi"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Statistik Tempat Wisata</title>

<style>
/* tampilan dasar halaman */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f6fa;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Kotak utama statistik */
.stat-box {
    background: white;
    padding: 30px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

/* Judul halaman */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* List statistik */
ul {
    padding-left: 20px;
}

ul li {
    margin-bottom: 8px;
}

/* Kotak khusus statistik lokasi */
.lokasi-box {
    background: #f2f2f2;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}

/* Tombol kembali */
.btn-back {
    display: block;
    width: 30%;
    text-align: center;
    margin: 12px auto 0;
    padding: 10px;
    background: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 10px;
}


.btn-back:hover {
    background: #c0392b;
}
</style>
</head>

<body>

<div class="stat-box">


<h2>Statistik Tempat Wisata</h2>


<ul>
    <li>
        Total Tempat Wisata:
        <b><?= $total['total'] ?></b>
    </li>
    <li>
        Rata-rata Harga Tiket:
        <b>Rp <?= number_format($rata['rata']) ?></b>
    </li>
</ul>


<div class="lokasi-box">
<b>Jumlah Wisata per Lokasi:</b>
<ul>
<?php
// Loop untuk menampilkan setiap lokasi dan jumlah wisatanya
while ($l = mysqli_fetch_array($lokasi)) {
?>
    <li>
        <?= htmlspecialchars($l['lokasi']) ?> :
        <?= $l['jumlah'] ?> tempat
    </li>
<?php } ?>
</ul>
</div>


<a href="index.php" class="btn-back">Kembali</a>

</div>

</body>
</html>
