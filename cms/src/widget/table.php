<?php

/**
 * 数据表格
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_table extends widget_base {

    function style_default() {
        $style = <<<EOF
table.table {border-collapse:collapse;border:1px solid #ccc}
table .odd{background:#eee;}
table .even{background:#fff;}
table .first{background:#aaa;}
table .last{}
table .hover{background:yellow;}
EOF;
        response()->addCssInline($style);
        jquery()->table('#'.$this->_id);
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
