<?php
return array(
	'app_name' => 'ggphp',			//应用程序名称
	'only_use_router' => false,		//只允许使用路由方式config/router.php(以一种非常安全的白名单式验证url输入)
	'debug' => true,			//调试模式下允许报告E_NOTICE提示，显示程序运行状态报告，允许运行单元测试
	'app_title' => 'GGPHP',			//应用程序名称
	'default_controller' => 'default',	//默认控制器
	'default_action' => 'index',		//默认控制器方法名称
	'action_prefix' => 'do',		//控制器方法的前缀(加前缀是为了使用纯数字作为控制器方法名称)
	'log_storage' => 'file',		//日志存储方式
	'input_filters' => array('xss'),	//用户输入过滤器，过滤掉非法输入字符
	'hook_app_start' => array(''),
	'hook_controller_start' => array('rbac'),
	'hook_controller_end' => array('report'),
);