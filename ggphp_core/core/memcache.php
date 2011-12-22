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
    private $_groupCount = 0;
    private $_groupNameList = array();
    private $_random; //随机选择服务器组
    private $_keys = array(); //所有键
    private $_keyskey = 'goodzsq';
    private $_prefix = '';

    /**
     * 从配置文件中构造分布式memcache集群分组
     */
    function __construct($prefix) {
        $this->_prefix = $prefix;
        $config = config('memcache');
        foreach ($config as $group => $hosts) {
            $this->initServerGroup($group, $hosts);
        }
        $this->_random = rand(0, $this->_groupCount - 1);
        $this->_keys = $this->get($this->_keyskey);
        if (!is_array($this->_keys)) {
            $this->_keys = array();
        }
    }

    /**
     * 为一个服务器组生成一个Memcache对象
     * @param string $group
     * @param array $hosts 
     */
    private function initServerGroup($group, $hosts) {
        $this->_driver[$group] = new Memcache();
        foreach ($hosts as $server) {
            $this->_driver[$group]->addServer($server['host'], $server['port']);
        }
        $this->_groupNameList[] = $group;
        $this->_groupCount++;
    }

    /**
     * 代表当前组的下一组服务器的memcache对象
     * @return Memcache
     */
    private function nextGroup() {
        $i = $this->_random + 1;
        if ($i >= $this->_groupCount) {
            $i = 0;
        }
        $groupName = $this->_groupNameList[$i];
        return $this->_driver[$groupName];
    }

    /**
     * 当前组服务器的memcache对象
     * @return Memcache
     */
    private function currentGroup() {
        $groupName = $this->_groupNameList[$this->_random];
        return $this->_driver[$groupName];
    }

    /**
     * 加前缀的真实存储在memcache的key
     * @param string $name
     * @return string 
     */
    private function prefixKey($name){
        return "{$this->_prefix}_{$name}";
    }
    
    /**
     * 读取key的值
     * @param string $name
     * @return mixed 
     */
    public function get($name) {
        $name = $this->prefixKey($name);
        $value = @$this->currentGroup()->get($name);
        if ($value === false) {
            if ($this->_groupCount > 1) {
                //当前组故障时从下一组获取数据
                $value = @$this->nextGroup()->get($name);
                //将恢复的数据重新存储当前组
                @$this->currentGroup()->set($name, $value);
                return $value;
            } else {
                return null;
            }
        } else {
            //正常读取
            return $value;
        }
    }

    public function __get($name) {
        return $this->get($name);
    }

    /**
     * 为一个key赋值
     * @param string $name
     * @param mixed $value 
     */
    public function set($name, $value) {
        $this->_keys[$name] = 1;
        $name = $this->prefixKey($name);
        foreach ($this->_driver as $group => $mem) {
            @$mem->set($name, $value);
            @$mem->set($this->prefixKey($this->_keyskey), $this->_keys);
        }
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }

    /**
     * 删除一个key
     * @param string $name 
     */
    public function delete($name) {
        unset($this->_keys[$name]);
        $name = $this->prefixKey($name);
        foreach ($this->_driver as $group => $mem) {
            @$mem->delete($name);
            @$mem->set($this->prefixKey($this->_keyskey), $this->_keys);
        }
    }

    public function __unset($name) {
        $this->delete($name);
    }

    /**
     * 删除$prefix相关的所有数据
     */
    public function deleteAll(){
        $keys = $this->keys();
        foreach($keys as $key=>$v){
            $this->delete($key);
        }
    }
    
    /**
     * 取得memcache的所有key，仅维护使用core_memcache对象使用过的key，不包括服务器的所有key
     * @return array
     */
    public function keys() {
        return $this->_keys;
    }

}