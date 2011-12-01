<?php

class module_test_sub_controller{

	function doIndex(){
		return GG_Response::html('test','module test sub');
	}

}