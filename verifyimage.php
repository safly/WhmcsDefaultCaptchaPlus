<?php
use WHMCS\Database\Capsule;
# Required File Includes
require __DIR__."/../../../init.php";
require __DIR__.'/functions.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: image/png");
if(!function_exists('generateNewCaptchaCode')){
	//验证码生产函数不存在,可能已经因为版本更新不可用
	echo @file_get_contents(__DIR__.'/img/errorloadfunction10024.png');
}else{
	//验证码生成
	$rand = generateNewCaptchaCode();
	//验证码宽
	$Captchaw = 100;
	//验证码高
	$Captchah = 24;
	$CaptchaMode = Capsule::table("tbladdonmodules")->where("module", "DefaultCaptchaPlus")->where("setting", "captchamode")->first()->value;
	switch(trim($CaptchaMode)){
	case 'mode1':
		verifycode_gen_mode1($Captchaw,$Captchah,$rand);
		break;
	case "mode2":
		//暂时没啥其他的,TODO
		echo "Sorry,Not Support!";
		break;
	default:
		//验证码模式不存在,可能是已经弃用
		echo @file_get_contents(__DIR__.'/img/errorcaptchamode10024.png');
	}
}