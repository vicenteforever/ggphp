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

    function ready($code) {
        $buf = "$(document).ready(function(){\n";
        $buf .= $code;
        $buf .= "\n});";
        response()->addScriptInline($buf);
        return $this;
    }

    function menu($select) {
        response()->addScriptFile('js/gg_menu.js');
        $this->ready("$('$select').gg_menu()");
    }

    function ajaxSubmit($select) {
        $code = <<<EOF
$("$select").submit(function(){
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

}
