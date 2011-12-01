<?php

class module_default_controller{

	function doIndex(){
		GG_Response::redirect(base_url().'main.html');
	}

}