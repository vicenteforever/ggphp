/**
 * 浏览器检测类
 */
GG.Browser = {};

GG.Browser.ua = navigator.userAgent.toLowerCase();

GG.Browser.isIpad = /ipad/.test(GG.Browser.ua);

GG.Browser.isIphone = /iphone/.test(GG.Browser.ua);

GG.Browser.isAndroid = /android/.test(GG.Browser.ua);

GG.Browser.cancelBubble = function(e){
    if(e && e.stopPropagation){
        e.stopPropagation();
    }
    else{
        window.event.cancelBubble = true;
    }
}
