<?php

class rbac_controller {

    private $_user;
    
    function __construct() {
	$this->_user = new rbac_user();
    }
    
    function doIndex() {
	return html('rbac基于角色的权限控制模块');
    }

    function doLogin() {
	//@todo:用户登录
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