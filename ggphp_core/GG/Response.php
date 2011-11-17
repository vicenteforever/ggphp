<?php

/**
 * Response¶ÔÏó·â×°
 */
class GG_Response{

	function script($addfile=null){
		static $script;
		if(isset($addfile)){
			$script[$addfile] = $addfile;
		}
		else{
			return $script;
		}
	}

	function css($addfile=null){
		static $css;
		if(isset($addfile)){
			$css[$addfile] = $addfile;
		}
		else{
			return $css;
		}
	}

	function html($title, $content){
		return view('html', array('title'=>$title, 'content'=>$content));
	}

	function download($filename, $content){
		return view('download', array('filename'=>$filename, 'content'=>$content));
	}

	function error($errorMessage){
		return view('error', array('errorMessage'=>$errorMessage));
	}

	function json($data){
		return view('json', $data);
	}

	function redirect($url){
		return view('redirect', array('url'=>$url));
	}

	function rss($data){
		return view('rss', $data);
	}

	function xml($data){
		return view('xml', $data);
	}

	function mail($address, $title, $content){
		return view('mail', array(
			'address' => $address,
			'title' => $title,
			'content' => $content,
		));
	}
}