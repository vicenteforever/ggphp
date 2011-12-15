<?php

/**
 * 常用函数快捷方法
 * @author goodzsq@gmail.com
 */
function app() {
    return core_app::instance();
}

/**
 * 翻译
 */
function t($str, $language=null) {
    return core_language::translate($str, $language);
}

/**
 * 读取配置
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
 * @return mixed
 */
function pdo($dbname='default') {
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
 */
function view($view=null, $data=null) {
    return core_view::php($view, $data);
}

/**
 * 获取memcache对象
 * @param $config memcache配置
 * @return memcache
 */
function memcache($config) {
    static $memcache;
    if (!isset($memcache[$config])) {
        $memcache[$config] = new Memcache();
        $cfg = config('memcache', $config);
        if (empty($cfg)) {
            throw new Exception(t('memcache config not found:') . "[$config]");
        }
        if (!$memcache[$server]->connect($cfg['host'], $cfg['port'])) {
            throw new Exception(t('memcache server fail'));
        }
    }
    return $memcache[$config];
}

/**
 * 打印输出变量值
 * @param string $str
 * @param mix $filters
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
 * print_r aliasname
 */
function trace($obj) {
    $buf = '<pre>';
    $buf .= print_r($obj, true);
    $buf .= '</pre>';
    return $buf;
}

/**
 * 启用session
 * 可保证仅调用一次session_start函数
 * @return array
 */
function use_session() {
    static $isStart;
    if (!isset($isStart)) {
        session_start();
        $isStart = true;
    }
}

/**
 * 显示错误页面
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
 * @return mix
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
 * @return string
 */
function make_url($controller='', $action='', $path='') {
    if (param('GG_REWRITE', false) == 1) {
        $url = base_url() . trim("$controller/$action/$path", '/');
    } else {
        $tmp = explode('/', $path);
        $params = '';
        if (!empty($path)) {
            foreach ($tmp as $k => $v) {
                $params .= 'arg[]=' . $v . '&';
            }
            $params = trim($params, '&');
        }
        $url = base_url() . "?controller=$controller&action=$action";
        if (!empty($params))
            $url .= '&' . $params;
    }
    return $url;
}

function html($content, $title=null) {
    if (!isset($title))
        $title = config('app', 'app_name');
    return view('html', array('content' => $content, 'title' => $title));
}