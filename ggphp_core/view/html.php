<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php o($data['title'])?></title>
</head>

<body>
<h1><?php o($data['title'])?></h1>
<?php o($data['content'])?>
<hr/>
<pre><?php
app()->log('application end');
$log = app()->log();
$time = $log[0]['time'];
foreach($log as $k=>$v){
	$timespan = sprintf("%.4f", $v['time'] - $time);
	$time = $v['time'];
	echo "[{$timespan}] {$v['message']} <br/>";
}
$total =  sprintf("%.4f", $time - $log[0]['time']);
echo "程序运行时间:$total ms, memory:".util_string::size_hum_read(memory_get_usage())." <br>";
?></pre>
</body>
</html>
