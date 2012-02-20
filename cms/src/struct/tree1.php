<?php

/**
 * 树形结构
 * @package struct
 * @author goodzsq@gmail.com
 */
class struct_tree1 implements RecursiveIterator{

    private $_parent;
    private $_children;
    private $_valid;
    private $_key;
    
    public function setKey($key){
        $this->_key = $key;
    }
      
    /**
     * 设置父亲对象
     * @param self $object 
     */
    public function setParent($object) {
        //$this->_parent = $object;
        if(isset($object->getParent())){
            $object->getParent()->
        }
    }

    /**
     * 获取父亲对象
     * @return self 
     */
    public function getParent() {
        return $this->_parent;
    }

    /**
     * 添加子对象
     * @param string $key
     * @param self $object 
     */
    public function setChildren($key, $object) {
        $this->_children[$key] = $object;
        $object->setParent($this);
    }

    /**
     * 通过名称获取子对象
     * @param type $key
     * @return null 
     */
    public function getChildrenByName($key) {
        if (isset($this->_children[$key])) {
            return $this->_children[$key];
        } else {
            return null;
        }
    }

    public function current() {
        return $this;
    }

    public function getChildren() {
        return $this->_children;
    }

    public function hasChildren() {
        if(!empty($this->_children)){
            return true;
        }else{
            return false;
        }
    }

    public function key() {
        return $this->_key;
    }

    public function next() {
        if(isset($this->_parent)){
            $this->_valid = next($this->_parent->getChildren());
        }
    }

    public function rewind() {
        if(isset($this->_parent)){
            $this->_valid = rewind($this->_parent->getChildren());
        }
    }

    public function valid() {
        return $this->_valid;
    }


}
