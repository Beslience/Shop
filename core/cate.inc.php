<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/18
 * Time: 10:53
 */

/**
 * 添加分类
 * @param $link
 * @return string
 */
function addCate($link){
    $arr = $_POST;
    if (insert($link,"imooc_cate",$arr)){
        $mes = "分类添加成功!<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类列表</a>";
    }else{
        $mes = "分类添加失败!<br/><a href='addCate.php'>重新添加</a>";
    }
    return $mes;
}

/**
 * 根据id找到指定分类信息
 * @param $link
 * @param $id
 * @return array
 */
function getCateById($link,$id){
    $sql = "select id,cName from imooc_cate where id = {$id}";
    return fetchOne($link,$sql);
}

/**
 * 修改分类
 * @param $link
 * @param $id
 * @return string
 */
function editCate($link,$id){
    $arr = $_POST;
    if (update($link,"imooc_cate",$arr,"id = {$id}")){
        $mes = "分类修改成功!<br/><a href='listCate.php'>查看分类列表</a>";
    }else{
        $mes = "分类修改失败!<br/><a href='addCate.php'>重新修改</a>";
    }
    return $mes;
}

/**
 * 删除分类
 * @param $link
 * @param $id
 * @return string
 */
function delCate($link,$id){
    $res = checkProExist($link,$id);
    if (!$res){
        if (delete($link,"imooc_cate","id = {$id}")){
            $mes = "分类删除成功!<br/><a href='listCate.php'>查看分类列表</a>";
        }else{
            $mes = "分类删除失败!<br/><a href='addCate.php'>重新删除</a>";
        }
        return $mes;
    }else{
        alertMes("不能删除分类，请先删除分类下的商品","listPro.php");
    }
}

/**
 * 得到所有分类
 * @param $link
 * @return array
 */
function getAllCate($link){
    $sql = "select id,cName from imooc_cate";
    $rows = fetchAll($link,$sql);
    return $rows;
}

function checkProExist($link,$id){
    $sql = "select * from imooc_pro where cId = {$id}";
    $rows = fetchAll($link,$sql);
    return $rows;
}