<?php
//图片处理程序封装
$dir = preg_replace("/\.php$/i", '', __FILE__);
include($dir.DS."easyphpthumbnail.class.php");
return new easyphpthumbnail();
