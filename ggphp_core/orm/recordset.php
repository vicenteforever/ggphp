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
    public function fetch(){
        return $this->_stmt->fetch();
    }
    
    /**
     * PDOStatement->fetchAll()
     * @return array 
     */
    public function fetchAll(){
        return $this->_stmt->fetchAll();
    }
    
    /**
     * 记录集数
     * @return int 
     */
    public function count(){
        return $this->_stmt->rowCount();
    }
    
    /**
     * 从记录集中取出实体对象
     * @return orm_entity 
     */
    public function fetchEntity() {
        $entityClassName = $this->_model->getEntityClassName();       
        if ($row = $this->_stmt->fetchObject($entityClassName, array($this->_model))) {
            $row->loaded(true);
            return $row;
        }
        return null;
    }

}