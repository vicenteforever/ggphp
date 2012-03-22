<?php

/**
 * 文件上传类
 * @package util
 * @author goodzsq@gmail.com
 */
class util_uploader {

    static public $allowFileTypes = array('jpeg', 'jpg', 'gif', 'bmp', 'png', 'zip', 'rar');
    static public $maxFileSize = 8388608;

    static public function setAllowExt($fileTypes) {
        if (!is_array($fileTypes)) {
            self::$allowFileTypes = explode(',', $fileTypes);
        } else {
            self::$allowFileTypes = $fileTypes;
        }
        return;
    }

    /**
     * 上传文件
     * @param array $fileField 来自$_FILES[fieldname]变量
     * @param string $destFolder 目标目录
     * @param integer $fileNameType 上传文件命名规则
     * @return string 保存的文件名称
     * @throws Exception 上传失败扔出异常
     */
    static public function upload($fileField, $destFolder = './') {
        switch ($fileField['error']) {
            case UPLOAD_ERR_OK : //其值为 0，没有错误发生，文件上传成功。
                $upload_succeed = true;
                break;
            case UPLOAD_ERR_INI_SIZE : //其值为 1，上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。
            case UPLOAD_ERR_FORM_SIZE : //其值为 2，上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。
                $errorMsg = '文件上传失败！失败原因：文件大小超出限制！';
                $errorCode = -103;
                $upload_succeed = false;
                break;
            case UPLOAD_ERR_PARTIAL : //值：3; 文件只有部分被上传。
                $errorMsg = '文件上传失败！失败原因：文件只有部分被上传！';
                $errorCode = -101;
                $upload_succeed = false;
                break;
            case UPLOAD_ERR_NO_FILE : //值：4; 没有文件被上传。
                $errorMsg = '文件上传失败！失败原因：没有文件被上传！';
                $errorCode = -102;
                $upload_succeed = false;
                break;
            case UPLOAD_ERR_NO_TMP_DIR : //其值为 6，找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。
                $errorMsg = '文件上传失败！失败原因：找不到临时文件夹！';
                $errorCode = -102;
                $upload_succeed = false;
                break;
            case UPLOAD_ERR_CANT_WRITE : //其值为 7，文件写入失败。PHP 5.1.0 引进。
                $errorMsg = '文件上传失败！失败原因：文件写入失败！';
                $errorCode = -102;
                $upload_succeed = false;
                break;
            default : //其它错误
                $errorMsg = '文件上传失败！失败原因：其它！';
                $errorCode = -100;
                $upload_succeed = false;
                break;
        }
        if ($upload_succeed) {
            if ($fileField['size'] > self::$maxFileSize) {
                $errorMsg = '文件上传失败！失败原因：文件大小超出限制！';
                $errorCode = -103;
                $upload_succeed = false;
            }
            if ($upload_succeed) {
                $fileExt = util_file::ext($fileField['name']);
                if (!in_array(strtolower($fileExt), self::$allowFileTypes)) {
                    $errorMsg = '文件上传失败！失败原因：文件类型不被允许！';
                    $errorCode = -104;
                    $upload_succeed = false;
                }
            }
        }
        if ($upload_succeed) {
            if (!is_dir($destFolder) && $destFolder != './' && $destFolder != '../') {
                mkdir($destFolder, 0777, true); //创建目录
            }

            //生成唯一的文件名称
            $fileFullName = util_string::token();

            if (move_uploaded_file($fileField["tmp_name"], $destFolder . $fileFullName)) {
                return $fileFullName;
            } else {
                $errorMsg = $destFolder . $fileFullName . " 文件上传失败！失败原因：本地文件系统读写权限出错！";
                $errorCode = -105;
                $upload_succeed = false;
            }
        }
        if (!$upload_succeed) {
            throw new Exception($errorMsg, $errorCode);
        }
    }

}