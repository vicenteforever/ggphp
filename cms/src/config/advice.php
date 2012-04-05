<?php

return array(
    'article_controller' => array(
        'do_index' => array('roles'=>array('anonymous', 'admin'), 'layout'=>'index'),
        'do_test' => array('layout'=>'index'),
    ),
);