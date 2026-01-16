<?php
session_start();

$code = substr(md5(rand()), 0, 6);
$_SESSION['captcha_code'] = $code;

$img = imagecreatetruecolor(120, 40);
$bg = imagecolorallocate($img, 255,255,255);
$txt = imagecolorallocate($img, 0,0,0);

imagefill($img, 0, 0, $bg);
imagestring($img, 5, 30, 12, $code, $txt);

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
