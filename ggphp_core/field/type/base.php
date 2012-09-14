<?php

/**
 * 所有字段类型的基类
 * @package field
 * @author goodzsq@gmail.com
 */
abstract class field_type_base {

    public $name;                 //字段名称
    public $label;                //字段标签
    public $type = 'string';      //数据类型
    public $length = null;        //长度
    public $unsigned = false;     //是否为无符号整数
    public $allowNull = false;    //是否允许为空
    public $required = false;     //是否必须填写
    public $default = null;       //默认值
    public $index = null;         //是否为索引
    public $serial = false;       //自动加一
    public $widget = 'string';    //字段控件
    public $validators = array(); //字段校验器集
    public $encoder = '';         //字段编码器
    public $isDatabase = true;    //是否为数据库字段
    public $isHidden = false;     //是否隐藏控件
    public $storage = null;       //

    public function __construct(array $arr) {
        foreach ($arr as $k => $v) {
            $this->$k = $v;
        }
        if (empty($this->name)) {
            throw new Exception('field name not assign');
        }
        if (!isset($this->label)) {
            $this->label = $this->name;
        }

        //不必须填写的字符串并且没设默认值的=>[设置为空串]
        if ($this->type == 'string' && !$this->required && $this->default === null) {
            $this->default = '';
        }
    }

    /**
     * 读取未设置属性时返回空值，用于屏蔽错误消息
     * @param string $name
     * @return null 
     */
    public function __get($name) {
        return null;
    }

    /**
     * 字段校验
     * @param mixed $value
     * @return mixed 校验通过返回true 校验失败返回错误消息字符串 
     */
    public function validate($value) {
        if ($this->required && empty($value)) {
            return "{$this->label}必须填写";
        }
        foreach ($this->validators as $rule) {
            $validator = self::validator($rule);
            if (empty($validator)) {
                return "校验器{$rule}不存在";
            }
            $err = $validator->validate($this, $value);
            if ($err !== true) {
                return $err;
            }
        }
        return true;
    }

    public function encode($value) {
        if (!empty($this->encoder)) {
            $encoder = self::encoder($this->encoder);
            return $encoder->encode($value);
        } else {
            return $value;
        }
    }

    public function decode($value) {
        if (!empty($this->encoder)) {
            $encoder = self::encoder($this->encoder);
            return $encoder->decode($value);
        } else {
            return $value;
        }
    }

    public function save($oldData, $newData, $options) {
        if (!empty($this->storage)) {
            $storage = self::storage($this->storage);
            return $storage->save($oldData, $newData, $options);
        } else {
            return $newData;
        }
    }

    public function load($data, $options) {
        if (!empty($this->storage)) {
            $storage = self::storage($this->storage);
            return $storage->load($data, $options);
        } else {
            return $data;
        }
    }

    public function delete($data) {
        if (!empty($this->storage)) {
            $storage = self::storage($this->storage);
            return $storage->delete($data);
        } else {
            return true;
        }
    }

    public function toArray() {
        $result = array();
        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    /**
     * 获取字段校验器
     * @param string $rule
     * @return field_validator_interface
     * @throws Exception 
     */
    static public function validator($rule) {
        static $validator = null;
        if (!isset($validator[$rule])) {
            $className = 'field_validator_' . $rule;
            $object = new $className();
            if ($object instanceof field_validator_interface) {
                $validator[$rule] = $object;
            } else {
                throw new Exception("{$className} not exist");
            }
        }
        return $validator[$rule];
    }

    /**
     * 获取字段存取器
     * @param string $rule
     * @return field_encoder_interface
     * @throws Exception 
     */
    static public function encoder($rule) {
        static $encoder = null;
        if (!isset($encoder[$rule])) {
            $className = 'field_encoder_' . $rule;
            $object = new $className();
            if ($object instanceof field_encoder_interface) {
                $encoder[$rule] = $object;
            } else {
                throw new Exception("{$className} not exist");
            }
        }
        return $encoder[$rule];
    }

    /**
     * 获取字段存储器
     * @param string $rule 
     * @return field_storage_interface
     * @throw Exception
     */
    static public function storage($rule) {
        static $storage = null;
        if (!isset($storage[$rule])) {
            $className = 'field_storage_' . $rule;
            $object = new $className();
            if ($object instanceof field_storage_interface) {
                $storage[$rule] = $object;
            } else {
                throw new Exception("{$className} not exist");
            }
        }
        return $storage[$rule];
    }

}