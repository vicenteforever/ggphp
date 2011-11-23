<?php
/**
 * 请求对象的封装
 */
class GG_Request {

	/**
	 * 得到当前客户端的IP
	 * 
	 * @return string 当前客户端的IP
	 */
	function ip() {
		static $ip;
		if(!isset($ip)){
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
				$ip = getenv("HTTP_CLIENT_IP");
			}
			elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			}
			elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
				$ip = getenv("REMOTE_ADDR");
			}
			elseif (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
				$ip = $_SERVER["REMOTE_ADDR"];
			}
			else {
				$ip = "0.0.0.0";
			}
		}
		return $ip;
	}

	/**
	 * 取得请求的方法
	 * GET, POST, PUT ...
	 * @return string|null
	 */
	function method() {
		if (isset($_SERVER["REQUEST_METHOD"])) {
			return $_SERVER["REQUEST_METHOD"];
		}
		return null;
	}

	/**
	 * 取得参数值
	 * @param string $key 参数名
	 * @return mixed
	 */
	function param($key) {
		if(is_integer($key)){
			if(isset($_REQUEST['arg'][$key])){
				return $_REQUEST['arg'][$key];
			}
			else{
				return null;
			}
		}
		else{
			if(isset($_REQUEST[$key]))
				return $_REQUEST[$key];
			else
				return null;
		}
	}

	/**
	 * 判断是否为GET方法
	 * @return boolean
	 */
	function isGet() {
		return self::method() == "GET";
	}
	
	/**
	 * 判断是否为POST方法
	 * @return boolean
	 */ 
	function isPost() {
		return self::method() == "POST";
	}
	
	/**
	 * 判断是否为PUT方法
	 * @return boolean
	 */
	function isPut() {
		return self::method == "PUT";
	}
	
	/**
	 * 取得正在执行的脚本
	 * @return string
	 */
	function script() {
		if (isset($_SERVER["SCRIPT_NAME"])) {
			return $_SERVER["SCRIPT_NAME"];
		}
		if (isset($_SERVER["PHP_SELF"])) {
			return $_SERVER["PHP_SELF"];
		}
		return null;
	}
	
	/**
	 * 取得URI
	 * @return string
	 */
	function uri() {
		static $uri;
		if(!isset($uri)){
			if (isset($_SERVER["REQUEST_URI"])) {
				if(util_string::is_utf8($_SERVER["REQUEST_URI"]))
					$uri = $_SERVER["REQUEST_URI"];
				else
					$uri = utf8($_SERVER["REQUEST_URI"]);
			}
			else{
				$uri = '';
			}
		}
		return $uri;
	}

	/**
	 * 取得BaseUrl
	 * @return string
	 */
	function baseUrl(){
		static $baseurl;
		if(!isset($baseurl)){
			$baseurl = rtrim(str_replace('/index.php', '', $_SERVER["SCRIPT_NAME"]), '/').'/';
		}
		return $baseurl;
	}

	function fullPath(){
		static $fullpath;
		if(!isset($fullpath)){
			$fullpath = self::baseUrl().self::path();
		}
		return $fullpath;
	}

	/**
	 * 获取请求路径
	 * @return string
	 */
	function path(){
		static $path;
		if(!isset($path)){
			$path = trim(self::server("PATH_INFO"), '/');
		}
		return $path;
	}

	/**
	 * 取得输入
	 * @return string
	 */
	function input() {
		return file_get_contents("php://input");
	}

	/**
	 * 取得$_SERVER中的参数值
	 * @return string|null
	 */
	function server($param) {
		return isset($_SERVER[$param])?$_SERVER[$param]:null;
	}


	/**
	 * 判断是否为AJAX请求
	 * @return boolean
	 */
	function isAjax() {
		return self::server("HTTP_X_REQUESTED_WITH") == "XMLHttpRequest";
	}
	
	/**
	 * 判断是否为Flash请求
	 * @return boolean
	 */
	function isFlash() {
		return $self::server("HTTP_USER_AGENT") == "Shockwave Flash";
	}

}
