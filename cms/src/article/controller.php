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


        jquery()->ready('window.a = $(document);');
        jquery()->ready('alert(122345)');
        response()->addCssFile('style.css');
        $a = new menu_item('a', 'A');
        $a1 = new menu_item('b', 'B');
        $a2 = new menu_item('c', 'C');
        $a21 = new menu_item('d', 'D');

        $a->addChildren($a1);
        $a1->addChildren($a2);
        $a2->addChildren($a21);

        //$a->changeParent($a21);
        return html($a->renderHtml());
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

    function admin_news() {
        return '新闻管理';
    }

    function do_test() {
        echo 'hello world';
    }

    //private function //
}

?>
