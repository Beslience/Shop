<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/19
 * Time: 12:35
 */

// 源文件
$srcFile = "logo.jpg";
// 目标文件
$dstFile = "des_big.jpg";
function waterPic($srcFile= "../images/logo.jpg",$dstFile,$pct=30){
    // 源文件信息
    $srcFileInfo = getimagesize($srcFile);
    // 目标文件信息
    $dstFileInfo = getimagesize($dstFile);
    // 源文件mine
    $srcMine = $srcFileInfo['mime'];
    // 目标文件mime
    $dstMime = $dstFileInfo['mime'];
    // 源文件创建资源函数
    $createSrcFun = str_replace("/","createfrom",$srcMine);
    // 目标文件创建资源函数
    $createDstFun = str_replace("/","createfrom",$dstMime);
    // 输出目标文件函数
    $outDstFun = str_replace("/",null,$dstMime);
    // 源文件资源
    $src_im = $createSrcFun($srcFile);
    // 目标文件资源
    $dst_im = $createDstFun($dstFile);
    // 添加图片水印
    imagecopymerge($dst_im,$src_im,100,100,0,0,$srcFileInfo[0],$srcFileInfo[1],$pct);
    // 设置header
    //header("content-type:".$dstMime);
    // 输出函数
    $outDstFun($dst_im,$dstFile);
    imagedestroy($src_im);
    imagedestroy($dst_im);

}








