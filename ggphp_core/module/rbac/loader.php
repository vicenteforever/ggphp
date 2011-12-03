<?php

/**
 * 基于角色的访问控制 Role-Base Access Control
 */
class module_rbac_loader {

	private function load($model){
		static $data;
		if(!isset($data[$model])){
			$data[$model] = storage('file', 'rbac')->load($model);
		}
		return $data[$model];
	}

	/**
	 * 加载角色数据
	 * @param string $rid role_id
	 * @return array
	 */
	public function role($rid=null){
		$data = self::load('role');
		if(isset($rid)){
			return $data[$rid];
		}
		else{
			return $data;
		}
	}

	/**
	 * 加载用户数据
	 * @param string $uid user_id
	 * @return array
	 */
	function user($uid=null){
		$data = self::load('user');
		if(isset($uid)){
			return $data[$uid];
		}
		else{
			return $data;
		}
	}

	/**
	 * 加载用户组数据
	 * @param string $gid group_id
	 * @return array
	 */
	function group($gid=null){
		$data = self::load('group');
		if(isset($gid)){
			return $data[$gid];
		}
		else{
			return $data;
		}
	}

	/**
	 * 模块列表
	 */
	function module(){
		static $module;
		if(!isset($module)){
			$module = array();
			if(is_dir(GG_DIR.DS.'module')){
				$core_module = scandir(GG_DIR.DS.'module');
				foreach($core_module as $row){
					if($row!='.' && $row!='..'){
						$module[$row] = GG_DIR;
					}
				}
			}
			if(is_dir(APP_DIR.'src'.DS.'module')){
				$app_module = scandir(APP_DIR.'src'.DS.'module');
				foreach($app_module as $row){
					if($row!='.' && $row!='..'){
						$module[$row] = APP_DIR;
					}
				}
			}
		}
		return $module;
	}

	/**
	 * 权限列表
	 */
	function action($module){
		static $perm;
		if(!isset($perm[$module])){
			$controller = 'module_'.$module.'_controller';
			$methods = get_class_methods($controller);
			$perm[$module] = array();
			foreach($methods as $method){
				if(strpos($method, config('app', 'action_prefix')) === 0){
					$perm[$module][] = $method;
				}
			}
		}
		return $perm[$module];
	}
}