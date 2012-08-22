<?php

/**
 * 字符串常用函数
 * @package util
 * @author goodzsq@gmail.com
 */
class util_string {

    /**
     * 判断字符串是否为utf8
     * @param string $string
     * @return boolean
     */
    static function is_utf8($string) {
        return preg_match('%^(?:
			[\x09\x0A\x0D\x20-\x7E]				# ASCII
			| [\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
			|  \xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
			| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
			|  \xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
			|  \xF0[\x90-\xBF][\x80-\xBF]{2}	# planes 1-3
			| [\xF1-\xF3][\x80-\xBF]{3}			# planes 4-15
			|  \xF4[\x80-\x8F][\x80-\xBF]{2}	# plane 16
		)*$%xs', $string);
    }

    /**
     * 格式化显示计算机存储单位
     * @param integer $size
     * @return string
     */
    static function size_hum_read($size) {
        $i = 0;
        $iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
        while (($size / 1024) > 1) {
            $size = $size / 1024;
            $i++;
        }
        return substr($size, 0, strpos($size, '.') + 4) . $iec[$i];
    }

    /**
     * 生成绝对唯一的id
     * @return string
     */
    static function token() {
        return md5(uniqid(rand(), true));
    }

    /**
     * 将字符串哈希为0-9a-z的简短字符串
     * @param string $str 字符串
     */
    static function base36($str) {
        $hash = sprintf("%u", crc32($str));
        return base_convert($hash, 10, 36);
    }
    
}