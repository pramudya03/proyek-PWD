<?php
include "koneksi.php";

if (isset($_POST['daftar'])) {
    $nama = $_POST['nama'];
     $username= $_POST['username'];
    $password = md5($_POST['password']);

    mysqli_query($conn,
        "INSERT INTO users VALUES(NULL,'$nama','$username','$password')"
    );

    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Registrasi</title>
<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#eef3ff;
    font-family:Arial;
}
.box{
    width:320px;
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.2);
    text-align:center;
}
.header{
    background:#4a74f5;
    color:white;
    padding:20px;
    font-size:20px;
    font-weight:bold;
}
input{
    width:85%;
    padding:10px;
    margin:8px 0;
    border-radius:5px;
    border:1px solid #ccc;
}
button{
    width:85%;
    padding:10px;
    margin-top:10px;
    background:#4a74f5;
    border:none;
    color:white;
    border-radius:5px;
    cursor:pointer;
}
button:hover{ background:#3b5edc; }
a{ color:#4a74f5; text-decoration:none; }
label{
    font-size:12px;
    display:block;
    text-align:left;
    margin-left:25px;
}
</style>
</head>
<body>

<div class="box">
    <div class="header">Registrasi</div>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="username" placeholder="username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="daftar">Daftar</button>
    </form>

    <p><a href="login.php">Kembali</a></p>
</div>

</body>
</html>
