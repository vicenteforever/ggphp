<?php

/**
 * controller
 * @package user
 * @author Administrator
 */
class user_controller {
	
	function index(){
		return html('用户管理');
	}
	
	function login(){
		return html('权限错误');
	}
}

?>
