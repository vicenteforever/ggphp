<?php

class model_movielist{

	function load(){
		$result = array();
		$rs = pdo()->query('select id,aliasname,subkind,region,language,year,recommend,rank,dir from video order by copytime desc limit 0, 200');
		foreach($rs as $row){
			$row['year'] = substr($row['year'], 0,4);
			$row['recommend'] = self::getScore($row['recommend']);
			$row['rank'] = self::getRank($row['rank']);
			$row['pic'] = file_exists(gbk($row['dir']).DS.'a1.jpg')?"cover/icon/{$row['id']}.jpg":'images/movie.png';
			$result[] = $row;
		}
		return $result;
	}


	public function getScore($score){
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
		return " <span class='bigstar{$id}'>　　　　{$score}分</span>";
	}

	public function getRank($rank){
		if($rank>0){
			return "适合{$rank}岁以上观看";
		}
		else{
			return "适合所有人观看";
		}
	}

}