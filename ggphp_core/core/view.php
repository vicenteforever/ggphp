<?php

/**
 * PHP视图模板
 * @package core 
 * @author goodzsq@gmail.com
 */
class core_view {

    /**
     * php文件作为原始模版
     * @param mixed $data 模版数据
     * @param string $view 模版名称
     * @return string 
     */
    function php($data = null, $view = null) {
        if (empty($view)) {
            $view = app()->getActionName();
        }
        if (!preg_match("/^[_0-9a-zA-Z\/]+$/", $view)) {
            throw new Exception('invalid view' . $view);
        }
        ob_start();
        $path = APP_DIR . str_replace('/', DS, "/src/view/{$view}.php");
        if (!file_exists($path)) {
            $path = GG_DIR . str_replace('/', DS, "/view/{$view}.php");
            if (!file_exists($path)) {
                app()->log('视图不存在:' . $view, null, core_app::LOG_ERROR);
                ob_clean();
                return '';
            }
        }
        app()->log('加载视图:' . addslashes($path));
        include($path);
        return ob_get_clean();
    }

    /**
     * 返回smarty模版对象
     * @return Smarty 
     */
    function smarty() {
        $modulePath = core_module::path(app()->getControllerName());
        $path = str_replace('/', DS, "{$modulePath}/template/");
        require_once(GG_DIR . '/vendor/smarty/libs/Smarty.class.php');
        $smarty = new Smarty();
        $smarty->setTemplateDir($path);
        return $smarty;
    }

}