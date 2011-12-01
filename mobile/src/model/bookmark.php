<?php

class model_bookmark{

	function load(){
		return storage('file', 'bookmark')->load('bookmark');
	}

	function save($value){
		$storage = storage('file', 'bookmark');
		$storage->save('bookmark', $value);
	}

}