<?php

return array(
	array('name'=>'id', 'label'=> 'ID', 'field'=>'serial'),
	array('name'=>'name', 'label'=> '用户名称', 'field'=>'string', 'required'=>true, 'length'=>20, 'unique'=>true),
	array('name'=>'password', 'label'=> '用户密码', 'field'=>'password', 'required'=>true),
);
