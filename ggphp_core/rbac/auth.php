<?php

/**
 * 基于角色的权限认证
 * @package rbac
 * @author goodzsq@gmail.com
 */
class rbac_auth {

    /**
     * rbac权限认证规则
     * @param string $perm
     * @return bool true=认证通过, false=认证失败
     */
    static public function access($perm) {
	//$module_roles = storage('file', 'rbac')->load($perm);
	$module_roles = array('test');
	if (is_array($module_roles)) {
	    //如果权限指定允许匿名访问 通过权限认证
	    if (in_array('anonymous', $module_roles)) {
		app()->log('auth role:anonymous');
		return true;
	    }

	    $user_roles = session()->role;
	    if (!is_array($user_roles)) {
		$user_roles = array($user_roles);
	    }
	    //如果用户是超级用户 直接通过认证
	    if (in_array('administrator', $user_roles)) {
		app()->log('auth role:administrator');
		return true;
	    }
	    //计算用户角色与模块角色的交集
	    $common_roles = array_intersect($user_roles, $module_roles);
	    if (!empty($common_roles)) {
		app()->log('auth role:' . implode(' ', $common_roles));
		return true;
	    } else {
		return false;
	    }
	}
	return false;
    }
    
    
}

