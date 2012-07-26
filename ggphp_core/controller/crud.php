<?php

/**
 * CRUD创建查询修改删除控制器
 * @package controller
 * @author goodzsq@gmail.com
 */
abstract class controller_crud {

    abstract public function modelName();

    protected $_displayCount = 20;
    protected $_formStyle = '';

    public function __construct() {
        $this->_model = orm($this->modelName());
    }

    /**
     * 编辑
     */
    function do_edit() {
        $fieldset = $this->_model->fieldset();
        $fieldset->url = make_url('admin', $this->modelName(), 'save');
        $fieldset->uploadurl = make_url('admin', $this->modelName(), 'upload');
        $entity = $this->_model->load(param('id'));
        $buf = widget('form', $this->modelName(), $entity)->render($this->_formStyle);
        return $buf;
    }

    /**
     * 保存 
     */
    function do_save() {
        $id = param('id');
        $entity = $this->_model->load(param('id'));
        foreach($_REQUEST as $key=>$value){
            $entity->$key = param($key);
        }   
        //检查是否为csrf攻击
        $this->errorCheck(util_csrf::key(), util_csrf::validate());
        //检查数据校验是否正确
        $this->errorCheck('', $entity->validate());
        //检查验证码
        if ($this->_formStyle == 'captcha') {
            $this->errorCheck('captcha', image_captcha::validate());
        }
        //保存
        if ($entity->save()) {
            return array('status' => 'ok', 'redirect' => make_url('admin', $this->modelName(), 'index'));
        } else {
            return array('status' => 'fail', 'message' => '保存数据失败', 'data'=>app()->log());
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
        redirect(make_url('admin', $this->modelName(), 'index'));
    }

    /**
     * 查询列表以及分页
     */
    function do_index() {
        $header = array();
        foreach ($this->_model->fieldset()->fields() as $key => $value) {
            $header[$key] = $value->label;
        }
        $header['admin'] = '管理';
        $data = array($header);
        $buf = '';
        $url = make_url('admin', $this->modelName(), 'edit');
        $buf .= util_html::a($url, '添加');

        $stmt = $this->_model->query();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $buf .= widget('table', $this->modelName(), $data)->render();
        return $buf;
        /*
          $query = $this->_model->all();
          $pager = new orm_pager($query, param('page'), $this->_displayCount);
          $recordset = $this->_model->query();
          foreach ($query as $row) {
          $param = array('id' => $row->id);
          $url = make_url('admin', $this->modelName(), 'edit', $param);
          $edit = util_html::a($url, '编辑');
          $url = make_url('admin', $this->modelName(), 'delete', $param);
          $delete = util_html::a($url, '删除');
          $rowData = $row->toArray();
          $rowData['admin'] = "$edit $delete";
          $data[] = $rowData;
          }
          $buf .= widget('table', $this->modelName(), $data)->render();
          $buf .= $pager->render(make_url('admin', $this->modelName(), 'index') . '?');
          $this->_model->debug();
          return $buf;
         * 
         */
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

}
