<?php

class model_videoinfo {
	private $_file;
	private $_realfile;
	private $_info = array();

	function __construct($file=''){
		if(!empty($file))
			$this->loadinfo($file);
	}

	function getInfo(){
		return $this->_info;
	}

	function getContent(){
		if (isset($_info['_content']))
			return $_info['_content'];
		else
			return "暂无内容";
	}

	function getTitle(){
		$tmp = explode(DS, $this->_file);
		$title = end($tmp);
		return $title;
	}

	public function loadinfo($file){
		if(util_string::is_utf8($file)){
			$this->_realpath = gbk($file);
			$this->_file = $file;
		}
		else{
			$this->_realpath = $file;
			$this->_file = utf8($file);
		}

		if(is_dir($this->_realpath))
			$infofile = $this->_realpath.DS.'info.txt';
		else
			$infofile = $this->_realpath.'.txt';
		$this->_info = array();
		if(file_exists($infofile)){
			$content = file_get_contents($infofile);
			$this->_info = unserialize($content);
		}
		$this->_info['_path'] = $file;
		$this->_info['格式'] = util_filename::file_ext($file);

		if(isset($this->_info['评价'])){
			$this->_info['评价'] = $this->getScore($this->_info['评价']);
		}
		if(isset($this->_info['分级'])){
			$this->_info['分级'] = $this->getRank($this->_info['分级']);
		}
		$this->_info['_summary'] = @$this->_info['分级'];
		return $this->_info;
	}

	private function getScore($score){
		switch($score){
			case $score>9 && $score<=10:
				$id = '50';
				break;
			case $score>8 && $score<=9:
				$id = '45';
				break;
			case $score>7 && $score<=8:
				$id = '40';
				break;
			case $score>6 && $score<=7:
				$id = '35';
				break;
			case $score>5 && $score<=6:
				$id = '30';
				break;
			case $score>4 && $score<=5:
				$id = '25';
				break;
			case $score>3 && $score<=4:
				$id = '20';
				break;
			case $score>2 && $score<=3:
				$id = '15';
				break;
			case $score>1 && $score<=2:
				$id = '10';
				break;
			case $score>0.5 && $score<=1:
				$id = '05';
				break;
			default:
				$id = '00';
		}
		return " <span class='bigstar{$id}'>　　　　　　{$score}分</span>";
	}

	private function getRank($rank){
		if($rank>0){
			return "适合{$rank}年龄以上观看";
		}
		else{
			return "适合所有人观看";
		}
	}
}