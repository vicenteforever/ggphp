<?php

/**
 * 文章
 * @package article
 * @author goodzsq@gmail.com
 */
class article_controller {

    /**
     * 主页
     * @return string 
     */
    function do_index() {
        $buf = block('menu', 'main');
        $buf .= block('menu', 'tree');
        return $buf;
    }

    /**
     * 新闻
     */
    function do_news() {
        $sql = 'select * from ecs_admin_log limit 0, 5';
        $list = mydb()->sqlQueryCache($sql);
        foreach ($list as $row) {
            print_r($row);
        }
    }

    /**
     * 测试
     */
    function do_test() {
        $a = new orm_adapter_mysql();
        app()->log('======');
        app()->log($a->updateTable(orm('article')->fieldset()));
        app()->log('-----');
    }

}

