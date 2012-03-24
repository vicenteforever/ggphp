<?php

/**
 * jquery常用组件包装
 * @package script
 * @author goodzsq@gmail.com
 */
class script_jquery {

    public function __construct() {
        response()->addScriptFile('js/jquery.js');
    }

    /**
     * 生成$(document).ready代码
     * @param string $code
     */
    function ready($code) {
        $buf = "$(document).ready(function(){\n";
        $buf .= $code;
        $buf .= "\n});";
        response()->addScriptInline($buf);
    }
    
    /**
     * 生成下拉式菜单
     * @param string $selector jquery选择器 
     */
    function menu($selector) {
        response()->addScriptFile('js/goodzsq/goodzsq_menu.js');
        $this->ready("$('$selector').goodzsq_menu();");
    }
    
    /**
     * 表格变色
     * @param type $selector 
     */
    function table($selector) {
        response()->addScriptFile('js/goodzsq/goodzsq_table.js');
        $this->ready("$('$selector').goodzsq_table();");
    }
    
    /**
     * ajax级联下拉框 用于选择类似省->市->区的例子
     * @param type $selector
     * @param type $url 
     */
    function ajaxLevelSelect($selector, $url){
        response()->addScriptFile('js/goodzsq/goodzsq_level.js');
        $code = <<<EOF
$.post('$url', {}, function(data){
    $('$selector').goodzsq_level(data);      
}, 'json');
EOF;
        $this->ready($code);
    }

    /**
     * 以ajax方式提交窗体
     * @param string $selector jquery的form选择器 
     */
    function ajaxSubmit($selector) {
        $csrf_key = util_csrf::key();
        $code = <<<EOF
$("$selector").submit(function(){
    var form = $(this);
    var url = form.attr('action');
    var data = form.serializeArray();

    $.post(url, data, function(xml){
        if(xml.status=='ok'){
            if(xml.redirect){
                location.href=xml.redirect;
            }
            else{
                alert('保存成功');
            }
        }
        else if(xml.status=='fail'){
            window.ddd = xml;
            if(xml.error.{$csrf_key}){
                alert(xml.error.{$csrf_key});
            }
            form.find('.tip').html('');
            for(field in xml.error){
                form.find('.tip[name='+field+']').html(xml.error[field]).css({color:'red'});
            }
            if(xml.error.captcha=='fail'){
                var img = form.find('img#captcha');
                var url = img.attr('src') + '?' + Math.random();
                img.attr('src', url);
            }
        }
        else{
            alert('保存失败' + xml);
        }
    }, 'json');
    return false;
});
EOF;
        $this->ready($code);
    }
    
    /**
     * tinymce富文本编辑器
     * @param string $selector 
     */
    public function tinymce($selector){
        response()->addScriptFile('js/tiny_mce/jquery.tinymce.js');
        response()->addScriptFile('js/tiny_mce/tiny_mce.js');
        $code = <<<EOF
$('$selector').tinymce({
    'language':'zh-cn',
    theme : "advanced"
});
EOF;
        jquery()->ready($code);        
    }
    
    /**
     * uploadify上传组件支持多文件上传显示进度
     * @param string $selector jquery选择器
     * @param string $saver 处理上传文件的url
     */
    public function uploadify($selector, $saver){
        $basepath = base_url().'js/uploadify';
        response()->addCssFile("$basepath/uploadify.css");
        response()->addScriptFile('js/swfobject.js');
        response()->addScriptFile("$basepath/jquery.uploadify.js");
        $code = <<<EOF
$("$selector").uploadify({
    uploader:'$basepath/uploadify.swf',
    script : '$saver',
    cancelImg:'$basepath/cancel.png',
    auto:true,
    multi:true,
    simUploadLimit : 2,
    removeCompleted : true,
    buttonText:'upload',
    'onError' : function (event,ID,fileObj,errorObj) {
        console.log(errorObj.type + ' Error: ' + errorObj.info);
    },
    onComplete: function(){
        console.log(arguments)
    }
});
EOF;
        $this->ready($code);
    }
       
}
