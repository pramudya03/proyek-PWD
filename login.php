<?php
session_start();
include "koneksi.php";
$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['Username']);
    $password = md5($_POST['password']);
    $captcha = $_POST['captcha'];

    if ($captcha != $_SESSION['captcha_code']) {
        $error = "Captcha salah!";
    } else {
        $q = mysqli_query($conn,
            "SELECT * FROM users WHERE Username='$username' AND password='$password'"
        );

        if (mysqli_num_rows($q) > 0) {
            $_SESSION['login'] = true;
            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
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
.box h2{ margin:20px 0 10px; }
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
a{ color:#4a74f5; text-decoration:none; font-size:14px; }
.error{ color:red; font-size:14px; }
</style>
</head>
<body>

<div class="box">
    <div class="header">Registrasi</div>

    <h2>Login</h2>

    <?php if($error!="") echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="Username" name="Username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Masukan Password" required>

        <img src="captcha.php" id="cap"><br>
        <input type="text" name="captcha" placeholder="Masukan Captcha" required>

        <a href="#" onclick="refreshCaptcha()">Refresh Captcha</a><br><br>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Registrasi</a></p>
</div>

<script>
function refreshCaptcha(){
    document.getElementById("cap").src = "captcha.php?" + Date.now();
}
</script>

</body>
</html>
