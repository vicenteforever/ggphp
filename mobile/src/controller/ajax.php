<?php
class controller_ajax{

	function doMovieList(){
		$list = model_movielist::load();
		echo GG_Response::json($list);
	}

	function doMovieInfo(){
		$info = model_movieinfo::load(param('id'));
		$result['bookmark'] = 'bookmark<button onclick="alert(123)">sddsfdf</button>';
		$result['intro'] = "<h1>{$info['aliasname']}</h1>";
		$result['intro'] .= "<div>导演：{$info['director']}</div>";
		$result['intro'] .= "<div>演员：{$info['actor']}</div>";
		$result['intro'] .= "<div>简介：{$info['intro']}</div>";
		echo GG_Response::json($result);
	}
}