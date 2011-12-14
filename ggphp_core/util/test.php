<?php

class util_test extends PHPUnit_Framework_TestCase {
    
    function test1(){
        $this->assertEquals(util_file::file_ext('123.jpg'), 'jpg');
    }
    
    function test2(){
        $this->assertEquals(util_file::parent_dir('c:/test/abc'), 'c:/test');
    }
    
}

?>
