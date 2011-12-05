<?php
if(strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip")){
	header("Content-Type: {$data['Content-Type']}");
	header("Content-Encoding: gzip");
	header("Vary: Accept-Encoding");
	header("Content-Length: ".strlen($data['content']));
	echo $data['content'];
}
else{
	//return gzdecode($data);
}
