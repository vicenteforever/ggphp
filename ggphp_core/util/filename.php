<?php
/**
 * @author goodzsq@gmail.com
 */
class util_filename {

	/**
	 * ��ȡ�ļ���չ��
	 * @param string $filename
	 * @return string
	 */
	static function file_ext($filename){
		$tmp = explode('.', $filename);
		return strtolower(end($tmp));
	}

	/**
	 * ��ȡ�ϼ�Ŀ¼
	 * @param string $filename
	 * @return string
	 */
	static function parent_dir($filename){
		$file = str_replace(DS, '/', $filename);
		return str_replace('/', DS, dirname($filename));
	}

	/**
	 * �ж��ļ������Ƿ�Ϸ�
	 * @param string $filename
	 * @return bool
	 */
	static function isValidFileName($filename) {
		/* don't allow .. and allow any "word" character \ / */
		return preg_match('/^(((?:\.)(?!\.))|\w)+$/', $filename);
	}
}