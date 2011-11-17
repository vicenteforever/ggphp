<?php
define("APP_DIR", dirname(__FILE__));
require("../../ggphp/gg.php");

$array = array('a','b','c');
print_r(array_shift($array));



exit;

$a = array('a', 'b', 'c');
array_push($a, 'sdf');
print_r($a);
exit;
$a[] = '我是谁是我 谁是我是谁';
$a[] = array('aaa','bbb','ccc');

$adapter = 'file';
storage($adapter, 'default')->save('test', $a);
print_r( storage($adapter, 'default')->load('test'));
storage($adapter, 'default')->delete('test');
?>