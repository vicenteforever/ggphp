<?php

class nosql_test {

    /**
     * 测试文件存储
     */
    function test_qq() {
        $test = nosql('file', 'test');
        $test->a = 'aaa';
        $test->b = 'bbb';
        $test->save();

        $test2 = nosql('file', 'test2');
        //转存为test2
        $test->saveAs($test2);
 
        $test3 = new nosql_file('test');
        $test4 = new nosql_file('test2');
        test()->assertEqual($test3->a,  'aaa');
        test()->assertEqual($test3->b,  'bbb');
        test()->assertEqual($test3->data(),  $test4->data(), '读出的文件内容一致');
        $test3->delete();
        $test4->delete();
        test()->assertEqual(file_exists($test3->filename()), false, '删除测试');
        test()->assertEqual(file_exists($test4->filename()), false, '删除测试');
    }
    
    /**
     * 测试session存储
     */
    function test_session(){

    }

    /**
     * 测试cookie存储
     */
    function test_cookie(){
        
    }
    
    /**
     * 测试数据库存储
     */
    function test_database(){
        $obj1 = nosql('database', 'test1');
        $obj2 = nosql('database', 'test2');
        $obj1->a = 'aaa';
        $obj1->b = 'bbb';
        $obj1->save();
        $obj1->saveAs($obj2);

        $obj3 = new nosql_database('test2');
        test()->assertEqual($obj3->a, 'aaa');
        test()->assertEqual($obj3->b, 'bbb');

        $obj2->delete();
        $obj2->load();
        $data2 = $obj2->data();
        test()->assertEqual(empty($data2), true);
    }

    /**
     * 测试memcache存储
     */
    function test_memcache(){
        //pass memcache test
        return;
        $obj = nosql('memcache', 'test1');
        $obj->a = 'aaa';
        $obj->b = 'bbb';
        $obj->save();
        
        $obj2 = new nosql_memcache('test1');
        test()->assertEqual($obj2->a, 'aaa');
        test()->assertEqual($obj2->b, 'bbb');
    }

    /**
     * 测试monogb存储
     */
    function test_monogb(){
        
    }
}