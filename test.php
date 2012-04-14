<?php

class test implements ArrayAccess {

    public $val = "";

    public function set($param) {
        return $this->val = $param;
    }

    public function tt() {
        return "[$this->val]";
    }

    public function offsetExists($offset) {
        return true;
    }

    public function offsetGet($offset) {
        return $this->set($offset);
    }

    public function offsetSet($offset, $value) {
        
    }

    public function offsetUnset($offset) {
        
    }

}

$a = new test();

for ($i = 0; $i < 10; $i++) {
    print_r($a[$i]);
}