<?php

/**
 * 权限认证
 * @package core
 * @author goodzsq@gmail.com
 */
class core_auth {

	/**
	 * 权限认证
	 * @param string $perm
	 * @return bool true:allow false:forbidden
	 */
	static function access($perm){
		return self::rbac($perm);
	}
	
	/**
	 * 基于rbac的权限认证
	 */
	public function rbac($perm) {
		//$module_roles = storage('file', 'rbac')->load($perm);
		$module_roles = array('test');
		if (is_array($module_roles)) {
			//如果权限指定允许匿名访问 通过权限认证
			if (in_array('anonymous', $module_roles)) {
				app()->log('auth role:anonymous');
				return true;
			}
			
			session()->start();
			$user_roles = session()->role;
			if(!is_array($user_roles)){
				$user_roles = array($user_roles);
			}
			//如果用户是超级用户 直接通过认证
			if(in_array('administrator', $user_roles)){
				app()->log('auth role:administrator');
				return true;
			}
			//计算用户角色与模块角色的交集
			$common_roles = array_intersect($user_roles, $module_roles);
			if(!empty($common_roles)){
				app()->log('auth role:'. implode(' ', $common_roles));
				return true;
			}
			else{
				return false;
			}

		}
		return false;
	}

}