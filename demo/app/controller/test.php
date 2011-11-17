<?php

class controller_test {

	function doQq(){
		echo path();
		print_r(args());
		$a[] = '我是谁是我 谁是我是谁';
		$a[] = array('aaa','bbb','ccc');

		$adapter = 'file';
		storage($adapter, 'default')->save('test', $a);
		print_r( storage($adapter, 'default')->load('test'));

	}
}