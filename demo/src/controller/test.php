<?php

class controller_test {

	function doQq(){
		return param('sdf');
	}

	function doTest(){
		return 'this is a test';
	}

	function do12345(){
		return 'action is number, param1='.param(0);
	}
}