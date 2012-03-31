<?php

/**
 * 树形结构
 * @package struct
 * @author goodzsq@gmail.com
 */
class util_tree {

    private $_parent = null;
    private $_children = array();
    private $_id;

    /**
     * 构造函数设置该节点id值
     * @param string $id
     */
    public function __construct($id) {
        $this->_id = $id;
    }

    /**
     * 获取节点id
     * @return string 
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * 获取父元素
     * @return self 
     */
    public function parent(){
        return $this->_parent;
    }
    
    /**
     * 添加子对象
     * @param string $key
     * @param self $object 
     */
    public function addChildren(self $object) {
        $key = $object->getId();
        $object->_parent = $this;
        $this->_children[$key] = $object;
    }

    /**
     * 移除子对象
     * @param self $object 
     */
    public function removeChildren(self $object) {
        $key = $object->getId();
        unset($this->_children[$key]);
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

    public function getChildren() {
        return $this->_children;
    }

    public function hasChildren() {
        if (!empty($this->_children)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function changeParent(self $newParent){
        $oldParent = $this->_parent;
        if(isset($oldParent)){
            $oldParent->removeChildren($this);
            $newParent->addChildren($this);
        }
        else{
            throw new Exception('tree root node cant change parent');
        }
    }

    public function __get($name) {
        return 'novalue';
    }
    
}
