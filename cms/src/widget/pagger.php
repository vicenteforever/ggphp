<?php

/**
 * 分页器
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_pagger extends widget_base {

    public function style_default() {
        $pagenext = '下一页';
        $pagelast = '最后一页';
        $pagefirst = '第一页';
        $pageprevious = '上一页';
        return "$pagefirst $pageprevious $pagenext $pagenext {$this->_data}";
    }

}

