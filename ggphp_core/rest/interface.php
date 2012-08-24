<?php

/**
 * 资源描述接口
 * @author goodzsq@gmail.com
 */
interface rest_interface {
    
    /* 获取资源 */
    public function get($id);
    
    /* 创建资源 */
    public function post($id, $data);
    
    /* 修改资源 */
    public function put($id, $data);
    
    /* 删除资源 */
    public function delete($id);
    
    /* 获取资源列表数组 */
    public function index($params);
    
    /* 删除所有资源 */
    public function deleteAll();
    
    /* 资源数据结构描述数组 */
    public function struct();
    
}
