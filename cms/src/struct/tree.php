<?php

/**
 * tree
 * @package
 * @author goodzsq@gmail.com
 */
class struct_tree {

    private $_parent;
    private $_children;
    private $_item;

    /**
     * 构造树形结构
     * @param struct_tree $parent
     * @param array $item
     * @param string $childrenName 
     */
    public function __construct($parent, $item, $childrenName = 'children') {
        $this->_parent = $parent;

        if (isset($item[$childrenName])) {
            $children = $item[$childrenName];
            //unset($item[$childrenName]);
        } else {
            $children = array();
        }
        $this->_item = $item;

        if (is_array($children)) {
            foreach ($children as $key => $value) {
                $this->_children[$key] = new struct_tree($this, $value);
            }
        } else {
            $this->_children = null;
        }
    }

    public function __get($name) {
        return $this->item($name);
    }

    public function parent() {
        return $this->_parent;
    }

    /**
     * get children
     * @param string $key
     * @return struct_tree
     */
    public function children($key = null) {
        if (isset($key)) {
            if (isset($this->_children[$key])) {
                return $this->_children[$key];
            } else {
                return null;
            }
        } else {
            return $this->_children;
        }
    }

    /**
     * 判断是否存在子节点
     * @return boolean 
     */
    public function isLeaf() {
        if (is_array($this->_children)) {
            if (empty($this->_children)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function item($name = null) {
        if (isset($name)) {
            if (isset($this->_item[$name])) {
                return $this->_item[$name];
            } else {
                return null;
            }
        } else {
            return $this->_item;
        }
    }

    public function find($key, $value) {
        if ($this->$key == $value) {
            return $this;
        }

        if ($this->isLeaf()) {
            return null;
        } else {
            foreach ($this->_children as $object) {
                $result = $object->find($key, $value);
                if (!empty($result)) {
                    return $result;
                }
            }
            return null;
        }
    }
    
    public function path(){
        $result = $this->title;
        $parent = $this->_parent;
        while(!empty($parent)){
            $result = $parent->title . '->' . $result;
            $parent = $parent->_parent;
        }
        return $result;
    }

}
