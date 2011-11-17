<?php

/**
 * 应用类封装test
 * @author goodzsq@gmail.com
 */
class GG_App {

	private static $instance;
	private $_controller;
	private $_action;

	private function __construct(){
	}

	static function instance(){
		if(!self::$instance){
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * 程序入口, 启动APP
	 */
	static function start(){
		$app = self::instance();
		if(!$app->parseFromConfig()){
			if(param('GG_REWRITE')){
				$app->parseFromPath();
			}
			else{
				$app->parseFromParam();
			}
		}
		$app->exec($app->_controller, $app->_action);
	}

	function exec($controller, $action){
		if(!preg_match("/^[_0-9a-zA-Z]+$/", $controller))
			throw new Exception('invalid controller:'.$controller);
		if(!preg_match("/^[_0-9a-zA-Z]+$/", $action))
			throw new Exception('invalid action:'.$action);

		$controllerName = 'Controller_'.$controller;
		$actionName = config('app', 'action_prefix').$action;
		$controller = new $controllerName;
		if(method_exists($controller, $actionName)){
			$result = $controller->$actionName();
		}
	}

	private function parseFromConfig(){
		$path = path();
		$config = config('router');
		foreach($config as $k=>$v){
			if(preg_match($k, $path, $match)){
				$this->_controller = $v['controller'];
				$this->_action = $v['action'];
				array_shift($match);
				$_REQUEST['arg'] = $match;
				return true;
			}
		}
		return false;
	}

	private function parseFromParam(){
		$this->_controller = param('controller');
		if(empty($this->_controller))
			$this->_controller = config('app', 'default_controller');
		$this->_action = param('action');
		if(empty($this->_action))
			$this->_action = config('app', 'default_action');
	}
	/**
	 * 解析pathinfo
	 */
	private function parseFromPath(){
		$path = path();
		$path = str_replace('..', '', $path);
		$args = explode('/', $path);
		$defaultAction = config('app', 'default_action');
		$defaultController = config('app', 'default_controller');
		$prefix = config('app', 'action_prefix');
		if(empty($args[0])){
			//控制器和方法均为空 均设为默认值
			$args = array($defaultController, $defaultAction);
		}
		elseif(file_exists(APP_DIR.DS.'app'.DS.'controller'.DS.$args[0].'.php')){
			//路径中的控制器存在 very good
			if(empty($args[1])){
				$args[1] = $defaultAction;
			}
			elseif(!method_exists('controller_'.$args[0], $prefix.$args[1])){
				array_splice($args, 1, 0, $defaultAction);
			}
		}
		else{
			//args[0]不为空但是不是控制器
			array_unshift($args, $defaultController);
			if(empty($args[1])){
				$args[1] = $defaultAction;
			}
			elseif(!method_exists('controller_'.$args[0], $prefix.$args[1])){
				array_splice($args, 1, 0, $defaultAction);
			}
		}

		$this->_controller = $args[0];
		$this->_action = $args[1];
		$_REQUEST['arg'] = array_slice($args, 2);
	}

	/**
	 * 获取控制器名称
	 */
	function getController(){
		return $this->_controller;
	}

	/**
	 * 获取控制器方法
	 */
	function getAction(){
		return $this->_action;
	}

	/**
	 * 记录系统日志
	 * @param string $message
	 */
	function log($message, $storage=null){
		if(!isset($storage)) $storage = config('app', 'log_storage');
		if(empty($storage)) return;
		$today = date('Y-m-d');
		$adapter = storage($storage, 'log');
		$data = $adapter->load($today);
		$data[] = date('Y-m-d H:i:s') . ' ' . $message;
		storage($storage, 'log')->save($today, $data);
	}

}