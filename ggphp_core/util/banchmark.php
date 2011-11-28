<?php

/**
 * 程序性能测试 计算同一个标签从开始点到结束点的运行事件和内存使用，可以设置多个标签
 * @author goodzsq@gmail.com
 * @example
 * <code>
 * <?php
 * util_banchmark::start('aaa');
 * //dosomething...
 * util_banchmark::start('bbb');
 * //dosomething else...
 * util_banchmark::end('bbb');
 * util_banchmark::end('aaa');
 * echo util_banchmark::formatResult();
 * </code>
 */
class util_banchmark{

	private static $banchmark;
	
	/**
	 * 标记起始点
	 * @param string $label 开始点标签
	 */
	static function start($label=''){
		self::$banchmark[$label]['startTime'] = microtime(true);
		self::$banchmark[$label]['startMemory'] = memory_get_usage();
	}

	/**
	 * 标记结束点
	 * @param string $label 结束点标签
	 */
	static function end($label=''){
		self::$banchmark[$label]['endTime'] = microtime(true);
		self::$banchmark[$label]['endMemory'] = memory_get_usage();	
	}

	/**
	 * 格式化显示性能测试结果
	 * @return string 
	 */
	static function formatResult(){
		$buffer = '';
		foreach(self::$banchmark as $key=>$value){
			$time = $value['endTime'] - $value['startTime'];
			$time = sprintf('%f', $time);
			$memory = $value['endMemory'] - $value['startMemory'];
			$buffer .= "[$key] time:$time memory:$memory <br>";
		}
		return $buffer;
	}
	
	/**
	 * 返回性能测试原始数组
	 * @return array 
	 */
	static function result(){
		return self::$banchmark;
	}
}
