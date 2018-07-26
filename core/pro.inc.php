<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/18
 * Time: 18:14
 */

/**
 * 添加商品
 * @param $link
 * @return string
 */
function addPro($link){
    $arr = $_POST;
    $arr['pubTime'] = time();
    $path = "uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles)&&$uploadFiles){
        foreach ($uploadFiles as $key=>$uploadFile){
            thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],0.5,50,50);
            thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],0.5,220,220);
            thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],0.5,350,350);
            thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],0.5,800,800);
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

function getAllImgByProId($link,$id){
    $sql = "select a.albumPath from imooc_album a where pid = {$id}";
    $rows = fetchAll($link,$sql);
    return $rows;
}

/**
 * 根据Id得到商品的详细信息
 * @param $link
 * @param $id
 * @return array
 */
function getProById($link,$id){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.id = {$id}";
    $row = fetchOne($link,$sql);
    return $row;
}

function editPro($link,$id){
    $arr = $_POST;
    $path = "uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles)&&$uploadFiles){
        foreach ($uploadFiles as $key=>$uploadFile){
            thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],$uploadFile['name'],50,50);
            thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],$uploadFile['name'],220,220);
            thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],$uploadFile['name'],350,350);
            thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],$uploadFile['name'],800,800);
        }
    }
    $res = update($link,"imooc_pro",$arr,"id = {$id}");
    $pid = $id;
    if ($res&&$pid){
        if ($uploadFiles && is_array($uploadFiles)){
            foreach ($uploadFiles as $uploadFile){
                $arr1['pid'] = $pid;
                $arr1['albumPath'] = $uploadFile['name'];
                addAlbum($link,$arr1);
            }
        }
        $mes = "<p>编辑成功</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    }else{
        if ($uploadFiles && is_array($uploadFiles)){
            foreach ($uploadFiles as $uploadFile){
                if (file_exists("../image_800/".$uploadFile['name'])){
                    unlink("../image_800/".$uploadFile['name']);
                }
                if (file_exists("../image_50/".$uploadFile['name'])){
                    unlink("../image_50/".$uploadFile['name']);
                }
                if (file_exists("../image_220/".$uploadFile['name'])){
                    unlink("../image_220/".$uploadFile['name']);
                }
                if (file_exists("../image_350/".$uploadFile['name'])){
                    unlink("../image_350/".$uploadFile['name']);
                }
            }
        }
        $mes = "<p>编辑失败</p><a href='listPro.php' target='mainFrame'>重新编辑</a>";
    }
    return $mes;
}

function delPro($link,$id){
    $where = "id = ${id}";
    // 先删除图片
    $proImgs = getAllImgByProId($link,$id);
    if ($proImgs &&  is_array($proImgs)){
        foreach ($proImgs as $proImg){
            if (file_exists("uploads/".$proImg['albumPath'])){
                unlink("uploads/".$proImg['albumPath']);
            }
            if (file_exists("../image_50/".$proImg['albumPath'])){
                unlink("../image_50/".$proImg['albumPath']);
            }
            if (file_exists("../image_220/".$proImg['albumPath'])){
                unlink("../image_220/".$proImg['albumPath']);
            }
            if (file_exists("../image_350/".$proImg['albumPath'])){
                unlink("../image_350/".$proImg['albumPath']);
            }
            if (file_exists("../image_800/".$proImg['albumPath'])){
                unlink("../image_800/".$proImg['albumPath']);
            }
        }
    }
    $where1 = "pid = {$id}";
    $res1 = delete($link,"imooc_album",$where1);
    // 再删除商品
    $res = delete($link,"imooc_pro",$where);
    if ($res && $res1){
        $mes = "<p>删除成功</p><br /><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    }else{
        $mes = "<p>删除失败</p><br /><a href='listPro.php' target='mainFrame'>重新删除</a>";
    }
    return $mes;
}

function getProsByCid($link,$cId){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId = {$cId} limit 4";
    $rows = fetchAll($link,$sql);
    return $rows;
}

function getSmallProsByCid($link,$cId){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId = {$cId} limit 4,4";
    $rows = fetchAll($link,$sql);
    return $rows;
}

