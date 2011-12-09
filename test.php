<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test{
	public $abc = 'sdf';
	
	function t(){
		echo 'hello world';
	}
	
	function __get($name) {
		return "[$name]";
	}
}

function factory($str){
	return new Test;
}

echo factory(123)->abcd;
?>
