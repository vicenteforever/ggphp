<?php

/**
 * orm自动化测试
 * @package
 * @author goodzsq@gmail.com
 */
class orm_test {
    
    function test_1(){
        $model = orm('test', 'test');
        test()->assertEqual($model->drop(), true, '删除表');
        test()->assertEqual($model->migrate(), true, '重建表');
        
        $node = $model->load();
        
    }
}

