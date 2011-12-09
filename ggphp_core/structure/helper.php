<?php

class structure_helper {
	protected $_fields;
	protected $_schema;
	protected $_adapter;
	function __construct($schemaName){
		$this->_schema = $schemaName;
		if(!is_array($this->_fields)) $this->_fields = array();
		$config = config("schema/{$schemaName}");
		if(!is_array($config)) $config = array();
		$config = array_merge($this->_fields, $config);
		foreach($config as $v){
			if(empty($v['name'])){
				throw new Exception('field name not assign');
			}
			$fieldType = "field_{$v['field']}_type";
			$fieldObject = new $fieldType($v);
			$this->_fields[$v['name']] = $fieldObject;
		}
		$database = config('database', 'default');

		$this->_adapter = new phpDataMapper_Adapter_Mysql(pdo(), $database['database']);
	}
	
	function field($fieldName = null){
		if(isset($fieldName)){
			if(isset($this->_fields[$fieldName])){
				$this->_fields[$fieldName];
			}
			else{
				return null;
			}
		}
		else{
			return $this->_fields;
		}
	}

	function fieldValue($field, $entity){
		if(!isset($this->_fields[$field])){
			return null;
		}
		if(isset($entity->$field)){
			return $entity->$field;
		}
		else{
			return null;
		}	
	}
	
	/**
	 * 校验检查值
	 * @param type $entity 
	 * @return array
	 */
	function validate($entity){
		$error = array();
		foreach($this->_fields as $k=>$v){
			$value = $this->fieldValue($k, $entity);
			$err = $v->validate($value);
			if($err!==true){
				$error[$k] = $err;
			}
		}
		return $error;
	}
	
	/**
	 * 构建输入窗体
	 * @param type $entity 
	 */
	function form($action, $entity=null, $prefix='', $suffix=''){
		$buf = "<form name=\"{$this->_schema}\" action=\"$action\">{$prefix}";
		foreach($this->_fields as $k=>$v){
			$value = $this->fieldValue($k, $entity);
			if($v->hidden){//@todo: 
				$buf .= $v->widget_hidden($value) . '<br />';
			}
			else{
				$buf .= $v->widget_input($value) . '<br />';
			}
		}
		$buf .= "{$suffix}</form>";
		return $buf;
	}
	
	function schema(){
		return $this->_schema;
	}
	
	function adapter(){
		return $this->_adapter;
	}
}