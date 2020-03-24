<?php
//验证码模式1
if(!function_exists('verifycode_gen_mode1')){
function verifycode_gen_mode1($w,$h,$code){
    $img = imagecreate($w, $h);
    $red = imagecolorallocate($img, 255, 0, 0);
    $white = imagecolorallocate($img, 255, 255, 255);
    $gray = imagecolorallocate($img, 118, 151, 199);
    $black = imagecolorallocate($img, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));
    // 画背景
    imagefilledrectangle($img, 0, 0, $w, $h, $black);
    // 在画布上随机生成大量点，起干扰作用;
    for ($i = 0; $i < 80; $i++) {
        imagesetpixel($img, rand(0, $w), rand(0, $h), $gray);
    }
    imagestring($img, 5, 5, 4, $code[0], $red);
    imagestring($img, 5, 30, 3, $code[1], $red);
    imagestring($img, 5, 45, 4, $code[2], $red);
    imagestring($img, 5, 70, 3, $code[3], $red);
    imagestring($img, 5, 80, 2, $code[4], $white);
    imagepng($img);
    imagedestroy($img);
}
}