<?php

class Controller_Default {

	function doIndex(){
		echo 'hello world';
	}

	function doVideo(){
		$displaycount = 10;
		$title = '私人影院';

		if(param('file')!=''){
			$model = new model_videoinfo(param('file'));
			$secondary = view('jqm/infolist', array('list'=>$model->getInfo()));
			$primary = view('jqm/intro', array('content'=>$model->getContent()));
			$tmp = $model->getTitle();
			if(!empty($tmp)) $title = $tmp;
			$body = view('jqm/body', array(
				'primary'=>$primary, 
				'secondary'=>$secondary,
				'title' => $title,
				));
		}
		else{
			$model = model('video');
			$model->load(param('dir'));
			$tmp = $model->getTitle();
			if(!empty($tmp)) $title = $tmp;

			$files = $model->getFiles();
			$dirs = $model->getSubDirs();

			//分页
			$pages = ceil(count($files)/$displaycount);
			$page = param('page');
			if(empty($page)) $page = 1;
			$start = ($page-1)*$displaycount;
			$end = $start + $displaycount;

			$secondary = view('jqm/dirlist', array('list'=>$dirs, 'pages'=>$pages));
			
			$infos = array();
			$info = new model_videoinfo();
			$i=0;
			foreach($files as $file){
				if($i>=$start && $i<$end){
					$infos[] = array_merge($info->loadInfo($file['path']), $file);
				}
				$i++;
			}
			$primary = view('jqm/filelist', array('list'=>$infos));

			$parent_dir = util_filename::parent_dir(param('dir'));

			$body = view('jqm/body', array(
				'primary'=>$primary, 
				'secondary'=>$secondary,
				'title' => $title,
				));
		}

		$this->html($body);
	}

	function doMusic(){
		$title = '音乐欣赏';
		$model = model('music');
		$model->load(param('dir'));
		
		$secondary = view('jqm/dirlist', array('list'=>$model->getSubDirs()));
		$primary = view('jqm/filelist', array('list'=>$model->getFiles()));

		$parent_dir = util_filename::parent_dir(param('dir'));

		$body = view('jqm/body', array(
			'primary'=>$primary, 
			'secondary'=>$secondary,
			'title' => $title,
			));

		$this->html($body);
	}

	function doPhoto(){
		$title = '图片浏览';
		$model = model('photo');
		$model->load(param('dir'));
		
		$secondary = view('jqm/dirlist', array('list'=>$model->getSubDirs()));
		$primary = view('jqm/filelist', array('list'=>$model->getFiles()));

		$parent_dir = util_filename::parent_dir(param('dir'));

		$body = view('jqm/body', array(
			'primary'=>$primary, 
			'secondary'=>$secondary,
			'title' => $title,
			));

		$this->html($body);
	}

	function doSmartHome(){
		$title = '智能家居';
		$model = model('smarthome');
		
		$secondary = view('jqm/dirlist', array('list'=>$model->getSubDirs()));
		$primary = view('jqm/filelist', array('list'=>$model->getFiles()));

		$body = view('jqm/body', array(
			'primary'=>$primary, 
			'secondary'=>$secondary,
			'title' => $title,
			));

		$this->html($body);
	}

	/*
	 *
	 */
	private function html($body){
		echo view('jqm/html', array('body'=>$body));
	}

}