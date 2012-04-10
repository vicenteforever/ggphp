<?php

/**
 * 程序运行报告
 * @package
 * @author goodzsq@gmail.com
 */
class util_debug {

    static public function display() {
        if (app()->getPageType() != 'html') {
            return;
        }
        if (!config('app', 'debug')) {
            return;
        }

        $report = '<hr/>';
        $log = app()->log();
        $time = $log[0]['time'];
        foreach ($log as $k => $v) {
            $timespan = sprintf("%.4f", $v['time'] - $time);
            $time = $v['time'];
            $report .= "<div class='log_{$v['level']}'>[{$timespan}] " . trace($v['data']) . "</div>\n";
        }
        $total = sprintf("%.4f", $time - $log[0]['time']);
        $report .= "程序运行时间:$total ms, memory:" . util_string::size_hum_read(memory_get_usage()) . " <br>";
        $report .= "<a href='" . base_url() . "unittest'>运行单元测试</a>";
        $report .= "url rewrite:" . core_request::isRewrite();

        echo $report;
        $cssfile = config('app', 'common_path') . 'css/ggphp/debug.css';
$code = <<<EOF
<script type='text/javascript'>
(function(){
    var fileref=document.createElement("link");
    fileref.rel = "stylesheet";
    fileref.type = "text/css";
    fileref.href = '$cssfile';
    fileref.media="screen";
    var headobj = document.getElementsByTagName('head')[0];
    headobj.appendChild(fileref);
    console.log(headobj);
})();
</script>
EOF;
        echo $code;
    }

}

