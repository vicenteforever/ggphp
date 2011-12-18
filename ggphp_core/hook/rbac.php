<?php

/**
 * 基于角色的权限认证
 * @package hook
 * @author goodzsq@gmail.com
 */
class hook_rbac implements hook_interface {
    
    public function hook() {
	$perm = app()->getController() . '::' . app()->getAction();
        $perm = strtolower($perm);
	if(!self::access($perm)){
            session()->redirect_url = uri();
	    redirect(url('rbac', 'login'));
	}
    }
    
    /**
     * 权限认证
     * @param string $perm
     * @return bool true:allow false:forbidden
     */
    function access($perm) {
	if($perm == 'rbac::login' || $perm=='rbac::logincheck'){
	    return true;
	}
	return rbac_auth::access($perm);
    }

}