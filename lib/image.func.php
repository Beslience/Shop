<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/17
 * Time: 14:46
 */

require_once 'string.func.php';
/**
 * 生成随机验证码
 * @param int $type 1 数字 2 字母 3 字母数字混合
 * @param int $length 字符长度
 * @param int $pixel
 * @param int $line
 * @param string $sess_name
 */
function verifyImage($type = 1,$length = 4,$pixel = 0,$line = 0,$sess_name = "verify"){
    // 通过GD库做验证码
    // 创建画布
    $width = 80;
    $height = 28;
    $image = imagecreatetruecolor($width,$height);
    $white = imagecolorallocate($image,255,255,255);
    $black = imagecolorallocate($image,0,0,0);
    // 用填充矩形填充画布
    imagefilledrectangle($image,1,1,$width-2,$height-2,$white);
    $chars = buildRandomString($type,$length);
    $_SESSION[$sess_name] = $chars;
    $fontfiles = array("msyh.ttf","msyhbd.ttf","simkai.ttf","simsun.ttc","STXIHEI.TTF");
    // 画验证码
    for ($i = 0;$i < $length;$i++){
        $size = mt_rand(14,18);
        $angle = mt_rand(-15,15);
        $x = 5 + $i * $size;
        $y = mt_rand(20,26);
        $color = imagecolorallocate($image, mt_rand(50,90), mt_rand(80,200),mt_rand(90,180));
        $fontfile = "../fonts/".$fontfiles[mt_rand(0,count($fontfiles) - 1)];
        $text = substr($chars,$i,1);
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
    // 画干扰点
    if ($pixel){
        for ($i = 0;$i < $pixel;$i++){
            imagesetpixel($image,mt_rand(0,$width - 1),mt_rand(0,$height - 1),$black);
        }
    }
    if ($line){
        for ($i = 1; $i < $line;$i++){
            $color = imagecolorallocate($image, mt_rand(50,90), mt_rand(80,200),mt_rand(90,180));
            imageline($image,mt_rand(0,$width - 1),mt_rand(0,$height - 1),
                mt_rand(0,$width - 1),mt_rand(0,$height - 1),$color);
        }
    }
    header("Content-type:image/gif");
    imagegif($image);
    imagedestroy($image);
}


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
    $createFun = str_replace("/", "createfrom",$mime);
    $outFun = str_replace("/",null,$mime);
    $src_image = $createFun($fileName);
    $dst_image = imagecreatetruecolor($dst_w,$dst_h);
    imagecopyresampled($dst_image,$dst_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
    var_dump($destination);
    var_dump(dirname($destination));
    if($destination&&!file_exists(dirname($destination))){
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

/**
 * 为图片添加文字水印
 * @param $fileName
 * @param string $fontfile
 * @param string $text
 */
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
    //header("content-type:".$mime);
    // 输出图片
    $outFun($image);
    // 销毁资源
    imagedestroy($image);
}

/**
 * 添加图片水印
 * @param string $srcFile
 * @param $dstFile
 * @param int $pct
 */
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

