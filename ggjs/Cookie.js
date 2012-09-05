var GG = GG || {};
/**
 * Cookie类
 */
GG.Cookie = {};

/**
 * 设置cookie
 * @param name string
 * @param value string
 */
GG.Cookie.set = function(name, value){
     var argv = arguments;
     var argc = arguments.length;
     var expires = (argc > 2) ? argv[2] : null;
     var path = (argc > 3) ? argv[3] : '/';
     var domain = (argc > 4) ? argv[4] : null;
     var secure = (argc > 5) ? argv[5] : false;
     document.cookie = name + "=" + escape (value) +
       ((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
       ((path == null) ? "" : ("; path=" + path)) +
       ((domain == null) ? "" : ("; domain=" + domain)) +
       ((secure == true) ? "; secure" : "");
};

/**
 * 读取cookie
 * @param name string
 */
GG.Cookie.get = function(name){
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    var j = 0;
    while(i < clen){
        j = i + alen;
        if (document.cookie.substring(i, j) == arg)
            return GG.Cookie.getCookieVal(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if(i == 0)
            break;
    }
    return null;
};

/**
 * 清除cookie
 * @param name string
 */
GG.Cookie.clear = function(name) {
  if(GG.Cookie.get(name)){
    var expdate = new Date(); 
    expdate.setTime(expdate.getTime() - (86400 * 1000 * 1)); 
    GG.Cookie.set(name, "", expdate, '/'); 
  }
};

/**
 * 清除所有cookie
 * @param path string cookie的path
 * @param domain string cookie所在的domain
 */
GG.Cookie.clearAll = function(path, domain){
	var ss = document.cookie.split('; ');
	var expdate = new Date();
	expdate.setTime(expdate.getTime() - (86400 * 1000 * 1)); 
	var cmd = '';
	for(var i=0; i<ss.length; i++){
		var kv = ss[i].split('=');
		if(kv.length>0){
			GG.Cookie.set(kv[0], '', expdate, path, domain);
		}
	}
}

/**
 * 获取cookie信息
 * @param offset int 偏移位置
 * @return string 信息串
 */
GG.Cookie.getCookieVal = function(offset){
   var endstr = document.cookie.indexOf(";", offset);
   if(endstr == -1){
       endstr = document.cookie.length;
   }
   return unescape(document.cookie.substring(offset, endstr));
};