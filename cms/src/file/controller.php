<?php

/**
 * 文件上传下载控制器
 * @package upload
 * @author goodzsq@gmail.com
 */
class file_controller {

    /**
     * 文件上传 
     */
    function do_upload() {
        $filename = APP_DIR . DS . config('app', 'upload_dir') . DS . util_string::token();
        try {
            file_uploader::setAllowExt('pdf,zip,rar,srt,txt');
            $result = file_uploader::upload('Filedata', $filename);
            file_model::add(param('token'), $result);
            echo 'ok';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        exit;
    }

    function do_download() {
        $entity = file_model::get(param(0));
        if (!empty($entity)) {
            response()->download($entity->name, file_get_contents($entity->filename));
        }
        else{
            response()->error("文件不存在");
        }
    }
    
    function do_list(){
        $result = file_model::getList(param('token'));
        foreach($result as $row){
            $downloadurl = util_html::a(make_url('file', 'download', $row->id), '下载');
            $newrow = array('文件名'=>$row->name, '大小'=>  util_string::size_hum_read($row->size), '下载'=>$downloadurl);
            $data[] = $newrow;
        }
        $buf = widget('table', '', $data)->render();
        return $buf;
        response()->json($data);
    }

}

