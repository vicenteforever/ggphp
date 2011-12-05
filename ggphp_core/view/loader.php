<?php

class view_loader{

	/**
	 * ¼ÓÔØÊÓÍ¼
	 * @param string $viewName
	 * @param array $data
	 * @return string
	 */
	function load($view=null, $data=null){
		if(empty($view)){
			$view = app()->getAction();
		}

		if(!preg_match("/^[_0-9a-zA-Z]+$/", $view))
			throw new Exception('invalid view'.$view);

		ob_start();
		$modulePath = app()->getModulePath(app()->getController());
		$path = $modulePath.DS.'template'.DS.$view.'.php';
		if (!file_exists($path)){
			$path = APP_DIR.DS.'src'.DS.'template'.DS.$view.".php";
			if (!file_exists($path)){
				$path = GG_DIR.DS.'view'.DS.'template'.DS.$view.".php";
			}
			if (!file_exists($path)){
				app()->log('view not exists:'.$view);
				ob_clean();
				return '';
			}
		}
		app()->log('load view:'.$path);
		include($path);
		return ob_get_clean();
	}

}