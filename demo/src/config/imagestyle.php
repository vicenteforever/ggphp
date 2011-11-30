<?php
$config['thumb'] = array(
	'Inflate' => true, //ÔÊĞíÍ¼Æ¬·Å´ó
	'Thumbwidth' => 250,
	'Thumbheight' => 150,
	'Cropimage' => array(4,1,0,0,0,0), //4=²ÃÇĞ²¢Ëõ·Å
	'Clipcorner' => array(2,10,0,1,1,1,1), //Ô²½Ç
	'Copyrighttext' => 'knowweb.info',//Ë®Ó¡
	'Copyrightposition' => '50% 100%',
);

$config['bigthumb'] = array(
	'Cropimage' => array(2,0,0,0,0,0),
);

return $config;