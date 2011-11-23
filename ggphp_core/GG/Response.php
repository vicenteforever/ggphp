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

	function gzip($data){
		if(!extension_loaded("zlib")) throw new Exception('php isnot support zlib');
		if(strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip")){
			header("Content-Type: text/javascript");
			header("Content-Encoding: gzip");
			header("Vary: Accept-Encoding");
			header("Content-Length: ".strlen($data));
			return $data;
		}
		else{
			//return gzdecode($data);
		}
	}

}