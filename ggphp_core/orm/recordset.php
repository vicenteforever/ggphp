<?php

/**
 * 记录集
 * @package query
 * @author goodzsq@gmail.com
 */
class orm_recordset {

    /** @var orm_model */
    private $_model;

    /** @var PDOStatement */
    private $_stmt;

    /**
     * construct
     * @param orm_model $model
     * @param PDOStatement $stmt 
     */
    public function __construct(orm_model $model, PDOStatement $stmt) {
        $this->_model = $model;
        $this->_stmt = $stmt;
    }

    /**
     * PDOStatement->fetch()
     * @return array 
     */
    public function fetch() {
        return $this->_stmt->fetch();
    }

    /**
     * PDOStatement->fetchAll()
     * @return array 
     */
    public function fetchAll() {
        return $this->_stmt->fetchAll();
    }

    /**
     * 记录集数
     * @return int 
     */
    public function count() {
        return $this->_stmt->rowCount();
    }

    /**
     * 从记录集中取出实体对象
     * @return orm_entity 
     */
    public function fetchEntity() {
        /* pdo->fetch bug: 构造函数执行顺序错误
        $entityClassName = $this->_model->getEntityClassName();
        if ($row = $this->_stmt->fetchObject(PDO::FETCH_CLASS, $entityClassName, array($this->_model))) {
            $row->loaded(true);
            return $row;
        }
         * 
         */
        //临时解决方案
        if ($data = $this->_stmt->fetch(PDO::FETCH_ASSOC)) {
            $entity = new orm_entity($this->_model);
            $entity->loaded(true);
            foreach($data as $key => $value){
                $entity->$key = $value;
            }
            return $entity;
        }
        return null;
    }

}