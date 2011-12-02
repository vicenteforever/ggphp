<?php

class module_rbac_controller{

	function __construct(){
		//$perm = new module_user_perm();
		//$perm->check('user delete');
	}

	function doIndex(){
		return 'rbac controller';
	}

	function doDoc(){
		return GG_Response::html('用户认证模块', '用户认证模块123');
	}

	function doLogin(){
		//@todo:用户登录
	}

	function doLogout(){
		//@todo:用户注销
	}

	function doList(){
		//@todo:用户列表
	}

	function doRegister(){
	
	}

	function doUpdate(){
	
	}

	function doDelete(){

	}

}