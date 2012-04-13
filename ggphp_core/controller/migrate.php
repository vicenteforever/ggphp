<?php

/**
 * 数据库管理
 *
 * @author goodzsq@gmail.com
 */
class controller_migrate {

    public function do_index() {
        $table = param('table');
        $buf = '';
        if(!empty($table)){
            $this->migrateTable($table);
            $buf .= "$table created!<br>";
        }
        $buf .= util_html::a('admin/migrate', '创建数据库');
        $buf .= util_html::a('admin/migrate', '重建表');
        return $buf;
    }

    public function do_test() {
        return print_r($_REQUEST, true);
    }

    /**
     * 创建数据库 
     */
    private function migrateTable($table) {
        $model = orm($table);
        util_csrf::validate();
        $model->migrate();
        return $table . '表已重建';
    }

}
