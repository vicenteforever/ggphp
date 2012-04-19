<?php

/**
 * 内核测试文档
 * @package core 
 * @author goodzsq@gmail.com
 */
class core_test {

    /**
     * test1
     */
    function test_1() {
        test()->assertEqual(1, 1);
    }

    /**
     * test2
     */
    function test_2() {
        test()->assertEqual(2, 2);
    }

    /**
     * test3
     */
    function test_3() {
        test()->assertEqual('0', false, '0 = false');
    }

}

?>
