<?php

/**
 * script_jquery
 * @package script
 * @author goodzsq@gmail.com
 */
class script_jquery {

    public function __construct() {
        response()->addScriptFile('js/jquery.js');
    }

    /**
     * ready
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
        response()->addScriptFile('js/gg_menu.js');
        $this->ready("$('$selector').gg_menu();");
    }
    
    /**
     * 表格变色
     * @param type $selector 
     */
    function table($selector) {
        response()->addScriptFile('js/gg_table.js');
        $this->ready("$('$selector').gg_table();");
    }

    /**
     * 以ajax方式提交窗体
     * @param string $selector jquery的form选择器 
     */
    function ajaxSubmit($selector) {
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
            for(field in xml.error){
                form.find('.tip[name='+field+']').html(xml.error[field]).css({color:'red'});
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
     * 生成tinymce编辑器
     * @param string $selector 
     */
    function tinymce($selector){
        response()->addScriptFile('tiny_mce/jquery.tinymce.js');
        $code = <<<EOF
$('$selector').tinymce({
    script_url : 'tiny_mce/tiny_mce.js',
    'language':'zh-cn',
    theme : "advanced"
});        
EOF;
        $this->ready($code);
    }

}
