<?php

abstract class field_object {

	private $_attribute = array(
		"value",	//值
		"type",		//数据类型
		"length",	//长度
		"name",		//字段名称
		"label",	//字段标签
		"required",	//是否必须填写
		"number",	//允许值的数量
		"index",	//索引类型
		"error",	//错误消息
		"dirty",	//数据是否改写过
	);
	private $_data;
	
	function __construct(){
		//$this->type = 'varchar';
		//$this->length = null;
		//$this->name = null;
		//$this->label = null;
		$this->required = false;
		$this->number = 1;
		$this->index = '';
		$this->error = '';
		$this->dirty = false;
	}

	/**
	 * 获取可以进行设置的属性名称
	 * @return array
	 */
	function attribute(){
		return $this->_attribute;
	}

	/**
	 * 验证数据格式是否有效
	 * @param mixed $value
	 * @return bool
	 */
	function isValidFormat($value){
		return true;
	}

}
