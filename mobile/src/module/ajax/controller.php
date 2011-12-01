<?php
class module_ajax_controller{

	function doMovieList(){
		$list = model_movielist::load();
		echo GG_Response::json($list);
	}

	function doMovieInfo(){
		$id = param('id');
		$pic = "cover/normal/{$id}.jpg";
		$imagesize = config('imagestyle', 'normal');
		$info = model_movieinfo::load($id);
		$result['intro'] = "<h1>{$info['aliasname']}</h1>";
		$result['intro'] .= "<div style='width:{$imagesize['Thumbwidth']}px;height:{$imagesize['Thumbheight']}px;background-image:url({$pic})'>{$pic}</div>";
		$result['intro'] .= "<div>导演：{$info['director']}</div>";
		$result['intro'] .= "<div>演员：{$info['actor']}</div>";
		$result['intro'] .= "<div>简介：{$info['intro']}</div>";
		echo GG_Response::json($result);
	}

	function doLight(){
		$lights = model_light::load();
		echo view('light', $lights);
	}

	function doBookmarkLoad(){
		$bookmark = model_bookmark::load();
		echo view('bookmark', $bookmark);
	}

	function doBookmarkSave(){
		$file = param('file');
		$time = param('time');
		$title = param('title');
		$bookmark = model_bookmark::load();
		$bookmark[$file.'_'.$time] = array('file'=>$file, 'time'=>$time, 'title'=>$title);
		model_bookmark::save($bookmark);
		echo "$title $time";
	}

	function doBookmarkDelete(){
		$id = param('id');
		$bookmark = model_bookmark::load();
		unset($bookmark[$id]);
		model_bookmark::save($bookmark);
		echo 'delete'.$id;
	}

	function doVideo(){
		$result = model_dir::load(config('app', 'video_dir'), config('app', 'video_type'));
		echo GG_Response::json($result);
	}

	function doMusic(){
		$result = model_dir::load(config('app', 'music_dir'), config('app', 'music_type'));
		echo GG_Response::json($result);
	}

}