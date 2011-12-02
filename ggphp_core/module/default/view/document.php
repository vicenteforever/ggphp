欢迎使用GGPhp! <br>
这是系统默认的控制器，请创建一个属于你自己的模块控制器：<?php echo APP_DIR.DS.'module'.DS.'模块名称'.DS.'controller.php';?>
<hr/>系统模块文档:<br>
<?php
$modules = module_rbac_loader::module();
$baseurl = base_url();
echo '<ul>';
foreach($modules as $k=>$v){
	echo "<li><a href='{$baseurl}{$k}/doc'>$k</a> </li>";
	echo '<ul>';
	$action = module_rbac_loader::action($k);
	foreach($action as $name){
		echo "<li>$name</li>";
	}
	echo '</ul>';
}
echo '</ul>';
?>