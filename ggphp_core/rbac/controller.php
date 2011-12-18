<?php

class rbac_controller {

    function doIndex() {
        return html('rbac基于角色的权限控制模块');
    }

    /**
     *  用户登录
     */
    function doLogin() {
        $user = orm('user')->helper();
        $suffix = "<input type='hidden' name='redirect_url' value='".session()->redirect_url."' />";
        $suffix .= "<input type='submit' />";
        return html($user->form('logincheck', null, '', $suffix));
    }
    
    /**
     * 用户登录检查
     */
    function doLoginCheck(){
        session()->role = 'administrator';
        redirect (param('redirect_url'));
    }

    function doLogout() {
        //@todo:用户注销
    }

    function doList() {
        //@todo:用户列表
    }

    function doRegister() {
        
    }

    function doUpdate() {
        
    }

    function doDelete() {
        
    }

}