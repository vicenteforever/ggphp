<?php
//ͼƬ��������װ
$dir = preg_replace("/\.php$/i", '', __FILE__);
include($dir.DS."easyphpthumbnail.class.php");
return new easyphpthumbnail();
