<?php

/**
 * 数据表格
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_table extends widget_base {

    function style_default() {
        if (is_array($this->_data)) {
            $buf = "<table class=widget_table>";
            foreach ($this->_data as $row) {
                $buf .= "<tr>";
                foreach ($row as $column) {
                    $buf .= "<td>$column</td>";
                }
                $buf .= '</tr>';
            }
            $buf .="</table>";
        } else {
            $buf = $this->_data;
        }
        return $buf;
    }
    
    function style_list(){
        
    }

}
