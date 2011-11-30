<?php

class model_dir{

	function load($root, $filter){
		$root = gbk($root);
		$result = array();
		if(is_dir($root)){
			$list = scandir($root);
			foreach($list as $row){
				$ext = util_filename::file_ext($row);
				$title = utf8($row);
				$file = utf8($root.DS.$row);
				if(is_dir(gbk($file)) && $row!='.' && $row!='..'){
					$children = self::load($file, $filter);
					$result[] = array('title'=>$title,'file'=>$file, 'children'=>$children);
				}
				else{
					if(in_array($ext, $filter))
						$result[] = array('title'=>$title, 'file'=>$file,'leaf'=>true);
				}
			}
		}
		return $result;
	}
}