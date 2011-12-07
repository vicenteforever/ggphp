<?php

class storage_controller{

	function doIndex(){
		return html('content 内容管理模块');
	}

	function doTest(){
		$user = new storage_object('user');

		$user->create();
		$user->load();
		$user->name = 'sdsf';
		$user->id = 'sdf';
	}
}