<?php
return array(
	array('name'=>'id', 'label'=> 'ID', 'field'=>'int', 'primary'=>true, 'serial'=>true),
	array('name'=>'name', 'label'=> '用户名称', 'field'=>'string', 'required'=>true, 'length'=>20),
	array('name'=>'password', 'label'=> '用户密码', 'field'=>'password'),
);
