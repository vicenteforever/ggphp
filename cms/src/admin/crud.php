<?php

/**
 * model crud
 * @package admin
 * @author goodzsq@gmail.com
 */
abstract class admin_crud {

    protected $_modelName;
    protected $_model;

    public function __construct() {
        $this->_model = orm($this->_modelName);
    }

    function do_migrate() {
        $this->_model->migrate();
        $this->_model->debug();
    }

    function do_edit() {
        jquery()->ajaxSubmit("form");
        $id = param('id');
        $entity = $this->_model->get($id);
        $url = url('admin', $this->_modelName, 'save');
        return $this->_model->helper()->form($url, $entity);
    }

    function do_save() {
        $id = param('id');
        if (empty($id)) {
            $entity = $this->_model->get();
            $this->fillData($entity);
            $this->_model->insert($entity);
        } else {
            $entity = $this->_model->get(param('id'));
            $this->fillData($entity);
            $this->_model->save($entity);
        }
        $result = array('status'=> 'ok', 'redirect'=>url('admin', $this->_modelName, 'index'));
        echo response()->json($result);
        exit;
        //redirect(url('admin', $this->_modelName, 'index'));
    }

    function do_delete() {
        $id = param('id');
        $this->_model->delete(array('id' => $id));
        redirect(url('admin', $this->_modelName, 'index'));
    }

    function do_index() {
        $header = array();
        foreach ($this->_model->helper()->field() as $key => $value) {
            $header[$key] = $value->label;
        }
        $header['admin'] = '管理';
        $data = array($header);
        $url = url('admin', $this->_modelName, 'edit');
        $buf = util_html::a($url, '添加');
        foreach ($this->_model->all() as $row) {
            $param = array('id' => $row->id);
            $url = url('admin', $this->_modelName, 'edit', $param);
            $edit = util_html::a($url, '编辑');
            $url = url('admin', $this->_modelName, 'delete', $param);
            $delete = util_html::a($url, '删除');
            $rowData = $row->toArray();
            $rowData['admin'] = "$edit $delete";
            $data[] = $rowData;
        }
        return $buf . widget('table')->setData($data)->render();
    }

    private function fillData(&$entity) {
        foreach ($this->_model->helper()->field() as $key => $value) {
            $entity->$key = param($key);
        }
        $error = $this->_model->helper()->validate($entity);
        if (!empty($error)) {
            $result = array('status'=> 'fail', 'error'=>$error);
            echo response()->json($result);
            exit;
        }
    }

}
