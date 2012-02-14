<?php

return array(
    'main' => array('title' => '主菜单', 'path' => '', 'children' => array(
            'index' => array('title' => '首页', 'path' => '/'),
            'news' => array('title' => '新闻', 'path' => 'news', 'children' => array(
                    'gnxw' => array('title' => '国内新闻', 'path' => '/news/gnxw', 'children'=>array(
                        'test1'=>array('title'=>'test1'),
                        'test2'=>array('title'=>'test2'),
                    )),
                    'gjxw' => array('title' => '国际新闻', 'path' => '/news/gjxw'),
            )),
    )),
);
