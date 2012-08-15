<?php

/**
 * 基于角色的权限认证
 * @package rbac
 * @author goodzsq@gmail.com
 */
class rbac_auth {

    /**
     * rbac权限认证规则
     * @param array $roles
     * @return boolean true=认证通过, false=认证失败
     */
    static public function access($roles) {
	if (empty($roles) || is_array($roles)) {
	    //如果权限指定允许匿名访问 通过权限认证
	    if (in_array('anonymous', $roles)) {
		app()->log('用户角色:anonymous');
		return true;
	    }

	    $user_roles = session()->role;
	    if (!is_array($user_roles)) {
		$user_roles = array($user_roles);
	    }
	    //如果用户是超级用户 直接通过认证
	    if (in_array('administrator', $user_roles)) {
		app()->log('用户角色:administrator');
		return true;
	    }
	    //计算用户角色与模块角色的交集
	    $common_roles = array_intersect($user_roles, $roles);
	    if (!empty($common_roles)) {
		app()->log('用户角色:' . implode(' ', $common_roles));
		return true;
	    } else {
		return false;
	    }
	}
	return false;
    }
    
    
}

