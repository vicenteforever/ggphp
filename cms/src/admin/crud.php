<?php

/**
 * CRUD创建查询修改删除
 * @package admin
 * @author goodzsq@gmail.com
 */
abstract class admin_crud {

    protected $_modelName;
    protected $_model;
    protected $_displayCount = 20;
    protected $_formStyle = '';

    public function __construct() {
        $this->_model = orm($this->_modelName);
    }

    /**
     * 编辑
     */
    function do_edit() {
        $helper = $this->_model->helper();
        $helper->url = make_url('admin', $this->_modelName, 'save');
        $helper->uploadurl = make_url('admin', $this->_modelName, 'upload');
        $helper->entity = $this->_model->get(param('id'));
        $buf = widget('form', $this->_modelName, $helper)->render($this->_formStyle);
        return $buf;
    }

    /**
     * 保存 
     */
    function do_save() {
        app()->setPageType('json');
        $id = param('id');

        try {
            $entity = $this->_model->get(param('id'));
            $this->fillData($entity);
            $this->_model->save($entity);
            foreach ($this->_model->helper()->fields() as $key => $field) {
                if($field instanceof field_file){
                    file_model::save($field->value);
                }
            }
            return array('status' => 'ok', 'redirect' => make_url('admin', $this->_modelName, 'index'));
        } catch (Exception $e) {
            return array('status' => 'fail', 'message' => $e.getMessage());
        }
    }

    /**
     * 文件下载 
     */
    function do_download() {
        //@todo goodzsq file download
        $id = param('id');
        response()->download($filename, $content);
    }

    /**
     * 删除 
     */
    function do_delete() {
        //@todo goodzsq record delete
        $id = param('id');
        $this->_model->delete(array('id' => $id));
        redirect(make_url('admin', $this->_modelName, 'index'));
    }

    /**
     * 查询列表以及分页
     */
    function do_index() {
        $header = array();
        foreach ($this->_model->helper()->fields() as $key => $value) {
            $header[$key] = $value->label;
        }
        $header['admin'] = '管理';
        $data = array($header);
        $buf = '';
        $url = make_url('admin', $this->_modelName, 'edit');
        $buf .= util_html::a($url, '添加');

        $query = $this->_model->all();
        $pager = new orm_pager($query, param('page'), $this->_displayCount);
        foreach ($query as $row) {
            $param = array('id' => $row->id);
            $url = make_url('admin', $this->_modelName, 'edit', $param);
            $edit = util_html::a($url, '编辑');
            $url = make_url('admin', $this->_modelName, 'delete', $param);
            $delete = util_html::a($url, '删除');
            $rowData = $row->toArray();
            $rowData['admin'] = "$edit $delete";
            $data[] = $rowData;
        }
        $buf .= widget('table', $this->_modelName, $data)->render();
        $buf .= $pager->render(make_url('admin', $this->_modelName, 'index') . '?');
        $this->_model->debug();
        return $buf;
    }

    /**
     * 发现错误则结束程序并返回json错误消息，无错误则继续
     * @param string $key 发生错误的字段
     * @param mixed $data 发生错误的消息
     */
    protected function errorCheck($key, $value) {
        //把单条错误消息处理成数组
        $data = array();
        if (is_array($value)) {
            $data = $value;
        } else if (!empty($value)) {
            $data[$key] = $value;
        }

        if (!empty($data)) {
            $result = array('status' => 'fail', 'error' => $data);
            echo response()->json($result);
            exit; //终止程序
        }
    }

    /**
     * 填充数据并校验
     * @param phpDataMapper_Entity $entity 
     */
    protected function fillData(phpDataMapper_Entity &$entity) {
        //检查是否为csrf攻击
        $this->errorCheck(util_csrf::key(), util_csrf::validate());
        //填充数据到entity
        foreach ($this->_model->helper()->fields() as $key => $field) {
            $field->setValue(param($key));
            $entity->$key = $field->getValue();
        }
        //检查数据校验是否正确
        $this->errorCheck('', $this->_model->helper()->validate());
        //检查验证码
        if ($this->_formStyle == 'captcha') {
            $this->errorCheck('captcha', image_captcha::validate());
        }
    }

}
