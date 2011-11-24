<?php
/**
 * 共用函数包
 * @author goodzsq@gmail.com
 */


/**
 * 获取全局应用对象
 * @return app
 */
function app(){
	return GG_App::instance();
}

/**
 * 获取存取数据服务对象
 * @param string $table
 * @param string $storage
 * @return object;
 * @example storage('database', 'log_table')->save('2000-01-01 00:00:00', '新世纪开始');
 */
function storage($storage, $group){
	static $storage_object;
	$key = $storage.$group;
	if(!isset($storage_object[$key])){
		try{
			$adapter = 'storage_adapter_'.$storage;
			$storage_object[$key] = new $adapter($group);
		}catch(Exception $e){
			throw new Exception(t('storage not exists').":[{$storage}]");
		}
	}
	return $storage_object[$key];
}

/**
 * 读取系统配置信息
 * 将应用目录下的配置文件与框架的配置合并 应用目录的配置优先于框架的配置 并将配置数据缓存
 * @param string $file 配置名称
 * @param string $id 配置方案
 * @return array
 * @example $config = config('database', 'default')//获取database配置文件中的default配置
 */
function config($file, $key=''){
	static $data;
	if(!isset($data[$file])){
		$appConfigFile = APP_DIR.DS.'APP'.DS.'config'.DS.$file.'.php';
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

/**
 * 获取pdo数据库对象
 * @param string $dbname 数据库配置文件config/database.php中的配置名称
 * @return mixed
 */
function pdo($dbname='default'){
	static $pdo;
	if(empty($dbname)) $dbname='default';
	if(!isset($pdo[$dbname])){
		$config = config('database', $dbname);
		try{
			$pdo[$dbname] = new PDO($config['DSN'], $config['username'], $config['password'], $config['driver_opts']);
			if(!empty($config['charset'])){
				$pdo[$dbname]->exec("SET names '{$config['charset']}'");
			}
		}catch(PDOException $exception){
			throw new Exception(t("连接数据库失败") . $exception->getMessage());
		}
	}
	return $pdo[$dbname];
}

/**
 * 加载视图
 * @param string $viewName
 * @param array $data
 * @return string
 */
function view($view=null, $data=null){
	if(empty($view)){
		$view = app()->getAction();
	}

	if(!preg_match("/^[_0-9a-zA-Z]+$/", $view))
		throw new Exception('invalid view'.$view);

	ob_start();
	$path = APP_DIR.DS.'app'.DS.'views'.DS.app()->getController().DS.$view.".php";
	if (!file_exists($path)){
		$path = APP_DIR.DS.'app'.DS.'views'.DS.$view.".php";
		if (!file_exists($path)){
			$path = GG_DIR.DS.'views'.DS.$view.".php";
		}
		if (!file_exists($path)){
			app()->log('view not exists:'.$view);
			ob_clean();
			return '';
		}
	}
	include($path);
	return ob_get_clean();
}

/**
 * 获取memcache对象
 * @param $config memcache配置
 * @return memcache
 */
function memcache($config){
	static $memcache;
	if(!isset($memcache[$config])){
		$memcache[$config] = new Memcache();
		$cfg = config('memcache', $config);
		if(empty($cfg)){
			throw new Exception(t('memcache config not found:')."[$config]");
		}
		if(!$memcache[$server]->connect($cfg['host'], $cfg['port'])){
			throw new Exception(t('memcache server fail'));
		}
	}
	return $memcache[$config];
}

/**
 * 打印输出变量值
 * @param string $str
 * @return null
 */
function o($str){
	echo $str;
}

function get_language(){
	static $language;
	if(!isset($language)){
		$language = param('lang');
		if(empty($language) && isset($_SESSION['lang'])) $language = $_SESSION['lang'];
		if(empty($language)) {
			if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
				if(preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)){
					$language = strtolower($matches[1]);
				}
			}
		}
		if(empty($language)) $language='no';
	}
	return $language;
}

/**
 * 本地化翻译字符串
 * @param string $str 需要翻译的字符串
 * @return string 返回翻译的字符串
 */
function t($str, $language=null){
	static $data;
	if(empty($language)) {
		$language = get_language();
	}
	if(!isset($data[$language])){
		$language = str_replace('-', '_', $language);
		if(!preg_match("/^[_0-9a-zA-Z]+$/", $language))
			throw new Exception('invalid language:'.$language);
		echo "load $language <br>";
		$file = APP_DIR.DS.'app'.DS.'language'.DS.$language.'.php';
		if(file_exists($file))
			$appdata = include($file);
		else
			$appdata = array();
		$file_core = GG_DIR.DS.'language'.DS.$language.'.php';
		if(file_exists($file_core))
			$coredata = include($file_core);
		else
			$coredata = array();
		$data[$language] = array_merge($coredata, $appdata);
	}
	if(isset($data[$language][$str]))
		return $data[$language][$str];
	else
		return $str;
}

/**
 * 启用session
 * 可保证仅调用一次session_start函数
 * @return array
 */
function use_session(){
	static $isStart;
	if(!isset($isStart)){
		session_start();
		$isStart = true;
	}
}

/**
 * 显示错误页面
 * @param $errorMessage
 */
function error($errorMessage){
	echo view('error', array('errorMessage'=>$errorMessage));
	exit;
}


/**
 * gbk转utf-8编码
 */
function utf8($str){
	if(util_string::is_utf8($str))
		return $str;
	else
		return iconv('gbk', 'utf-8', $str);
}

/**
 * utf-8转gbk编码
 */
function gbk($str){
	if(util_string::is_utf8($str))
		return iconv('utf-8', 'gbk', $str);
	else
		return $str;
}

/**
 * 获取提交的参数
 * @return mix
 */
function param($key){
	return GG_Request::param($key);
}

/**
 * 获取uri
 * @return string
 */
function uri(){
	return GG_Request::uri();
}

/**
 * 获取pathinfo
 * @return string
 */
function path(){
	return GG_Request::path();
}

/**
 * 获取完整路径信息
 * @return string
 */
function full_path(){
	return GG_Request::fullPath();
}

/**
 * 获取当前应用的baseurl
 * @return string
 */
function base_url(){
	return GG_Request::baseUrl();
}

/**
 * 生成url
 * @param string $controller
 * @param string $action
 * @param string $path
 * @return string
 */
function make_url($controller='', $action='', $path=''){
	if(param('GG_REWRITE')){
		$url = base_url().trim("$controller/$action/$path", '/');
	}
	else{
		$tmp = explode('/', $path);
		$params = '';
		if(!empty($path)){
			foreach($tmp as $k=>$v){
				$params .= 'arg[]='.$v.'&';
			}
			$params = trim($params, '&');
		}
		$url = base_url()."?controller=$controller&action=$action";
		if(!empty($params)) $url .= '&'.$params;
	}
	return $url;
}
