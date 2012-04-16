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
        $entity = orm('article')->load(14);
        $entity->summary[] = 123;
        return $entity->save();
    }
    
    function do_test2(){
        $model = orm('article');
        
        for($i=0;$i<10; $i++){
            $entity = $model->get($i);
            $entity->id=$i;
            $entity->title = $i.'hello';
            //$model->save($entity);
        }
        return 'ok';
    }

}

