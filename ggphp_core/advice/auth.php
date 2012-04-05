<?php

/**
 * 基于角色的权限认证
 * @package advice
 * @author goodzsq@gmail.com
 */
class advice_auth extends advice_base {

    public function before($class, $method, $args) {
        $config = config('advice', $class);
        $roles = $config[$method]['roles'];
        if (!rbac_auth::access($perm)) {
            session()->redirect_url = uri();
            redirect(make_url('rbac', 'login'));
        }
    }
    
    public function setting(){
        return array(
            array('name' => 'auth_role', 'label' => '角色', 'field' => 'string'),
        );
    }

}