/**
 * 数组类
 */
GG.Array = {};

/**
 * 判断变量是否为数组类型
 *
 * @param {mixed} obj
 * @return {boolean}
 */
GG.Array.isArray = function(obj){
    return Object.prototype.toString.call(obj)=='[object Array]';
}

/**
 * 数组去除重复元素
 *
 * @param {Array} arr
 * @return {Array}
 */
GG.Array.unique = function(arr){
    var obj = {};
    var r = [];
    var i;
    for(i=0; i<arr.length; i++){
        if(obj[arr[i]] !== 1){
            obj[arr[i]] = 1;
            r.push(arr[i]);
        }
    }
    return r;
}

/**
 * 克隆数组
 *
 * @param {Array} arr
 * @return {Array}
 */
GG.Array.clone = function(arr) {
    return arr.slice();
}

/**
 * 返回数组最小值
 *
 * @param {Array} array
 * @param {Function} comparisonFn (a, b) 比较大小函数
 * If omitted the "<" operator will be used. Note: gt = 1; eq = 0; lt = -1
 * @return {Object} 数组内最小的值
 */
GG.Array.min = function(array, comparisonFn) {
    var min = array[0],
    i, ln, item;

    for (i = 0, ln = array.length; i < ln; i++) {
        item = array[i];

        if (comparisonFn) {
            if (comparisonFn(min, item) === 1) {
                min = item;
            }
        }
        else {
            if (item < min) {
                min = item;
            }
        }
    }
    return min;
}

/**
 * 返回数组最大值
 *
 * @param {Array} array
 * @param {Function} comparisonFn (a, b) 比较大小函数
 * If omitted the "<" operator will be used. Note: gt = 1; eq = 0; lt = -1
 * @return {Object} 数组内最小的值
 */
GG.Array.max = function(array, comparisonFn) {
    var max = array[0],
    i, ln, item;

    for (i = 0, ln = array.length; i < ln; i++) {
        item = array[i];

        if (comparisonFn) {
            if (comparisonFn(min, item) === -1) {
                max = item;
            }
        }
        else {
            if (item < min) {
                max = item;
            }
        }
    }
    return max;
}

/**
 * 合并数组去掉重复元素
 * 
 * @param {Array} param1
 * @param {Array} param2
 * @param {Array} ...
 */
GG.Array.merge = function(){
    var args = arguments.slice(),
    array = [],
    i, ln;

    for (i = 0, ln = args.length; i < ln; i++) {
        array = array.concat(args[i]);
    }
    return GG.Array.unique(array)
}
