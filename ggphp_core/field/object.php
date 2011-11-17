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

	/**
	 * 是否是主键
	 * @return array
	 */
	function isPrimary(){
		return $this->index == 'PRIMARY';
	}

	/**
	 * 是否唯一
	 * @return array
	 */
	function isUnique(){
		return $this->index == 'UNIQUE';
	}

	/**
	 * 是否为索引
	 * @return array
	 */
	function isIndex(){
		return $this->index == 'INDEX';
	}

	function __get($key){
		if(!$this->isAttribute($key)){
			throw new Exception("the {$key} is not allow attribute");
		}
		$method = 'get'.ucfirst($key);
		if(method_exists($this, $method)){
			return $this->$method();
		}
		else{
			return $this->_data[$key];
		}
	}

	function __set($key, $value){
		if(!$this->isAttribute($key)){
			throw new Exception("the {$key} is not allow attribute");
		}
		$method = 'set'.ucfirst($key);
		if(method_exists($this, $method)){
			$this->$method($value);
		}
		else{
			$this->_data[$key] = $value;
		}
	}

	/**
	 * 给字段赋值
	 * @param mixed $value
	 */
	function setValue($value){
		if($this->required && empty($value)){
			$this->error = "{$this->label}字段内容必须填写";
			return;
		}
		if($this->isValidFormat($value) && $value!=@$this->_data['value']){
			$this->_data['value'] = $value;
			$this->dirty = true;
		}
	}

	/**
	 * 取出字段值
	 * @return mixed
	 */
	function getValue(){
		if (isset($this->_data['value']))
			return $this->_data['value'];
		else
			return null;
	}

	/**
	 * 判断是否为有效的属性
	 * @param string $type
	 * @return bool
	 */
	private function isAttribute($type){
		return in_array($type, $this->_attribute);
	}

}
