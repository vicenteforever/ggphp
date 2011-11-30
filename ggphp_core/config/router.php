<?php
//程序中第n子表达式的值用param(n)获取, 当不设置action时候,action自动设为正则表达式第一子表达式的值 第n子表达式程序中用param(n-1)获取
return array(
	"/^test\/qq$/i" => array('controller'=>'test', 'action'=>'qq'),
	"/^test\/(\w+)\/(\d+)$/i" => array('controller'=>'test'),
);