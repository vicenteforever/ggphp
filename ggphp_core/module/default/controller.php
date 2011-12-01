<?php

class module_default_controller {

	function doIndex(){
		return GG_Response::redirect('doc');
	}

	function doDoc(){
		return GG_Response::html('ggphp', view('document'));
	}
}