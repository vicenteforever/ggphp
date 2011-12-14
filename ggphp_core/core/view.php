<?php
/**
 * 视图类
 * @package core
 */
class core_view {

    /**
     * php文件作为原始模版
     * @param string $view 模版名称
     * @param type $data 模版数据
     * @return string 
     */
    function php($view=null, $data=null) {
        if (empty($view)) {
            $view = app()->getAction();
        }

        if (!preg_match("/^[_0-9a-zA-Z]+$/", $view))
            throw new Exception('invalid view' . $view);

        ob_start();
        $modulePath = core_module::path(app()->getController());
        $path = str_replace('/', DS, "{$modulePath}/template/{$view}.php");
        if (!file_exists($path)) {
            $path = APP_DIR . str_replace('/', DS, "/src/template/{$view}.php");
            if (!file_exists($path)) {
                $path = GG_DIR . str_replace('/', DS, "/view/template/{$view}.php");
            }
            if (!file_exists($path)) {
                app()->log('view not exists:' . $view);
                ob_clean();
                return '';
            }
        }
        app()->log('load view:' . $path);
        include($path);
        return ob_get_clean();
    }

    /**
     * 返回smarty模版对象
     * @return Smarty 
     */
    function smarty() {
        $modulePath = core_module::path(app()->getController());
        $path = str_replace('/', DS, "{$modulePath}/template/");
        require_once(GG_DIR . '/lib/Smarty-3.1.6/libs/Smarty.class.php');
        $smarty = new Smarty();
        $smarty->setTemplateDir($path);
        return $smarty;
    }

}