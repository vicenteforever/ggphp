<?php

/**
 * 防止伪造跨站请求csrf
 * @package util
 * @author goodzsq@gmail.com
 */
class util_csrf {

    /**
     * csrf token 所使用的键值
     * @return string 
     */
    static public function key() {
        return 'csrf_token';
    }

    /**
     * 生成csrf token 并保存到session中
     * @return string 
     */
    static public function token() {
        $token = util_string::token();
        $key = self::key();
        session()->$key = $token;
        return $token;
    }

    /**
     * csrf校验
     * @param string $token
     * @return boolean 
     */
    static public function validate() {
        if(!core_request::isPost()){
            return '请用post方法提交数据';
        }
        $key = self::key();
        $token_session = session()->$key;
        $token_param = param($key);
        if (empty($token_session)) {
            return '数据已经过期[token为空]， 请关闭此窗口';
        } else if ($token_session != $token_param) {
            return '数据已经过期[token不一致]，请关闭此窗口';
        } else {
            return ;
        };
    }

}

