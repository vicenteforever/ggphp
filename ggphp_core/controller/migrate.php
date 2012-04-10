<?php

/**
 * 数据库管理
 *
 * @author goodzsq@gmail.com
 */
class controller_migrate {
    
    public function do_index(){
        $buf = util_html::a('admin/migrate', '创建数据库');
        $buf .= util_html::a('admin/migrate', '重建表');
        return $buf;
    }
    
    public function do_test(){
        return print_r($_REQUEST, true);
    }
    
    /**
     * 创建数据库 
     */
    public function do_table(){
        $table = param(1);
        try {
            $model = orm($table);
            util_csrf::validate();
            $model->migrate();
            $model->debug();
            $result = $model->fieldset()->table() . '表已重建';
        } catch (Exception $e) {
            $result = $model->debug();
            $result .= $e->getMessage();
        }
        return $result;
    }
}
