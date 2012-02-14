<?php

/**
 * 菜单区块
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_block {
    
    public function block($methodName){
        $buf = "<div class='block {$methodName}'>";
        if(method_exists($this, $methodName)){
            $buf .= $this->$methodName();
        }
        $buf .= "</div>".PHP_EOL;
        return $buf;
    }
    
    /**
     * 主菜单 
     */
    public function main(){
        return menu('main')->html(2);
    }
    
    /**
     * 二级菜单 
     */
    public function second(){
        
    }
    
    /**
     * 树状菜单 
     */
    public function tree(){
        
    }
}

?>
