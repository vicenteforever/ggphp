欢迎使用GGPhp! <br>
这是系统默认的控制器，请创建一个属于你自己的模块控制器：<?php echo APP_DIR.DS.'module'.DS.'模块名称'.DS.'controller.php';?>
<hr/>系统模块文档:<br>
<?php
if(is_dir(APP_DIR.'src'.DS.'module'))
	$app_module = scandir(APP_DIR.'src'.DS.'module');
else
	$app_module = array();
if(is_dir(GG_DIR.DS.'module'))
	$core_module = @scandir(GG_DIR.DS.'module');
$list = array_merge($app_module, $core_module);
$baseurl = base_url();
foreach($list as $row){
	if($row !='.' && $row != '..'){
		echo "<a href='{$baseurl}{$row}/doc'>$row</a> <br/>";
	}
}
?>