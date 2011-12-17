<?php

/**
 * 权限认证
 * @package hook
 * @author goodzsq@gmail.com
 */
class hook_auth implements hook_interface {
    
    public function hook() {
	session()->start()->role = array('test123', 'administratord ');//test
	$perm = app()->getController() . '::' . app()->getAction();
	if(!self::access($perm)){
	    echo html('认证失败');
	    exit;
	}
    }
    
    /**
     * 权限认证
     * @param string $perm
     * @return bool true:allow false:forbidden
     */
    function access($perm) {
	return rbac_auth::access($perm);
    }

}