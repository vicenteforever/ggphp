<?php

class config_loader{

	/**
	 * 读取系统配置信息
	 * 将应用目录下的配置文件与框架的配置合并 应用目录的配置优先于框架的配置 并将配置数据缓存
	 * @param string $file 配置名称
	 * @param string $id 配置方案
	 * @return array
	 * @example $config = config('database', 'default')//获取database配置文件中的default配置
	 */
	static function load($file, $key=''){
		static $data;
		if(!isset($data[$file])){
			$appConfigFile = APP_DIR.DS.'src'.DS.'config'.DS.$file.'.php';
			if(file_exists($appConfigFile)){
				$appConfig = include($appConfigFile);
			}
			else{
				$appConfig = array();
			}
			$ggConfigFile =GG_DIR.DS.'config'.DS.$file.'.php';
			if(file_exists($ggConfigFile)){
				$ggConfig = include($ggConfigFile);
			}
			else{
				$ggConfig = array();
			}
			$data[$file] = array_merge($ggConfig, $appConfig);
		}
		if(empty($key)){
			return $data[$file];
		}
		else{
			if(isset($data[$file][$key]))
				return $data[$file][$key];
			else
				return null;
		}
	}

}