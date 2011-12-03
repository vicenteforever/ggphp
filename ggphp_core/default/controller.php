<?php

class default_controller {

	function doIndex(){
		return html('default 默认控制器行为');
	}

	function doDoc(){
		return html(view('document'));
	}
}