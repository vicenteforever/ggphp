<?php

class module_default_controller {

	function doIndex(){
		return 'default_controller';
	}

	function doDoc(){
		return GG_Response::html('ggphp', view('document'));
	}
}