<?php

/**
 * controller
 * @package user
 * @author Administrator
 */
class user_controller {
	
	function do_index(){
		return html('用户管理');
	}
	
	function do_login(){
		return html('权限错误');
	}
}

?>
