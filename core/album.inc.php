<?php
/**
 * Created by PhpStorm.
 * User: zhengjiayuan
 * Date: 2018/7/18
 * Time: 19:59
 */

/**
 * 添加图片路径
 * @param $link
 * @param $arr
 */
function addAlbum($link,$arr){
    insert($link,"imooc_album",$arr);
}

function getProImgById($link,$id){
    $sql = "select albumPath from imooc_album where pid = {$id}";
    $row = fetchOne($link,$sql);
    return $row;
}

function getProImgsById($link,$id){
    $sql = "select albumPath from imooc_album where pid = {$id}";
    $rows = fetchAll($link,$sql);
    return $rows;
}