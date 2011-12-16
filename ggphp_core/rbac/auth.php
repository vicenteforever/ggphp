<?php

/**
 * 基于角色的权限认证
 * @package rbac
 * @author goodzsq@gmail.com
 */
class rbac_auth {
    
    /**
     * 检查
     * @param string $perm
     * @return bool true:allow false:forbidden
     */
    function check($perm){
	core_session::start();
	$roles = storage('file', 'rbac')->load($perm);
	if(is_array($roles)){
	    if(in_array($_SESSION['role'], $roles)){
		return true;
	    }
	}
	return false;
    }
    
}