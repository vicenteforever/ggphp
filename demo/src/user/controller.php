<?php

/**
 * controller
 * @package user
 * @author Administrator
 */
class user_controller {
	
	function doIndex(){
		return html('用户管理');
	}
	
	function doLogin(){
		return html('权限错误');
	}
}

?>
