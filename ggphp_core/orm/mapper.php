<?php

include_once(GG_DIR . '/lib/phpDataMapper/Base.php');

class orm_mapper extends phpDataMapper_Base {

    protected $_helper;

    public function __construct($schemaName) {
	$helper = new orm_helper($schemaName);
	foreach ($helper->field() as $fieldName => $field) {
	    $this->_datasource = $helper->schema();
	    $arr = array();
	    $arr['type'] = $field->type;
	    $arr['default'] = $field->default;
	    $arr['length'] = $field->length;
	    $arr['required'] = $field->required;
	    $arr['null'] = $field->null;
	    $arr['unsigned'] = $field->unsigned;
	    $arr['primary'] = $field->primary;
	    $arr['index'] = $field->index;
	    $arr['unique'] = $field->unique;
	    $arr['serial'] = $field->serial;
	    $arr['relation'] = $field->relation;
	    $this->$fieldName = $arr;
	}
	$this->_helper = $helper;
	parent::__construct($helper->adapter());
    }

    /**
     * get helper object
     * @return orm_helper
     */
    public function helper() {
	return $this->_helper;
    }

    public function validate(phpDataMapper_Entity $entity) {
	$error = $this->_helper->validate($entity);
	if (empty($error)) {
	    return true;
	} else {
	    foreach ($error as $field => $msg) {
		$this->error($field, $msg);
	    }
	}
    }

}