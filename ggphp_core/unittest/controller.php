<?php

/**
 * unittest controller
 * @package
 * @author Administrator
 */
class unittest_controller {

	function doIndex() {
		if (config('app', 'debug')) {
			$modules = core_module::all();
			foreach ($modules as $module => $path) {
				test()->testModule($module, $module);
			}
			return html(test()->report(), '单元测试');
		} else {
			return html('单元测试只能在debug模式下运行, 请修改config/app.php相关配置');
		}
	}

}

?>
