<?php

/**
 * 多国语言支持
 * @package core
 */
class core_language {

	/**
	 *
	 * @staticvar type $language
	 * @return string 
	 */
	static function get_language() {
		static $language;
		if (!isset($language)) {
			$language = param('lang');
			if (empty($language) && isset($_SESSION['lang']))
				$language = $_SESSION['lang'];
			if (empty($language)) {
				if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
					if (preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) {
						$language = strtolower($matches[1]);
					}
				}
			}
			if (empty($language))
				$language = 'no';
		}
		return $language;
	}

	static function translate($str, $language=null) {
		static $data;
		if (empty($language)) {
			$language = self::get_language();
		}
		if (!isset($data[$language])) {
			$language = str_replace('-', '_', $language);
			if (!preg_match("/^[_0-9a-zA-Z]+$/", $language))
				throw new Exception('invalid language:' . $language);
			$file = APP_DIR . DS . 'src' . DS . 'config' . DS . 'language' . DS . $language . '.php';
			if (file_exists($file))
				$appdata = include($file);
			else
				$appdata = array();
			$file_core = GG_DIR . DS . 'config' . DS . 'language' . DS . $language . '.php';
			if (file_exists($file_core))
				$coredata = include($file_core);
			else
				$coredata = array();
			$data[$language] = array_merge($coredata, $appdata);
		}
		if (isset($data[$language][$str]))
			return $data[$language][$str];
		else
			return $str;
	}

}