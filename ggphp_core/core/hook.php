<?php

/**
 * hook
 * @package core
 * @author goodzsq@gmail.com
 */
class core_hook {

    static function when($event) {
	$hooks = config('app', $event);
	if (is_array($hooks)) {
	    foreach ($hooks as $hook) {
		self::call($hook);
	    }
	} else {
	    self::call($hooks);
	}
    }

    static function call($hookName) {
	if (empty($hookName)){
	    return;
	}
	$hookName = "hook_{$hookName}";
	/* @var $hook hook_interface */
	$hook = new $hookName;
	app()->log('hook:'.$hookName);
	$hook->hook();
    }

}

?>
