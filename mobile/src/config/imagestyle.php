<?php
$config['icon'] = array(
	'Inflate' => true,						//允许图片放大
	'Thumbwidth' => 64,						//缩放宽度
	'Thumbheight' => 64,					//缩放高度
	'Cropimage' => array(4,1,0,0,0,0),		//4=裁切并缩放
	'Clipcorner' => array(2,10,0,1,1,1,1),	//圆角
);

$config['normal'] = array(
	'Inflate' => true,						//允许图片放大
	'Thumbwidth' => 240,						//缩放宽度
	'Thumbheight' => 320,					//缩放高度
);


$config['water'] = array(
	'Copyrighttext' => 'knowweb.info',		//水印
	'Copyrightposition' => '50% 100%',		//水印位置
);

return $config;