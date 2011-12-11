<?php

/**
 * 基于角色的访问控制 Role-Base Access Control
 */
class rbac_loader {

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

}