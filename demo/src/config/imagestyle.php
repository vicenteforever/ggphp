<?php
$config['thumb'] = array(
	'Inflate' => true, //����ͼƬ�Ŵ�
	'Thumbwidth' => 250,
	'Thumbheight' => 150,
	'Cropimage' => array(4,1,0,0,0,0), //4=���в�����
	'Clipcorner' => array(2,10,0,1,1,1,1), //Բ��
	'Copyrighttext' => 'knowweb.info',//ˮӡ
	'Copyrightposition' => '50% 100%',
);

$config['bigthumb'] = array(
	'Cropimage' => array(2,0,0,0,0,0),
);

return $config;