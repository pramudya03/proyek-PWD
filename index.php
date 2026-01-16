<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Data Tempat Wisata</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f4f6f9;
}

/* HEADER */
.header{
    background:linear-gradient(to right,#0f2027,#203a43,#2c5364);
    color:white;
    padding:20px;
    display:flex;
    align-items:center;
    gap:15px;
}
.header h2{
    margin:0;
    font-size:20px;
}
.header p{
    margin:0;
    font-size:13px;
}

/* HAMBURGER */
.menu-btn{
    font-size:26px;
    cursor:pointer;
    user-select:none;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    top:0;
    left:-300px;
    width:260px;
    height:100%;
    background:#ffffff;
    box-shadow:4px 0 15px rgba(0,0,0,.2);
    padding:20px;
    transition:.3s;
    z-index:1000;
}
.sidebar.active{
    left:0;
}
.sidebar h3{
    margin-top:0;
}
.sidebar a{
    display:block;
    padding:10px 12px;
    margin-bottom:8px;
    border-radius:6px;
    text-decoration:none;
    color:#2c3e50;
    font-weight:500;
}
.sidebar a:hover{
    background:#ecf0f1;
}

/* SEARCH */
.sidebar input{
    width:100%;
    padding:8px 10px;
    border-radius:20px;
    border:1px solid #ccc;
    margin-top:10px;
}
.sidebar button{
    width:100%;
    margin-top:8px;
    padding:8px;
    border:none;
    border-radius:20px;
    background:#2c3e50;
    color:white;
    cursor:pointer;
}

/* OVERLAY */
.overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.4);
    display:none;
    z-index:999;
}
.overlay.active{
    display:block;
}

/* CONTAINER */
.container{
    width:95%;
    margin:20px auto;
}

/* GRID CARD */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(260px,1fr));
    gap:20px;
}

/* CARD */
.card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,.1);
    transition:.3s;
    position:relative;
}

.card:hover{transform:translateY(-5px);}
.card img{
    width:100%;
    height:180px;
    object-fit:cover;
}
.card-body{padding:15px;}
.card-body h3{margin:0;font-size:18px;}
.card-body p{margin:6px 0;font-size:14px;color:#555;}
.harga{font-weight:bold;color:#27ae60;}

/* FOOTER */
.card-footer{
    padding:12px 15px;
    border-top:1px solid #eee;
    text-align:right;
}
.card-footer a{
    text-decoration:none;
    margin-left:8px;
    color:#2980b9;
    font-weight:bold;
}
/* BUTTON KEMBALI */
.btn-back{
    display:inline-block;
    margin-bottom:px;
    padding:10px 18px;
    background:#e74c3c;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:14px;
}
.btn-back:hover{
    background:#c0392b;
}

/* DROPDOWN 3 TITIK */
.more{
    position:absolute;
    top:10px;
    right:10px;
}

.more-btn{
    background:rgba(0,0,0,.55);
    color:white;
    border:none;
    border-radius:50%;
    width:32px;
    height:32px;
    font-size:18px;
    cursor:pointer;
}

.more-menu{
    position:absolute;
    right:0;
    top:38px;
    background:white;
    border-radius:8px;
    box-shadow:0 4px 12px rgba(0,0,0,.15);
    display:none;
    min-width:120px;
    overflow:hidden;
    z-index:10;
}

.more-menu a{
    display:block;
    padding:10px;
    font-size:14px;
    text-decoration:none;
    color:#2c3e50;
}

.more-menu a:hover{
    background:#f1f2f6;
}

.more-menu a.delete{
    color:#e74c3c;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Menu</h3>
    <a href="tambah.php">➕ Tambah Data</a>
    <a href="statistik.php">📊 Statistik</a>
    <a href="cetak.php<?php 
        if (isset($_GET['cari'])) {
            echo '?cari=' . urlencode($_GET['cari']);
        }
    ?>" target="_blank">🖨️ Cetak</a>
    <a href="logout.php" style="color:#e74c3c">🚪 Logout</a>

    <form method="GET">
        <input type="text" name="cari" placeholder="Cari wisata..." value="<?= $_GET['cari'] ?? '' ?>">
        <button type="submit">🔍 Cari</button>
    </form>
</div>

<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<!-- HEADER -->
<div class="header">
    <div class="menu-btn" onclick="toggleMenu()">☰</div>
    <div>
        <h2>Data Tempat Wisata</h2>
        <p>Destinasi wisata terbaik Indonesia</p>
    </div>
</div>

<div class="container">

<div class="grid">
<?php
if (isset($_GET['cari'])) {
    $cari = mysqli_real_escape_string($conn, $_GET['cari']);
    $data = mysqli_query($conn,
        "SELECT * FROM tempat_wisata 
         WHERE nama LIKE '%$cari%' OR lokasi LIKE '%$cari%'"
    );
} else {
    $data = mysqli_query($conn, "SELECT * FROM tempat_wisata");
}

while ($d = mysqli_fetch_array($data)) {
    $foto = $d['foto'] ? "upload/".$d['foto'] : "upload/default.jpg";
?>
    <div class="card">
        <img src="<?= $foto ?>">
        <div class="card-body">
            <h3><?= htmlspecialchars($d['nama']) ?></h3>
            <p>📍 <?= htmlspecialchars($d['lokasi']) ?></p>
            <p><?= htmlspecialchars($d['deskripsi']) ?></p>
            <div class="harga">Rp <?= number_format($d['harga']) ?></div>
        </div>
        <div class="more">
    <button class="more-btn" onclick="toggleMore(this)">⋮</button>
    <div class="more-menu">
        <a href="edit.php?id=<?= $d['id'] ?>">✏️ Edit</a>
        <a href="hapus.php?id=<?= $d['id'] ?>" 
           class="delete"
           onclick="return confirm('Yakin hapus data?')">🗑️ Hapus</a>
    </div>
</div>

    </div>
<?php } ?>
</div>

</div>
<div class="container">
<?php if(isset($_GET['cari']) && $_GET['cari'] != ""){ ?>
    <a href="index.php" class="btn-back">Kembali ke Halaman Utama</a>
<?php } ?>

<script>
function toggleMenu(){
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('overlay').classList.toggle('active');
}
</script>
<script>
function toggleMore(btn){
    const menu = btn.nextElementSibling;
    document.querySelectorAll('.more-menu').forEach(m => {
        if(m !== menu) m.style.display = 'none';
    });
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function(e){
    if(!e.target.closest('.more')){
        document.querySelectorAll('.more-menu')
            .forEach(m => m.style.display='none');
    }
});
</script>


</body>
</html>
