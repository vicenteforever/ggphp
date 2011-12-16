<?php

/**
 * http请求类
 * @package core
 */
class core_request {

	/**
	 * 获取客户端ip地址
	 * @staticvar string $ip
	 * @return string 
	 */
	function ip() {
		static $ip;
		if (!isset($ip)) {
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			} elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
				$ip = getenv("REMOTE_ADDR");
			} elseif (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
				$ip = $_SERVER["REMOTE_ADDR"];
			} else {
				$ip = "0.0.0.0";
			}
		}
		return $ip;
	}

	/**
	 * 获取客户端请求方法 get post
	 * @return string
	 */
	function method() {
		if (isset($_SERVER["REQUEST_METHOD"])) {
			return $_SERVER["REQUEST_METHOD"];
		}
		return null;
	}

	/**
	 * 获取请求参数值
	 * @param string $key 参数名称
	 * @param bool $isFilter 是否使用过滤器
	 * @return string 
	 */
	function param($key, $isFilter) {
		$value = '';
		if (is_integer($key)) {
			if (isset($_REQUEST['arg'][$key])) {
				$value = $_REQUEST['arg'][$key];
			} else {
				return null;
			}
		} else {
			if (isset($_REQUEST[$key]))
				$value = $_REQUEST[$key];
			else
				return null;
		}
		//echo $isFilter;
		if ($isFilter) {
			$input_filters = config('app', 'input_filters');
			foreach ($input_filters as $filter) {
				$value = util_filter::$filter($value);
			}
			return $value;
		} else {
			return $value;
		}
	}

	/**
	 * 判断请求是否为get方法
	 * @return bool
	 */
	function isGet() {
		return self::method() == "GET";
	}

	/**
	 * 判断请求是否为post方法
	 * @return bool 
	 */
	function isPost() {
		return self::method() == "POST";
	}

	/**
	 * 判断请求是否为put方法
	 * @return bool 
	 */
	function isPut() {
		return self::method == "PUT";
	}

	/**
	 * 获取请求脚本名称
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
	 * 获取请求的uri
	 * @staticvar string $uri
	 * @return string 
	 */
	function uri() {
		static $uri;
		if (!isset($uri)) {
			if (isset($_SERVER["REQUEST_URI"])) {
				if (util_string::is_utf8($_SERVER["REQUEST_URI"]))
					$uri = $_SERVER["REQUEST_URI"];
				else
					$uri = utf8($_SERVER["REQUEST_URI"]);
			}
			else {
				$uri = '';
			}
		}
		return $uri;
	}

	/**
	 * 获取应用程序的baseurl
	 * @staticvar string $baseurl
	 * @return string 
	 */
	function baseUrl() {
		static $baseurl;
		if (!isset($baseurl)) {
			$baseurl = rtrim(str_replace('/index.php', '', $_SERVER["SCRIPT_NAME"]), '/') . '/';
		}
		return $baseurl;
	}

	/**
	 * 获取完整的请求路径
	 * @staticvar string $fullpath
	 * @return string 
	 */
	function fullPath() {
		static $fullpath;
		if (!isset($fullpath)) {
			$fullpath = self::baseUrl() . self::path();
		}
		return $fullpath;
	}

	/**
	 * 获取路径信息
	 * @staticvar string $path
	 * @return string 
	 */
	function path() {
		static $path;
		if (!isset($path)) {
			$path = trim(self::server("PATH_INFO"), '/');
		}
		return $path;
	}

	/**
	 * 获取提交的raw数据
	 * @return type 
	 */
	function input() {
		return file_get_contents("php://input");
	}

	/**
	 * 获取server中的变量
	 * @param string $param
	 * @return string 
	 */
	function server($param) {
		return isset($_SERVER[$param]) ? $_SERVER[$param] : null;
	}

	/**
	 * 判断请求是否为ajax请求
	 * @return bool 
	 */
	function isAjax() {
		return self::server("HTTP_X_REQUESTED_WITH") == "XMLHttpRequest";
	}

	/**
	 * 判断请求是否为flash请求
	 * @return bool 
	 */
	function isFlash() {
		return $self::server("HTTP_USER_AGENT") == "Shockwave Flash";
	}

}
