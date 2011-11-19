<?php
class controller_ajax{

	function doMovie(){
		$aaa = rand(1,10);
		for($i=0;$i<$aaa;$i++){
		$a[] = array('title'=>$i, 'url'=>'谁是我是谁');
		}
		echo GG_Response::json($a);
	}
}