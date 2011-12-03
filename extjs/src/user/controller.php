<?php

class user_controller {

	function doList(){
		$raw = file_get_contents('php://input');
		if(core_request::isPost()){
			echo json_encode(array('success'=>true));return;
		}
		$user[] = array('name'=> 'goodzsq', 'email'=>'goodzsq@gmail.com');
		$user[] = array('name'=> 'ssss', 'email'=>'xxxxx@gmail.com');
		$data = array('success'=>true, 'users'=>$user);
		echo json_encode($data);
	}

	function doSave(){
		$user[] = array('name'=> 'goodzsq', 'email'=>'goodzsq@gmail.com');
		$user[] = array('name'=> 'ssss', 'email'=>'xxxxx@gmail.com');
		$data = array('success'=>true, 'users'=>$user);
		echo json_encode($data);
	}
}