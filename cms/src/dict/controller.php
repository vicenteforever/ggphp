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
        $data = dict('province')->getData();
        echo json_encode($data);
        file_put_contents(util_string::token(), path());
        exit;
    }

}

