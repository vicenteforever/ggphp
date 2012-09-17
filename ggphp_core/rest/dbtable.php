<?php

/**
 * 数据库表的基本操作，绑定字段集的校验、编码、额外存储功能
 * @package rest
 * @author $goodzsq@gmail.com
 */
abstract class rest_dbtable implements rest_interface {

    private $_model;

    /** @var field_collection * */
    private $_fieldset;

    /**
     * 对应数据库表名称 
     * @return string
     */
    abstract protected function tableName();

    /**
     * 数据表的字段描述
     * @return array 
     */
    abstract protected function schemaData();

    public function __construct() {
        $this->_model = $this->model();
        $this->_fieldset = new field_collection($this->schemaData());
    }

    public function delete($id) {
        $data = $this->_model->get($id);
        $data = $this->_fieldset->decode($data);
        $this->_fieldset->delete($data);
        $this->deleteCache($id);
        return $this->_model->delete($id);
    }

    public function deleteAll() {
        
    }

    public function get($id) {
        $result = $this->_model->get($id);
        $result = $this->_fieldset->decode($result);
        return $this->_fieldset->load($result, '');
    }

    public function index($params = null) {
        return $this->_model->index($params);
    }

    public function post($id, $data) {
        $error = $this->_fieldset->validate($data);
        if (empty($error)) {
            $data = $this->_fieldset->encode($data);
            //保存数据
            $newId = $this->_model->post($id, $data);
            //保存额外数据
            $this->_fieldset->save(null, $data, array('table' => $this->tableName(), 'rowid' => $newId));
            $this->cache($newId);
            return $newId;
        } else {
            throw new exception_validate($error);
        }
    }

    /**
     * 修改
     * @param string $id
     * @param array $data
     * @return boolean 
     */
    public function put($id, $data) {
        //读取老数据
        $oldData = $this->_model->get($id);
        $oldData = $this->_fieldset->decode($oldData);
        //保存新数据
        $error = $this->_fieldset->validate($data);

        if (empty($error)) {
            //编码数据
            $newData = $this->_fieldset->encode($data);
            //保存数据
            $this->_model->put($id, $newData);
            //保存额外数据
            $this->_fieldset->save($oldData, $data, array('table' => $this->tableName(), 'rowid' => $id));
            $this->cache($id);
        } else {
            throw new exception_validate($error);
        }
    }

    public function struct() {
        return $this->_fieldset->fields();
    }
    
    protected function model(){
        return db()->get($this->tableName());
    }
    
    /**
     * 缓存的实现 
     */
    protected function cache($id){
        
    }

    /**
     * 参数缓存的实现 
     */
    protected function deleteCache($id){
        
    }
    
}