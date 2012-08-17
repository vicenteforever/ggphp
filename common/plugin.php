<?php

/**
 * jquery常用组件包装
 * @package script
 * @author goodzsq@gmail.com
 */
class script_jquery_plugin {

    const jquery_ver = '1.7.1';
    private $_commonPath;

    public function __construct() {
        $this->_commonPath = config('app', 'common_path') . 'js';
        response()->addScriptFile("{$this->_commonPath}/jquery/jquery-".self::jquery_ver.".min.js");
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
     * 转换为flash对象
     * @param string $selector
     * @param array $params 
     * @see http://jquery.thewikies.com/swfobject/
     */
    function swfobject($selector, array $params=array()){
        $flashvars = json_encode($params);
        response()->addScriptFile("{$this->_commonPath}/swfobject/jquery.swfobject.1-1-1.min.js");
        $code = <<<EOF
$("$selector").flash($flashvars);
EOF;
        $this->ready($code);
    }
    
    /**
     * 生成下拉式菜单
     * @param string $selector jquery选择器 
     */
    function menu($selector) {
        response()->addScriptFile("{$this->_commonPath}/goodzsq/goodzsq_menu.js");
        $this->ready("$('$selector').goodzsq_menu();");
    }
    
    /**
     * 表格变色
     * @param type $selector 
     */
    function table($selector) {
        response()->addScriptFile("{$this->_commonPath}/goodzsq/goodzsq_table.js");
        $this->ready("$('$selector').goodzsq_table();");
    }
    
    /**
     * ajax级联下拉框 用于选择类似省->市->区的例子
     * @param type $selector
     * @param type $url 
     */
    function ajaxLevelSelect($selector, $url){
        response()->addScriptFile("{$this->_commonPath}/goodzsq/goodzsq_level.js");
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
        if(!xml){
            console.log('no data');
            return false;
        }
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
            console.log(xml);
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
     * @see http://www.tinymce.com/
     */
    public function tinymce($selector){
        response()->addScriptFile("{$this->_commonPath}/tiny_mce/jquery.tinymce.js");
        response()->addScriptFile("{$this->_commonPath}/tiny_mce/tiny_mce.js");
        $code = <<<EOF
$('$selector').tinymce({
    'language':'zh-cn',
    theme : "advanced"
});
EOF;
        jquery_plugin()->ready($code);        
    }
    
    /**
     * uploadify上传组件支持多文件上传显示进度
     * @param string $selector jquery选择器
     * @param string $saver 处理上传文件的url
     * @param mixed $params 上传文件的附加参数
     * @see http://www.uploadify.com/
     */
    public function uploadify($selector, $saver, $params){
        $basepath = $this->_commonPath . '/uploadify';
        response()->addCssFile("{$this->_commonPath}/uploadify/uploadify.css");
        response()->addScriptFile("{$this->_commonPath}/swfobject/swfobject.js");
        response()->addScriptFile("{$this->_commonPath}/uploadify/jquery.uploadify.js");
        $scriptData = json_encode($params);
        $code = <<<EOF
$("$selector").uploadify({
    scriptData: $scriptData,
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

    /**
     * marquee插件
     * @param string $selector
     * @see http://remysharp.com/tag/marquee
     */
    function marquee($selector){
        response()->addScriptFile("{$this->_commonPath}/plugins/jquery.marquee.js");
        $this->ready("$('$selector').marquee();");
    }
}
