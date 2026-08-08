<?php
$im = imagecreatetruecolor(192, 192);
$bg = imagecolorallocate($im, 2, 10, 36);
imagefill($im, 0, 0, $bg);
$fg = imagecolorallocate($im, 0, 184, 255);
imageellipse($im, 96, 96, 120, 120, $fg);
imagepng($im, __DIR__ . '/public/icon-192.png');
imagedestroy($im);

$im2 = imagecreatetruecolor(512, 512);
$bg2 = imagecolorallocate($im2, 2, 10, 36);
imagefill($im2, 0, 0, $bg2);
$fg2 = imagecolorallocate($im2, 0, 184, 255);
imageellipse($im2, 256, 256, 320, 320, $fg2);
imagepng($im2, __DIR__ . '/public/icon-512.png');
imagedestroy($im2);

echo "PWA Icons generated successfully.\n";
