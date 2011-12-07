<?php

class structure_mapper extends phpDataMapper_Base{

	public function __construct($name, $db='default'){
		$config = config("schema/$name");
		if(is_array($config)){
			foreach($config as $k=>$v){
				$this->$k = $v;
			}
		}
		$dbconfig = config('database', $db);
		$adapter = new phpDataMapper_Adapter_Mysql(pdo($db), $dbconfig['database']);
		parent::__construct($adapter);
	}
	
	public function debug()
	{
		$buf = "<p>Executed " . $this->queryCount() . " queries:</p>";
		$buf .= "<pre>\n";
		$buf .= print_r(self::$_queryLog, true);
		$buf .= "</pre>\n";
		return $buf;
	}	
}