<?php

/**
 * core控制器
 * @package core
 */
class core_controller {

	function doIndex() {
		return html('ggphp core 核心类库');
	}

	function doModules() {
		return html(trace(core_module::all()));
	}

}