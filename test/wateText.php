<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/19
 * Time: 11:37
 */

// 指定文件位置
$fileName = "des_big.jpg";
function waterText($fileName,$fontfile = "msyh.ttf",$text = "imooc.com"){
    // 得到图片信息
    $fileInfo = getimagesize($fileName);
    // 获取mime
    $mime = $fileInfo['mime'];
    // 设置创建函数画布
    $createFun = str_replace("/","createfrom",$mime);
    // 输出画布函数
    $outFun = str_replace("/",null,$mime);
    // 创建画布资源
    $image = $createFun($fileName);
    // 设置文字颜色
    $color = imagecolorallocatealpha($image,2550,0,0,50);
    // 设置字体文件
    $fontfile = "../fonts/{$fontfile}";
    // 设置字体内容
    // 添加文字水印
    imagettftext($image,14,0,0,14,$color,$fontfile,$text);
    // 设置header
    header("content-type:".$mime);
    // 输出图片
    $outFun($image);
    // 销毁资源
    imagedestroy($image);
}