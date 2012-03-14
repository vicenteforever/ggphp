<?php

/**
 * model crud
 * @package admin
 * @author goodzsq@gmail.com
 */
abstract class admin_crud {

    protected $_modelName;
    protected $_model;
    protected $_displayCount = 20;

    public function __construct() {
        $this->_model = orm($this->_modelName);
    }

    function do_migrate() {
        $this->_model->migrate();
        $this->_model->debug();
    }

    function do_edit() {
        $helper = $this->_model->helper();
        $helper->url = url('admin', $this->_modelName, 'save');
        $helper->entity = $this->_model->get(param('id'));
        $buf = widget('form', $this->_modelName, $helper)->render();
        return $buf;
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
        $result = array('status' => 'ok', 'redirect' => url('admin', $this->_modelName, 'index'));
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
        foreach ($this->_model->helper()->fields() as $key => $value) {
            $header[$key] = $value->label;
        }
        $header['admin'] = '管理';
        $data = array($header);
        $url = url('admin', $this->_modelName, 'edit');
        $buf = util_html::a($url, '添加');

        $query = $this->_model->all();
        $pager = new orm_pager($query, param('page'), $this->_displayCount);
        foreach ($query as $row) {
            $param = array('id' => $row->id);
            $url = url('admin', $this->_modelName, 'edit', $param);
            $edit = util_html::a($url, '编辑');
            $url = url('admin', $this->_modelName, 'delete', $param);
            $delete = util_html::a($url, '删除');
            $rowData = $row->toArray();
            $rowData['admin'] = "$edit $delete";
            $data[] = $rowData;
        }
        $buf .= widget('table', $this->_modelName, $data)->render();
        $buf .= $pager->render(url('admin', $this->_modelName, 'index') . '?');
        $this->_model->debug();
        return $buf;
    }

    /**
     * 填充数据并校验
     * @param phpDataMapper_Entity $entity 
     */
    private function fillData(phpDataMapper_Entity &$entity) {
        foreach ($this->_model->helper()->fields() as $key => $value) {
            $entity->$key = trim(param($key));
        }
        $error = $this->_model->helper()->validate($entity);
        if (!empty($error)) {
            $result = array('status' => 'fail', 'error' => $error);
            echo response()->json($result);
            exit;
        }
    }

}
