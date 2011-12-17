<?php

/**
 * hook report
 * @package hook
 * @author goodzsq@gmail.com
 */
class hook_report implements hook_interface {

    /**
     * 报告程序运行情况
     */
    function hook() {
	if(!config('app', 'debug')){
	    echo "<hr/>程序运行状态只能在调试模式下运行";
	    return;
	}
	$result = '';
	$log = app()->log();
	$time = $log[0]['time'];
	foreach ($log as $k => $v) {
	    $timespan = sprintf("%.4f", $v['time'] - $time);
	    $time = $v['time'];
	    $result .= "[{$timespan}] {$v['message']} <br/>";
	}
	$total = sprintf("%.4f", $time - $log[0]['time']);
	$result .= "程序运行时间:$total ms, memory:" . util_string::size_hum_read(memory_get_usage()) . " <br>";
	$result .= "<a href='" . base_url() . "unittest'>运行单元测试</a>";
	echo '<hr/>' . $result;
    }

}

?>
