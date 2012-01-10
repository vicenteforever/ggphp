<?php

/**
 * hook report
 * @package hook
 * @author goodzsq@gmail.com
 */
class advice_report implements advice_interface {

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
        }
        return $return . $report;
    }

    public function before($name, $args) {
        
    }

    public function except($name, $args, $except) {
        
    }

}

?>
