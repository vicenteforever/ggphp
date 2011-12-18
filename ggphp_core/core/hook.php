<?php

/**
 * hook
 * @package core
 * @author goodzsq@gmail.com
 */
class core_hook {

    static function when($event) {
	app()->log("hook event: $event");
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
	if (empty($hookName)) {
	    return;
	}
	$hookName = "hook_{$hookName}";
	/* @var $hook hook_interface */
	$hook = new $hookName;
	if ($hook instanceof hook_interface) {
	    app()->log('hook exec:' . $hookName);
	    $hook->hook();
	}
	else{
	    app()->log('hook fail:' . $hookName);
	}
    }

}

?>
