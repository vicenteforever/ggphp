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
        return html($buf);
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
     * 上传测试
     */
    function do_test() {
        //$vars = array('swf'=>'/keyboard.swf', 'flashvars'=>array('var1'=>'aa', 'var2'=>'bb'));
        //return html(widget('swfobject', 'test', '/keyboard.swf')->render());
        return html(widget('marquee', '', 'hello world')->render());
    }

    //private function //
}

