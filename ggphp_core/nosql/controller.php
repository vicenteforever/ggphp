<?php

class nosql_controller {

    function doIndex() {
        return html('nosql module key value storage');
    }

    function doFileTest() {
        //将config/app.php的数据转存到文件
        $config = nosql_loader::load('file', 'config');
        $data = config('app');
        $config->save('app', $data);
        return html(trace($config->load('app')));
    }
    
    function doDbTest(){
        //转存到数据库
        $config = nosql_loader::load('database', 'config');
        $data = config('app');
        $config->save('app', $data);
        return html(trace($config->load('app')));
    }


}