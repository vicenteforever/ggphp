<?php

/**
 * 上传文件模型
 * @package upload
 * @author goodzsq@gmail.com
 */
class file_model {
    
    /**
     * 已保存文件标志 
     */
    const FLAG_SAVE_OK = 'saved';
    /**
     * 临时文件标志 
     */
    const FLAG_SAVE_TEMP = 'temp';

    private $_model;

    /**
     * 获取文件存储模型
     * @return type 
     */
    static public function getModel(){
        return orm('file');
    }

    /**
     * 获取文件列表
     * @param string $token
     * @return phpDataMapper_Query 
     */
    static public function getList($token) {
        return self::getModel()->all(array('owner=' . $token));
    }
    
    /**
     * 获取单个文件信息
     * @param string $id
     * @return phpDataMapper_Entity 
     */
    static public function get($id){
        return self::getModel()->get($id);
    }

    /**
     * 添加文件到数据模型
     * @param string $token
     * @param phpDataMapper_Entity $entity 
     */
    static public function add($token, $entity) {
        $entity['owner'] = $token;
        $entity['saved'] = self::FLAG_SAVE_TEMP;
        self::getModel()->save($entity);
    }

    /**
     * 将临时文件变成已保存状态
     * @param string $token
     * @return boolean 
     */
    static public function save($token) {
        $sql = "UPDATE file SET saved =:saved WHERE owner=:token";
        return self::getModel()->execute($sql, array(':saved'=>self::FLAG_SAVE_OK, ':token'=>$token));
    }

}

