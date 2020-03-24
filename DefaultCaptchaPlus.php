<?php
use WHMCS\Database\Capsule;
require __DIR__.'/functions.php';
function DefaultCaptchaPlus_config() {
	$configarray = array(
		'name' 			=> 'Whmcs Default Captcha Plus',
		'description' 	=> '此模块可以增强Whmcs默认验证码安全度',
		'version' 		=> '1.1',
		'author' 		=> 'flyqie',
		'fields' 		=> []
	);
	
    $configarray['fields']['captchamode'] = [
        'FriendlyName' => '验证码模式',
        'Type' => 'dropdown',
        'Options' => [
            'mode1' => '模式1'
        ],
    ];
	
	$configarray['fields']['whmcs_file_check'] = [
        'FriendlyName' => '管理页面检测Hook',
        'Type' => 'dropdown',
        'Options' => [
            'auto' => '自动检测更新',
            'onlycheck' => '仅检测'
        ],
    ];
	
	return $configarray;
}

function DefaultCaptchaPlus_activate() {
	if(strpos(file_get_contents(__DIR__.'/../../../includes/verifyimage.php'),'<?php'.PHP_EOL.'//Added By DefaultCaptchaPlus'.PHP_EOL.'header("Location: /modules/addons/DefaultCaptchaPlus/verifyimage.php");'.PHP_EOL.'exit();'.PHP_EOL.'?>'.PHP_EOL) !== false){ 
		//已装载
		return [
			'status' => 'success',
			'description' => '模块激活成功. 点击 配置 对模块进行设置。Hook已经存在,不再重复添加'
		];
	}else{
		file_put_contents(__DIR__.'/../../../includes/verifyimage.php','<?php'.PHP_EOL.'//Added By DefaultCaptchaPlus'.PHP_EOL.'header("Location: /modules/addons/DefaultCaptchaPlus/verifyimage.php");'.PHP_EOL.'exit();'.PHP_EOL.'?>'.PHP_EOL.file_get_contents(__DIR__.'/../../../includes/verifyimage.php'));
		return [
			'status' => 'success',
			'description' => '模块激活成功. 点击 配置 对模块进行设置。Hook已经添加'
		];
	}
	return [
		'status' => 'success',
		'description' => '模块激活成功. 点击 配置 对模块进行设置。'
	];
}

function DefaultCaptchaPlus_deactivate() {
	file_put_contents(__DIR__.'/../../../includes/verifyimage.php',str_replace('<?php'.PHP_EOL.'//Added By DefaultCaptchaPlus'.PHP_EOL.'header("Location: /modules/addons/DefaultCaptchaPlus/verifyimage.php");'.PHP_EOL.'exit();'.PHP_EOL.'?>'.PHP_EOL,'',file_get_contents(__DIR__.'/../../../includes/verifyimage.php')));
	return [
		'status' => 'success',
		'description' => '模块卸载成功,感谢您使用该插件!'
	];
}

function DefaultCaptchaPlus_output($vars) {
	//检测是否正常装载
	if(trim($vars['whmcs_file_check']) == 'auto'){
		if(strpos(file_get_contents(__DIR__.'/../../../includes/verifyimage.php'),'<?php'.PHP_EOL.'//Added By DefaultCaptchaPlus'.PHP_EOL.'header("Location: /modules/addons/DefaultCaptchaPlus/verifyimage.php");'.PHP_EOL.'exit();'.PHP_EOL.'?>'.PHP_EOL) !== false){ 
			echo '<font color="#0db112"><b>Hook正常</b></font>';
		}else{
			file_put_contents(__DIR__.'/../../../includes/verifyimage.php','<?php'.PHP_EOL.'//Added By DefaultCaptchaPlus'.PHP_EOL.'header("Location: /modules/addons/DefaultCaptchaPlus/verifyimage.php");'.PHP_EOL.'exit();'.PHP_EOL.'?>'.PHP_EOL.file_get_contents(__DIR__.'/../../../includes/verifyimage.php'));
			echo '<font color="#1065bd"><b>Hook异常,已自动修复,但请手动查看验证码能否正常显示:<a href="/includes/verifyimage.php" target="_blank">点我访问</a></b></font>';
		}
	}elseif(trim($vars['whmcs_file_check']) == 'onlycheck'){
		if(strpos(file_get_contents(__DIR__.'/../../../includes/verifyimage.php'),'<?php'.PHP_EOL.'//Added By DefaultCaptchaPlus'.PHP_EOL.'header("Location: /modules/addons/DefaultCaptchaPlus/verifyimage.php");'.PHP_EOL.'exit();'.PHP_EOL.'?>'.PHP_EOL) !== false){ 
			echo '<font color="#0db112"><b>Hook正常</b></font>';
		}else{
			echo '<font color="#ff0000"><b>Hook异常,请手动尝试重新启用插件</b></font>';
		}
	}else{
		echo '<font color="#ff0000"><b>[管理页面检测Hook]配置项值有误!</b></font>';
	}
}

/**
function DefaultCaptchaPlus_clientarea($vars){
	//不处理
}
**/