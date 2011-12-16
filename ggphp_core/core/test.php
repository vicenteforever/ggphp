<?php

/**
 * core_test
 * @package core
 * @author Administrator
 */
class core_test {

	function test_1() {
		test()->assertEqual(1, 2, '1 = 2 test');
	}

	function test_2() {
		test()->assertEqual(2, 2, '2 = 2 test');
	}

}

?>
