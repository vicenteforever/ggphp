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
    }

}
