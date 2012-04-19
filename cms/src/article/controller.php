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
        $comment = orm('comment')->load(1);

        $comment->owner->table = 'article';
        $comment->owner->field = 'comment';
        $comment->title = 'tetee';
        $comment->content = 'sdf';
        $comment->save();
    }

}

