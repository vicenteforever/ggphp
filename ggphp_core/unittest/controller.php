<?php
/**
 * unittest controller
 * @package
 * @author Administrator
 */
class unittest_controller {

    function do_index() {
        if (config('app', 'debug')) {
            $modules = core_module::all();
            foreach ($modules as $module => $path) {
                test()->testModule($module, $module);
            }
            return response()->html('单元测试', test()->report());
        } else {
            return '单元测试只能在debug模式下运行, 请修改config/app.php相关配置';
        }
    }

}
