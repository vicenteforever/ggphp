<?php

class Controller_Default{
	
	function doIndex(){
		$url = make_url('', 'test', 'sdfd/wer');
		echo "<a href='helloworld.htm'>test</a>";
	}

	function doTest(){
		echo param(0).'<br>';
		echo param(1);
	}

	function finally($data){
		echo view('html', $data);
	}

}