<?php

class model_movieinfo{

	function load($id){
		if(!preg_match("/^A\d\d\d\d\d$/", $id))
			return array();
		$rs = pdo()->query("select * from video where id='$id'");
		if($row = $rs->fetch())
			return $row;
		else
			return array();
	}

}