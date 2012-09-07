<?php

/**
 * 用户上传文件资源
 * @package rest 
 * @author $goodzsq@gmail.com
 */
class rest_userfile implements rest_interface {
    
    public $name = 'userfile';
    
    /** @var rest_interface */
    private $_model;

    /** @var field_collection * */
    private $_fieldset;
    
    private $_data = array(
        array('label' => 'ID', 'name' => 'id', 'field' => 'serial'),
        array('label' => '文件路径', 'name' => 'filename', 'field' => 'string'),
        array('label' => '文件名称', 'name' => 'name', 'field' => 'string'),
        array('label' => 'MIME类型', 'name' => 'mime', 'field' => 'string'),
        array('label' => '扩展名', 'name' => 'ext', 'field' => 'string'),
        array('label' => '文件尺寸', 'name' => 'size', 'field' => 'int'),
        array('label' => '上传日期', 'name' => 'uploadtime', 'field' => 'datetime'),
        array('label' => 'MD5', 'name' => 'md5', 'field' => 'string'),
        array('label' => '用户', 'name' => 'user', 'field' => 'string'),
        array('label' => '所属字段', 'name' => 'owner', 'field' => 'string', 'widget' => 'hidden'),
    );

    public function __construct() {
        $this->_model = db()->get('userfile');
        $this->_fieldset = new field_collection($this->_data);
    }

    public function delete($id) {
        return $this->_model->delete($id);
    }

    public function deleteAll() {
        
    }

    public function get($id) {
        try {
            $result = $this->_model->get($id);
        } catch (Exception $exc) {
            $result = null;
        }
        return $result;
    }

    public function index($params = null) {
        
    }

    public function post($id, $data) {
        return $this->_model->post($id, $data);
    }

    public function put($id, $data) {
        return $this->_model->put($id, $data);
    }

    public function struct() {
        return $this->_fieldset->fields();
    }

}