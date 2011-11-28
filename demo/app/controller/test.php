<?php

class controller_test {

	function doQq(){
		util_banchmark::start('aaa');
		echo path();
		print_r('sdf');
		util_banchmark::start('bbb');
		$a[] = 'abdsdf wer sdf';
		$a[] = array('aaa','bbb','ccc');
		util_banchmark::end('bbb');
		$adapter = 'file';
		storage($adapter, 'default')->save('test', $a);
		print_r( storage($adapter, 'default')->load('test'));
		util_banchmark::end('aaa');
		print_r( util_banchmark::result());
	}
}