<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/17
 * Time: 14:46
 */

$type = 1;
$length = 4;
// range() 函数创建一个包含指定范围的元素的数组。
if ($type == 1){
    $chars = join("",range(0,9));
}else if($type == 2){
    // array_merge 把两个数组合并为一个数组
    $chars = join("",array_merge(range("a","z"),range("A","Z")));
}else if ($type == 3){
    $chars = join("",array_merge(range("a","z"),range("A","Z"),range(0,9)));
}
if ($length > strlen($chars)){
    exit("字符串长度长度不够");
}
// str_shuffle 随机地打乱字符串中的所有字符
$chars = str_shuffle($chars);
substr($chars,0,$length);

/**
 * 随机产生字符串
 * @param int $type 1 数字 2 字母 3 字母数字混合
 * @param int $length 字符串长度
 * @return bool|string
 */
function buildRandomString($type = 1,$length = 4){
    // range() 函数创建一个包含指定范围的元素的数组。
    if ($type == 1){ // 产生数组
        $chars = join("",range(0,9));
    }else if($type == 2){ // 产生字母
        // array_merge 把两个数组合并为一个数组
        $chars = join("",array_merge(range("a","z"),range("A","Z")));
    }else if ($type == 3){ // 产生字母数字混合
        $chars = join("",array_merge(range("a","z"),range("A","Z"),range(0,9)));
    }
    if ($length > strlen($chars)){
        exit("字符串长度长度不够");
    }
    // str_shuffle 随机地打乱字符串中的所有字符
    $chars = str_shuffle($chars);
    return substr($chars,0,$length);
}

/**
 * 生成唯一字符串
 * @return string
 */
function getUniName(){
    return md5(uniqid(microtime(true),true));
}

/**
 * 获取文件扩展名
 * @param $fileName
 * @return string
 */
function getExt($fileName){
    return @strtolower(end(explode(".",$fileName)));
}