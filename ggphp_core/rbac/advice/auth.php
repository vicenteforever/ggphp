<?php

/**
 * 基于角色的权限认证
 * @package advice
 * @author goodzsq@gmail.com
 */
class rbac_advice_auth extends advice_base {

    public function before($name, $args) {
        $perm = strtolower($name);
        if (!rbac_auth::access($perm)) {
            session()->redirect_url = uri();
            redirect(url('rbac', 'login'));
        }
    }

}