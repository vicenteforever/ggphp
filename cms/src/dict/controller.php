<?php

/**
 * 字典
 * @package dict
 * @author goodzsq@gmail.com
 */
class dict_controller {

    public function do_index(){
        //return 'hello dict';
    }
    
    public function do_province() {
        $data['data'] = dict('province')->getData();
        $data['level'] = array('省', '市', '区');
        echo json_encode($data);
        //debug file_put_contents(util_string::token(), path());
        exit;
    }

}

