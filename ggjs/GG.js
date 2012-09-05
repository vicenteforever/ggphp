var GG = GG || {};

function require(className){
	var js = document.createElement('script');
	js.type = 'text/javascript';
	js.charset = 'utf-8';
	js.src = jsurl;
	$.ajaxSetup({ cache : true });
	$('head').append(js);
}

function callback(fn){
    if (typeof fn == 'function'){
        return fn.apply();
    }
}