<?php

/**
 * 获取区块内容
 * @param string $moduleName 模块名称
 * @param string $methodName 方法名称
 * @return string 
 */
function block($moduleName, $methodName) {
    static $blockObject;
    $blockName = "{$moduleName}_block";
    if (!isset($blockObject[$blockName])) {
        $blockObject[$blockName] = new $blockName;
    }
    return $blockObject[$blockName]->block($methodName);
}

/**
 * 树状导航菜单对象
 * @staticvar menu_model $menu
 * @param string $menuName 菜单名称
 * @return menu_model 
 */
function menu($menuName) {
    static $menu;
    if (!isset($menu[$menuName])) {
        $menu[$menuName] = new menu_model($menuName);
    }
    return $menu[$menuName];
}

/**
 * widget部件工厂
 * @staticvar array $widget
 * @param string $widgetName
 * @return widget_base
 */
function widget($widgetName) {
    $className = "widget_$widgetName";
    return new $className;
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