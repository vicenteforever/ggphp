<?php

/**
 * 分布式memcache分组,当某组服务器一台发生故障，读取数据失败时候从另一组服务器组上读取并存储当前组
 * @package core
 * @author goodzsq@gmail.com
 */
class core_memcache {

    /**
     * Memcache group
     * @var Memcache
     */
    private $_driver;
    private $_groupCount=0;
    private $_groupNameList=array();
    private $_random; //随机选择服务器组
    private $_keys = array();

    /**
     * 从配置文件中构造分布式memcache且分组
     */
    function __construct() {
        $config = config('memcache');
        foreach ($config as $group => $hosts) {
            $this->initServerGroup($group, $hosts);
        }
        $this->_random = rand(0, $this->_groupCount-1);
        $this->_keys = @$this->currentGroup()->get('goodzsq');
    }

    private function initServerGroup($group, $hosts){
        $this->_driver[$group] = new Memcache();
        foreach($hosts as $server){
            $this->_driver[$group]->addServer($server['host'], $server['port']);
        }
        $this->_groupNameList[] = $group;
        $this->_groupCount++;
    }
    
    private function nextGroup(){
        $i = $this->_random + 1;
        if($i>=$this->_groupCount){
            $i=0;
        }
        $groupName = $this->_groupNameList[$i];
        return $this->_driver[$groupName];
    }
    
    public function currentGroup(){
        $groupName = $this->_groupNameList[$this->_random];
        return $this->_driver[$groupName];
    }
    
    
    function __get($name) {
        $value = @$this->currentGroup()->get($name);
        if ($value===false){
            if($this->_groupCount>1){
                //当前组故障时从下一组获取数据
                $value = @$this->nextGroup()->get($name);
                //将恢复的数据重新存储当前组
                @$this->currentGroup()->set($name, $value);
                return "[restore $value] ";
            }
            else{
                return null;
            }
        }
        else{
            //正常读取
            return "[normal $value] ";
        }
    }

    function __set($name, $value) {
        $this->_keys[$name] = 1;
        foreach($this->_driver as $group => $mem){
            @$mem->set($name, $value);
            @$mem->set('goodzsq', $this->_keys);
        }
    }
    
    function keys(){
        return $this->_keys;
    }
   
}