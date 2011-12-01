<?php

class module_default_controller {

	function doIndex(){
		return $_REQUEST;
	}

	function doTest(){
		return GG_Response::html('title', self::doIndex());
	}
}