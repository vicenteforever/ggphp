<?php
/**
 * core_test
 * @package core
 * @author Administrator
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
    function test_3(){
        test()->assertEqual('0', false, '0 = false');
    }

}

?>
