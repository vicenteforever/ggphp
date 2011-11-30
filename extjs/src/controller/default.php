<?php

class Controller_Default{

	function doIndex(){
		GG_Response::redirect(base_url().'index.html');
	}

}