<?php

/**
 * PHP视图模板
 * @package core
 */
class core_view {

    /**
     * php文件作为原始模版
     * @param string $view 模版名称
     * @param type $data 模版数据
     * @return string 
     */
    function php($data=null,$view=null) {
        if (empty($view)) {
            $view = app()->getActionName();
        }

        if (!preg_match("/^[_0-9a-zA-Z]+$/", $view))
            throw new Exception('invalid view' . $view);

        ob_start();
        $modulePath = core_module::path(app()->getControllerName());
        $path = str_replace('/', DS, "{$modulePath}/template/{$view}.php");
        if (!file_exists($path)) {
            $path = APP_DIR . str_replace('/', DS, "/src/template/{$view}.php");
            if (!file_exists($path)) {
                $path = GG_DIR . str_replace('/', DS, "/view/template/{$view}.php");
            }
            if (!file_exists($path)) {
                app()->log('视图不存在:'.$view, null, core_app::LOG_ERROR);
                ob_clean();
                return '';
            }
        }
        app()->log('加载视图:'.addslashes($path));
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
        require_once(GG_DIR . '/lib/smarty/libs/Smarty.class.php');
        $smarty = new Smarty();
        $smarty->setTemplateDir($path);
        return $smarty;
    }

}