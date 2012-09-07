<?php

/**
 * 对字段设置或读取值时候被调用的接口
 * @author goodzsq@gmail.com
 */
interface field_encoder_interface {
    
    /** 保存时调用 */
    public function encode($value);
    
    /** 读取时调用 */
    public function decode($value);
    
}
