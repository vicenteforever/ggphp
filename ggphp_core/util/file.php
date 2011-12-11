<?php
/**
 * 文件名处理常用函数
 * @author goodzsq@gmail.com
 */
class util_file {

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
	 * 检查文件名称是否有效，不保护非法字符
	 * @param string $filename
	 * @return bool
	 */
	static function valid($filename) {
		/* don't allow .. and allow any "word" character \ / */
		return preg_match('/^(((?:\.)(?!\.))|\w)+$/', $filename);
	}

	static function subdir($dir){
		$result = array();
		if(is_dir($dir)){
			$list = scandir($dir);
			foreach($list as $file){
				if($file!='.' && $file!='..'){
					$path = $dir.DS.$file;
					if(is_dir($path)){
						$result[$file] = $path;
					}
				}
			}
		}
		return $result;
	}
}