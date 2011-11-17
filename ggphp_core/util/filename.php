<?php
/**
 * @author goodzsq@gmail.com
 */
class util_filename {

	/**
	 * 获取文件扩展名
	 * @param string $filename
	 * @return string
	 */
	static function file_ext($filename){
		$tmp = explode('.', $filename);
		return strtolower(end($tmp));
	}

	/**
	 * 获取上级目录
	 * @param string $filename
	 * @return string
	 */
	static function parent_dir($filename){
		$file = str_replace(DS, '/', $filename);
		return str_replace('/', DS, dirname($filename));
	}

	/**
	 * 判断文件名称是否合法
	 * @param string $filename
	 * @return bool
	 */
	static function isValidFileName($filename) {
		/* don't allow .. and allow any "word" character \ / */
		return preg_match('/^(((?:\.)(?!\.))|\w)+$/', $filename);
	}
}