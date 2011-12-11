<?php

class core_module{

	static function all(){
		static $modules;
		if(!isset($modules)){
			$modules = array_merge(util_file::subdir(GG_DIR), util_file::subdir(APP_DIR));
		}
		return $modules;
	}

	static function path($module){
		static $path;
		if(!isset($path[$module])){
			$path[$module] = APP_DIR.DS.'src'.DS.$module;
			if(!is_dir($path[$module])){
				$path[$module] = GG_DIR.DS.$module;
				if(!is_dir($path[$module])){
					$path[$module] = '';
				}
			}
		}
		return $path[$module];
	}

	/**
	 * get action
	 */
	static function action($module){
		static $action;
		if(!isset($action[$module])){
			$controller = $module.'_controller';
			$methods = get_class_methods($controller);
			$action[$module] = array();
			if(is_array($methods)){
				foreach($methods as $method){
					if(strpos($method, config('app', 'action_prefix')) === 0){
						$action[$module][] = $method;
					}
				}
			}
		}
		return $action[$module];
	}

}