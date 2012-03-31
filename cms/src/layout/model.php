<?php

/**
 * 布局数据模型
 * @package layout
 * @author goodzsq@gmail.com
 */
class layout_model extends util_tree {
    
    public $name;
    public $span = 24;
    public $append = 0;
    public $prepend = 0;
    public $pull = 0;
    public $push = 0;
    public $last = false;
    public $colborder = false;
    public $border = false;
    public $class = '';
    public $content = '';//内容
    
    
    public function __construct($id, $name, array $data) {
        parent::__construct($id);
        $this->name = $name;
        foreach($data as $k=>$v){
            $this->$k = $v;
        }
    }
}

