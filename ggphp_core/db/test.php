<?php

/**
 * 获取数据库适配器
 * @staticvar array $db
 * @return db_manager
 */
function manager($adapter) {
    static $manager = null;
    if (!isset($manager[$adapter])) {
        $manager[$adapter] = new db_manager($adapter);
    }
    return $manager[$adapter];
}

/**
 * 数据库单元测试
 * @package db
 * @author goodzsq@gmail.com
 */
class db_test {

    function test_mysql() {
        //创建表
        $struct = array(
            array('name' => 'id', 'field' => 'serial'),
            array('name' => 'title', 'field' => 'string'),
        );
        $fieldset = new field_collection($struct);
        manager('mysql')->get('default')->put('test1', $fieldset->fields());
        //修改表结构
        $struct = array(
            array('name' => 'id', 'field' => 'serial'),
            array('name' => 'title', 'field' => 'string'),
            array('name' => 'content', 'field' => 'text'),
        );
        $fieldset = new field_collection($struct);
        manager('mysql')->get('default')->put('test1', $fieldset->fields());

        //增加数据
        $table = manager('mysql')->get('default')->get('test1');
        for ($i = 0; $i < 10; $i++) {
            $table->post('', array(
                'title' => 'title' . $i,
                'content' => 'content' . $i,
            ));
        }
        //修改数据
        $table->put(1, array(
            'title' => 'title00000',
            'content' => 'content00000',
        ));
        $table->put(array('id' => 2), array(
            'title' => 'title00000',
            'content' => 'content00000',
        ));

        //删除数据
        $table->delete(3);
        
        echo trace($table->index());
        
        //删除所有数据
        $table->deleteAll();
        
        echo trace($table->index());
        
        //删除所有表
        manager('mysql')->get('default')->delete('test1');
    }

}
