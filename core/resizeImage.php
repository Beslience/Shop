<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/18
 * Time: 17:32
 */


/**
 * 生成缩略图
 * @param $fileName
 * @param null $destination
 * @param float $scale
 * @param null $dst_w
 * @param null $dst_h
 * @param bool $isReservedSource
 * @return bool
 */
function thumb($fileName,$destination=null,$scale=0.5,$dst_w=null,$dst_h=null,$isReservedSource=false){
    list($src_w,$src_h,$imagetype)=getimagesize($fileName);
    if (is_null($dst_w) || is_null($dst_h)){
        $dst_w = ceil($src_w * $scale);
        $dst_h = ceil($src_h * $scale);
    }
    $mime = image_type_to_mime_type($imagetype);
    $createFun = str_replace("/", "createFun",$mime);
    $outFun = str_replace("/",null,$mime);
    $src_image = $createFun($fileName);
    $dst_image = imagecreatetruecolor($dst_w,$dst_h);
    imagecopyresampled($dst_image,$dst_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
    if ($destination&&!file_exists(dirname($destination))){
        mkdir(dirname($destination),0777,true);
    }
    $dstFileName = ($destination == null)?getUniName().".".getExt($fileName):$destination;
    $outFun($dst_image,$dstFileName);
    imagedestroy($src_image);
    imagedestroy($dst_image);
    if (!$isReservedSource){
        unlink($fileName);
    }
    return $isReservedSource;
}
