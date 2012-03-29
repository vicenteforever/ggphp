<?php

//所有控制器方法
$advice['/_controller::do_/'] = array(
    'allow' => array('core::log'),
    'forbidden' => array(),
);

//所有后台管理方法
$advice['/_admin::do_/'] = array(
    'allow' => array('core::log'),
    'forbidden' => array(),
);

//sql执行语句拦截
$advice['/database_mysql_db::sql/'] = array(
    'allow' => array('database::sqltrace'),
    'forbidden' => array(),
);

return $advice;