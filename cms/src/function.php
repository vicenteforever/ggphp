<?php

/**
 * 获取区块内容
 * @param string $moduleName 模块名称
 * @param string $methodName 方法名称
 * @return string 
 */
function block($moduleName, $methodName, $style='') {
    return widget('block', $moduleName, $methodName)->render($style);
}

/**
 * widget部件工厂
 * @staticvar array $widget
 * @param string $widgetName
 * @return widget_base
 */
function widget($widgetName, $id, $data) {
    $className = "widget_$widgetName";
    return new $className($id, $data);
}

/**
 * 取得jquery对象
 * @return \script_jquery 
 */
function jquery(){
    static $jquery;
    if(!isset($jquery)){
        $jquery = new script_jquery();
    }
    return $jquery;
}