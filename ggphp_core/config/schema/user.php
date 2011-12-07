<?php
return array(
	'_datasource' => 'user',
	'id' => array('type'=>'int', 'primary'=>true, 'serial'=>true),
	'email' => array('type'=>'email', 'required'=>true),
	'title' => array('type'=>'string', 'required'=>true),
	'body' => array('type' => 'text', 'required' => true),
	'status' => array('type' => 'string', 'default' => 'draft'),
	'date_created' => array('type' => 'datetime'),
);
