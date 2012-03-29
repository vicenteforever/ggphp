<?php

class rbac_controller {

    function do_index() {
        return 'rbac基于角色的权限控制模块';
    }

    /**
     *  用户登录
     */
    function do_login() {

    }
    
    /**
     * 用户登录检查
     */
    function do_loginCheck(){
        session()->role = 'administrator';
        redirect (param('redirect_url'));
    }

    function do_logout() {

    }

    function do_list() {

    }

    function do_register() {
        
    }

    function do_update() {
        
    }

    function do_delete() {
        
    }

}