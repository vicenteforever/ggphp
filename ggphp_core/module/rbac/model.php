<?php

class module_rabc_model{

	private $_modelId;
	private $_modelName;
	private $_fields;
	private $_data;
	private $_storage;

	function __construct($id, $name){
		$this->_modelId = $id;
		$this->_modelName = $name;
		$this->_storage = storage('file', 'rbac');
		$this->_data = $this->_storage->load($id);
	}

	private function addFieldFromArray($arr){
		if(empty($arr['id'])) throw new Exception('field id not assign');
		if(empty($arr['type'])) throw new Exception('field type not assign');
		if(empty($arr['label'])) $label = $arr['id'];
		$fieldName = 'field_'.$arr['type'];
		$field = new $fieldName;
		foreach($arr as $k=>$v){
			$field->$k = $v;
		}
		$this->_fields[$id] = $field;
	}

	function addField($id, $type, $label=null, $config=null){
		$arr = array('id'=>$id, 'type'=>$type, 'label'=>$label);
		$arr = array_merge($config, $arr);
		$this->addFieldFromArray($arr);
	}

	function loadField($model){
		$config = config('schema', $model);
		foreach($config as $k=>$v){
			$field_name = 'field_'.$v['type'];
			$this->addField($v);
		}
	}

	/**
	 * 获取字段信息
	 */
	function field($field=null){
		if(isset($field))
			return $this->_fields[$field];
		else
			return $this->_fields;
	}


	function set($key, $value){
		$this->_data[$key] = $value;
	}

	function save(){
		$this->_storage->save($this->_modelId, $this->_data);
	}

	function data($key){
		if(isset($key))
			return $this->_data[$key];
		else
			return $this->_data;
	}

}

$group = module_rbac_model('group', '用户组');
$group->addField('id', 'string', 'ID', array('primary'=>true));
$group->addField('name', 'string', '名称');

$group->
