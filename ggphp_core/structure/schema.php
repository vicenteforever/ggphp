<?php

/**
 * 数据结构描述
 * 描述一个表的字段集合
 */
class structure_schema{

	private $_name;
	private $_fields;

	function __construct($name){
		$this->_name = $name;
		$this->_fields = array();
		$this->loadField($name);
	}

	private function addFieldFromArray($arr){
		if(empty($arr['name'])) throw new Exception('field name not assign');
		if(empty($arr['type'])) throw new Exception('field type not assign');
		if(empty($arr['label'])) $label = $arr['id'];
		$fieldName = 'structure_field_'.$arr['type'];
		$field = new $fieldName;
		foreach($arr as $k=>$v){
			$field->$k = $v;
		}
		$this->_fields[$arr['name']] = $field;
	}

	/**
	 * 往结构中增加一个字段描述
	 * @param string $id
	 * @param string $type
	 * @param string $label
	 * @param array $opts
	 */
	function addField($name, $type, $label=null, $opts=array()){
		$arr = array('name'=>$name, 'type'=>$type, 'label'=>$label);
		$arr = array_merge($opts, $arr);
		$this->addFieldFromArray($arr);
	}

	/**
	 * 根据config/schema.php文件中字段描述构建字段集
	 * @param string $name 相关配置段名称
	 */
	function loadField($name){
		$config = config('schema', $name);
		if(is_array($config)){
			foreach($config as $k=>$v){
				$field_name = 'field_'.$v['type'];
				$this->addField($v);
			}
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

}
