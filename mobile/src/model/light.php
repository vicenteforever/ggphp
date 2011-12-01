<?php

class model_light{

	function load(){
		$lights = config('light');
		return $lights;
	}


}