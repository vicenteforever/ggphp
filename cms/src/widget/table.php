<?php

/**
 * 数据表格
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_table extends widget_base {
    
    public function __construct($id, $data) {
        parent::__construct($id, $data);
        $this->_id = "table_$id";
    }
    
    function theme_test(){
        return 'hello world';
    }
    
    function theme_default() {
        $selector = "#{$this->_id}";
        $style = <<<EOF
$selector {border-collapse:collapse;border:1px solid #ccc;}
$selector td {padding:5px}
$selector .odd{background:#eee;}
$selector .even{background:#fff;}
$selector .first{background:#aaa;}
$selector .last{}
$selector .hover{background:yellow;}
EOF;
        response()->addCssInline($style);
        jquery()->table($selector);
        return $this->html();
    }

    private function html() {
        if (is_array($this->_data)) {
            $buf = "<table id='{$this->_id}'>\n";
            foreach ($this->_data as $row) {
                $buf .= "<tr>";
                foreach ($row as $column) {
                    $buf .= "<td>$column</td>";
                }
                $buf .= "</tr>\n";
            }
            $buf .="</table>\n";
        } else {
            $buf = $this->_data;
        }
        return $buf;
    }

}
