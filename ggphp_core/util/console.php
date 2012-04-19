<?php

/**
 * 程序调试控制台
 * @package
 * @author goodzsq@gmail.com
 */
class util_console {

    static public function formatData($obj) {
        if (is_string($obj)) {
            return "'$obj'";
        } else if (is_bool($obj)) {
            return ($obj == true) ? "'true'" : "'false'";
        } else if (is_object($obj)) {
            return json_encode($obj);
        } else if (is_array($obj)) {
            return json_encode($obj);
        } else if (is_null($obj)) {
            return '';
        } else {
            return "'未知的格式:$obj'";
        }
    }

    static public function display() {
        if (app()->getPageType() != 'html') {
            return;
        }
        if (!config('app', 'debug')) {
            return;
        }

        $log = app()->log();
        $time = $log[0]['time'];
        $console = "";
        foreach ($log as $k => $v) {
            $timespan = sprintf("%.4f", $v['time'] - $time);
            $time = $v['time'];
            $data = self::formatData($v['data']);
            $message = addslashes($v['message']);
            $message = str_replace("\n", "\\n", $message);
            if ($v['level'] == core_app::LOG_WARN) {
                $console .= "console.warn('[$timespan] {$message}');\n";
            } else if ($v['level'] == core_app::LOG_ERROR) {
                $console .= "console.error('[$timespan] {$message}');\n";
            } else {
                $console .= "console.info('[$timespan] {$message}');\n";
            }
            if (!empty($data)) {
                $console .= "console.log($data);\n";
            }
        }
        $total = sprintf("%.4f", $time - $log[0]['time']);
        $data = "url rewrite:" . core_request::isRewrite();
        $console .= "console.log('$data');\n";
        $data = "程序运行时间:$total 毫秒, 内存使用:" . util_string::size_hum_read(memory_get_usage());
        $console .= "console.log('$data');\n";

        $code = <<<EOF
<script type='text/javascript'>
(function(){
    if(window.console){
    $console
    }
})();
</script>
EOF;
        echo $code;
    }

}

