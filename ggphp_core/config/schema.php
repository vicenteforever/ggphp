<?php
$schema['user'] = array(
	'email' => array(
		'index' => 'PRIMARY', //PRIMARY UNIQUE INDEX
		'label' => '电子邮件',
		'field' => 'email',
		'required' => true,
		'number' => 1,
	),
	'password' => array(
		'label' => '密码',
		'field' => 'password',
		'required' => true,
		'number' => 1,
		'required' => true,
	),
	'test' => array(
		'label' => 'test',
		'field' => 'datetime',
		'required' => true,
		'number' => 1,
		'required' => true,
	),

);

return $schema;