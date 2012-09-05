/**
 * 字符串处理
 */
GG.String = {};

/**
 * 变量在在两个字符串之间切换值
 * <pre><code>GG.String.toggle(sort, 'ASC', 'DESC')</code></pre>
 * @param {String} str
 * @param {String} value1
 * @param {String} value2
 * @return {String}
 */
GG.String.toggle = function(str, value1, value2){
    return str === value1 ? value2 : value1;
}

/**
 * 左填充字符串到某长度
 * @param {String} str 待填充字符串
 * @param {Number} size 字符串长度
 * @param {String} character 填充的字符
 * @return {String}
 */
GG.String.leftPad = function(str, size, character){
    var result = String(str);
    character = character || " ";
    while (result.length < size) {
        result = character + result;
    }
    return result;
}

/**
 * 格式化字符串
 * @param {String} format
 * @param {String} value1 The value to replace token {0}
 * @param {String} value2 ...
 * @return {String} 格式化后的字符串
 */
GG.String.format = function(format){
    var args = arguments;
    return format.replace(/\{(\d+)\}/g, function(m, i){
        return args[parseInt(i)+1];
    });
}

GG.String.repeat = function(pattern, count, sep){
    var buf = [];
    for( i=0; i<count; i++){
        buf.push(pattern);
    }
    return buf.join(sep || '');
}

GG.String.trim = function(str){
    //var trimRegex = /^\s+|\s+$/g;
    var trimRegex = /^[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u2028\u2029\u202f\u205f\u3000]+|[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u2028\u2029\u202f\u205f\u3000]+$/g;
    return str.replace(trimRegex, '');
}