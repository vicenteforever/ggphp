<?php

/**
 * 框架常用函数集
 * @package core
 * @author goodzsq@gmail.com
 */

/**
 * 获取应用实例
 * @return core_app
 */
function app() {
    return core_app::instance();
}

/**
 * 获取session类
 * @staticvar core_session $session
 * @return core_session 
 */
function session() {
    return core_session::instance();
}

/**
 * 获取nosql键值存储对象
 * @staticvar className $nosql
 * @param string $adapter 适配器类文件名称
 * @param string $source 数据源名称
 * @return nosql_object 
 */
function nosql($adapter, $source) {
    static $nosql;
    if (!isset($nosql[$adapter][$source])) {
        $className = "nosql_{$adapter}";
        $nosql[$adapter][$source] = new $className($source);
    }
    return $nosql[$adapter][$source];
}

/**
 * 翻译
 * @return core_language
 */
function t($str, $language=null) {
    return core_language::translate($str, $language);
}

/**
 * 读取配置
 * return string|array
 */
function config($file, $key='') {
    return config_loader::load($file, $key);
}

/**
 * 单元测试
 * @staticvar unittest_case $test
 * @return unittest_case 
 */
function test() {
    static $test;
    if (!isset($test)) {
        $test = new unittest_case();
    }
    return $test;
}

/**
 * 获取存取数据服务对象
 * @param string $table
 * @param string $storage
 * @return object;
 * @example storage('database', 'log_table')->save('2000-01-01 00:00:00', '新世纪开始');
 */
function storage($storage, $group) {
    static $storage_object;
    $key = $storage . $group;
    if (!isset($storage_object[$key])) {
        try {
            $adapter = 'storage_adapter_' . $storage;
            $storage_object[$key] = new $adapter($group);
        } catch (Exception $e) {
            throw new Exception(t('storage not exists') . ":[{$storage}]");
        }
    }
    return $storage_object[$key];
}

/**
 * 获取pdo数据库对象
 * @param string $dbname 数据库配置文件config/database.php中的配置名称
 * @return PDO
 */
function pdo($dbname=null) {
    static $pdo;
    if (empty($dbname))
        $dbname = 'default';
    if (!isset($pdo[$dbname])) {
        $config = config('database', $dbname);
        try {
            $pdo[$dbname] = new PDO($config['DSN'], $config['username'], $config['password'], $config['driver_opts']);
            if (!empty($config['charset'])) {
                $pdo[$dbname]->exec("SET names '{$config['charset']}'");
            }
        } catch (PDOException $exception) {
            throw new Exception(t("连接数据库失败") . $exception->getMessage());
        }
    }
    return $pdo[$dbname];
}

/**
 * 加载视图
 * @return string
 */
function view($view=null, $data=null) {
    return core_view::php($view, $data);
}

/**
 * 获取memcache对象
 * @param $server memcache配置
 * @return Memcache
 */
function memcache($server=null) {
    static $memcache;
    if (empty($server)) {
        $server = 'default';
    }
    if (!isset($memcache[$server])) {
        $memcache[$server] = new Memcache();

        $cfg = config('memcache', $server);
        if (empty($cfg)) {
            throw new Exception(t('memcache config not found:') . "[$server]");
        }
        if (!@$memcache[$server]->connect($cfg['host'], $cfg['port'])) {
            unset($memcache[$server]);
            app()->log('memcache server not found');
            return null;
        }
    }
    return $memcache[$server];
}

/**
 * 打印输出变量值
 * @param string $str
 * @param mixed $filters
 * @return null
 */
function output($str, $filters=null) {
    if (empty($filters)) {
        return $str;
    } else {
        if (is_array($filters)) {
            foreach ($filters as $filter) {
                $str = util_filter::$filter($str);
            }
        } else {
            $str = util_filter::$filters($str);
        }
        return $str;
    }
}

/**
 * 打印调试变量
 * @param mixed $obj
 * @return string 
 */
function trace($obj) {
    $buf = '<pre>';
    $buf .= print_r($obj, true);
    $buf .= '</pre>';
    return $buf;
}

/**
 * 显示错误页面并退出程序
 * @param $errorMessage
 */
function error($errorMessage) {
    echo view('error', array('errorMessage' => $errorMessage));
    exit;
}

/**
 * gbk转utf-8编码
 */
function utf8($str) {
    if (util_string::is_utf8($str))
        return $str;
    else
        return iconv('gbk', 'utf-8', $str);
}

/**
 * utf-8转gbk编码
 */
function gbk($str) {
    if (util_string::is_utf8($str))
        return iconv('utf-8', 'gbk', $str);
    else
        return $str;
}

/**
 * 获取提交的参数值
 * @param string $key 提交参数名称
 * @param bool $filter 是否使用过滤器过滤
 * @return mixed
 */
function param($key, $filter=true) {
    return core_request::param($key, $filter);
}

/**
 * 获取uri
 * @return string
 */
function uri() {
    return core_request::uri();
}

/**
 * 获取pathinfo
 * @return string
 */
function path() {
    return core_request::path();
}

/**
 * 获取完整路径信息
 * @return string
 */
function full_path() {
    return core_request::fullPath();
}

/**
 * 获取当前应用的baseurl
 * @return string
 */
function base_url() {
    return core_request::baseUrl();
}

/**
 * 生成url
 * @param string $controller
 * @param string $action
 * @param string $path
 * @param mixed $params string or array
 * @return string 
 */
function url($controller='', $action='', $path='', $params='') {
    return core_request::makeUrl($controller, $action, $path, $params);
}

/**
 * 输出html页面
 * @param type $content
 * @param type $title
 * @return type 
 */
function html($content, $title=null) {
    if (!isset($title)) {
        $controller = app()->getController() . '_controller';
        $action = config('app', 'action_prefix') . ucfirst(app()->getAction());
        $title = reflect($controller)->doc($action);
    }
    return view('html', array('content' => $content, 'title' => $title));
}

/**
 * 反射类
 * @staticvar core_reflect $reflect
 * @param type $className
 * @return core_reflect 
 */
function reflect($className) {
    static $reflect;
    if (!isset($reflect[$className])) {
        $reflect[$className] = new core_reflect($className);
    }
    return $reflect[$className];
}

/**
 * redirect url
 * @param string $url 
 */
function redirect($url) {
    core_response::redirect($url);
}

/**
 * 取得orm模型对象
 * @staticvar orm_mapper $orm
 * @param type $model config/schema配置文件名称
 * @return orm_mapper 
 */
function orm($model) {
    static $orm;
    if (!isset($orm[$model])) {
        $orm[$model] = new orm_mapper($model);
    }
    return $orm[$model];
}