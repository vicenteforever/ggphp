<?php

class git{

	function exe($cmd){
		$cmd = '"C:\\Program Files\\Git\\bin\\git.exe" '.$cmd;
		exec($cmd, $buf);
		return $buf;
	}

	function test($cmd){

		$descriptorspec = array(
		   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
		   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
		);
		$cwd = dirname(__FILE__);
		$process = proc_open('"C:\\Program Files\\Git\\bin\\git.exe" '.$cmd, $descriptorspec, $pipes,$cwd);

		if (is_resource($process)) {
			$buf = stream_get_contents($pipes[1]);
			fclose($pipes[0]);
			fclose($pipes[1]);
			$return_value = proc_close($process);
		}
		return $buf;

	}

}

print_r(git::test('log'));
