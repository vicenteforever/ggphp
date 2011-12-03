<?php

/**
 * 应用类封装test
 * @author goodzsq@gmail.com
 */
class core_app {

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
		$app->log('application start');
		if(!$app->parseFromConfig()){
			if(config('app', 'only_use_router')){
				error('the router not allow:'.path());
			}
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

		$controllerName = $controller.'_controller';
		$actionName = config('app', 'action_prefix').$action;
		$classObject = new $controllerName;
		if(method_exists($classObject, $actionName)){
			$this->log("exec router: $controller :: $action ()");
			echo $classObject->$actionName();
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
				if(empty($this->_action)){
					$this->_action = array_shift($match);
				}

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
		//控制器和方法均为空 均设为默认值
		if(empty($args[0])){
			$args = array($defaultController, $defaultAction);
		}
		//路径中的控制器存在 very good
		else if(class_exists("{$args[0]}_controller")){
			if(empty($args[1])){
				$args[1] = $defaultAction;
			}
			elseif(!method_exists($args[0].'_controller', $prefix.$args[1])){
				array_splice($args, 1, 0, $defaultAction);
			}
		}
		//args[0]不为空但不是控制器
		else{
			array_unshift($args, $defaultController);
			if(empty($args[1])){
				$args[1] = $defaultAction;
			}
			elseif(!method_exists($args[0].'_controller', $prefix.$args[1])){
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

	function getModulePath($module){
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
	 * 获取控制器方法
	 */
	function getAction(){
		return $this->_action;
	}

	/**
	 * 记录系统日志
	 * @param string $message
	 */
	function log($message=null){
		static $log=array();
		if(isset($message)){
			$log[] = array('time'=>microtime(true), 'message'=>$message);
		}
		else{
			return $log;
		}
	}

	/**
	 * 报告程序运行情况
	 */
	function report(){
		$result = '';
		$this->log('application end');
		$log = $this->log();
		$time = $log[0]['time'];
		foreach($log as $k=>$v){
			$timespan = sprintf("%.4f", $v['time'] - $time);
			$time = $v['time'];
			$result .= "[{$timespan}] {$v['message']} <br/>";
		}
		$total =  sprintf("%.4f", $time - $log[0]['time']);
		$result .= "程序运行时间:$total ms, memory:".util_string::size_hum_read(memory_get_usage())." <br>";

		return $result;
	}

}