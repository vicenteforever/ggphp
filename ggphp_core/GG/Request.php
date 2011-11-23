<?php
/**
 * �������ķ�װ
 */
class GG_Request {

	/**
	 * �õ���ǰ�ͻ��˵�IP
	 * 
	 * @return string ��ǰ�ͻ��˵�IP
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
	 * ȡ������ķ���
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
	 * ȡ�ò���ֵ
	 * @param string $key ������
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
	 * �ж��Ƿ�ΪGET����
	 * @return boolean
	 */
	function isGet() {
		return self::method() == "GET";
	}
	
	/**
	 * �ж��Ƿ�ΪPOST����
	 * @return boolean
	 */ 
	function isPost() {
		return self::method() == "POST";
	}
	
	/**
	 * �ж��Ƿ�ΪPUT����
	 * @return boolean
	 */
	function isPut() {
		return self::method == "PUT";
	}
	
	/**
	 * ȡ������ִ�еĽű�
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
	 * ȡ��URI
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
	 * ȡ��BaseUrl
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
	 * ��ȡ����·��
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
	 * ȡ������
	 * @return string
	 */
	function input() {
		return file_get_contents("php://input");
	}

	/**
	 * ȡ��$_SERVER�еĲ���ֵ
	 * @return string|null
	 */
	function server($param) {
		return isset($_SERVER[$param])?$_SERVER[$param]:null;
	}


	/**
	 * �ж��Ƿ�ΪAJAX����
	 * @return boolean
	 */
	function isAjax() {
		return self::server("HTTP_X_REQUESTED_WITH") == "XMLHttpRequest";
	}
	
	/**
	 * �ж��Ƿ�ΪFlash����
	 * @return boolean
	 */
	function isFlash() {
		return $self::server("HTTP_USER_AGENT") == "Shockwave Flash";
	}

}
