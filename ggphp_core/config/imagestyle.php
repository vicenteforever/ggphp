<?php
$config['icon'] = array(
	'Inflate' => true,						//允许图片放大
	'Thumbwidth' => 100,					//缩放宽度
	'Thumbheight' => 100,					//缩放高度
	'Cropimage' => array(4,1,0,0,0,0),		//4=裁切并缩放
	'Clipcorner' => array(2,10,0,1,1,1,1),	//圆角
);

$config['water'] = array(
	'Copyrighttext' => 'knowweb.info',		//水印
	'Copyrightposition' => '50% 100%',		//水印位置
);

return $config;