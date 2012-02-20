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
        $a = new menu_item('a', 'A');
        $a1 = new menu_item('a1', 'A1');
        $a2 = new menu_item('a2', 'A2');
        $a21 = new menu_item('a21', 'A21');
        
        $a->setChildren($key, $object)
    }

    /**
     * 新闻
     */
    function do_news() {
        $sql = 'select * from ecs_admin_log limit 0, 5';
        $list = mydb()->sqlQueryCache($sql);
        foreach($list as $row){
            print_r($row);
        }
    }

    //private function //
}

?>
