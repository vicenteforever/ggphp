<?php

class default_controller{

	function doIndex(){
		core_response::redirect(base_url().'index.html');
	}

}