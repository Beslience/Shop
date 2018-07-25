<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/18
 * Time: 18:14
 */

function addPro($link){
    $arr = $_POST;
    $arr['pubTime'] = time();
    $path = "uploads";
    var_dump($_POST);
    $uploadFiles = uploadFile();
    if (is_array($uploadFiles)&&$uploadFiles){
        foreach ($uploadFiles as $key=>$uploadFile){
            thumb($path."/".$uploadFile['name'],"../image_50/",$uploadFile['name'],50,50);
            thumb($path."/".$uploadFile['name'],"../image_220/",$uploadFile['name'],220,220);
            thumb($path."/".$uploadFile['name'],"../imag    e_350/",$uploadFile['name'],350,350);
            thumb($path."/".$uploadFile['name'],"../image_800/",$uploadFile['name'],800,800);
        }
    }
    $res = insert($link,"imooc_pro",$arr);
    $pid = getInsertId($link);
    if ($res&&$pid){
        foreach ($uploadFiles as $uploadFile){
            $arr1['pid'] = $pid;
            $arr1['albumPath'] = $uploadFile['name'];
            addAlbum($link,$arr1);
        }
        $mes = "<p>添加成功</p><a href='addPro.php' target='mainFrame'>继续添加</a><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    }else{
        foreach ($uploadFiles as $uploadFile){
            if (file_exists("../image_800/".$uploadFile)){
                unlink("../image_800/".$uploadFile);
            }
            if (file_exists("../image_50/".$uploadFile)){
                unlink("../image_50/".$uploadFile);
            }
            if (file_exists("../image_220/".$uploadFile)){
                unlink("../image_220/".$uploadFile);
            }
            if (file_exists("../image_350/".$uploadFile)){
                unlink("../image_350/".$uploadFile);
            }
        }
        $mes = "<p>添加失败</p><a href='addPro.php' target='mainFrame'>重新添加</a>";
    }
    return $mes;
}