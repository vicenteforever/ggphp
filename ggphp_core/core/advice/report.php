<?php

/**
 * 程序运行报告
 * @package advice
 * @author goodzsq@gmail.com
 */
class core_advice_report extends advice_base {

    public function after($name, $args, $return) {
        $report = '<hr/>';
        if (!config('app', 'debug')) {
            $report = "程序运行状态只能在调试模式下运行";
        } else {
            $log = app()->log();
            $time = $log[0]['time'];
            foreach ($log as $k => $v) {
                $timespan = sprintf("%.4f", $v['time'] - $time);
                $time = $v['time'];
                $report .= "[{$timespan}] {$v['message']} <br/>";
            }
            $total = sprintf("%.4f", $time - $log[0]['time']);
            $report .= "程序运行时间:$total ms, memory:" . util_string::size_hum_read(memory_get_usage()) . " <br>";
            $report .= "<a href='" . base_url() . "unittest'>运行单元测试</a>";
            $report .= "url rewrite:".core_request::isRewrite();
        }
        return $return . $report;
    }

}