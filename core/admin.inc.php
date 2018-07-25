<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/17
 * Time: 16:47
 */

/**
 * 检查管理员用户是否存在
 * @param $link
 * @param $sql
 * @return array
 */
function checkAdmin($link,$sql){
    return fetchOne($link,$sql);
}

/**
 * 检查是否有管理员登录
 */
function checkLogined(){
    if ($_SESSION['adminId'] == "" && $_COOKIE['adminId'] == ""){
        alertMes("请先登录","login.php");
    }
}

/**
 * 注销管理员
 */
function logout(){
    $_SESSION=array();
    if (isset($_COOKIE[session_name()])){
        setcookie(session_name(),"",time()-1);
    }
    session_destroy();
    alertMes("注销成功","login.php");
}

/**
 * 添加管理员
 * @param $link
 * @return string
 */
function addAdmin($link){
    $arr = $_POST;
    $arr['password'] = md5($_POST['password']);
    if (insert($link,"imooc_admin",$arr)){
        $mes = "添加成功!<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes = "添加失败!<br/><a href='addAdmin.php'>重新添加</a>";
    }
    return $mes;
}

/**
 * 获取所有管理员
 * @param $link
 * @return array
 */
function getAllAdmin($link){
    $sql = "select id,username,email from imooc_admin ";
    $rows = fetchAll($link,$sql);
    return $rows;
}

/**
 * 编辑管理员信息
 * @param $link
 * @param $id
 * @return string
 */
function editAdmin($link,$id){
    $arr = $_POST;
    $arr['password'] = md5($_POST['password']);
    if (update($link,"imooc_admin",$arr,"id={$id}")){
        $mes = "编辑成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes = "编辑失败!<br/><a href='listAdmin.php'>请重新修改</a>";
    }
    return $mes;
}

/**
 * 删除指定管理员
 * @param $link
 * @param $id
 * @return string
 */
function delAdmin($link,$id){
    if (delete($link,"imooc_admin","id={$id}")){
        $mes = "删除成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes = "删除失败!<br/><a href='listAdmin.php'>请重新删除</a>";
    }
    return $mes;
}

/**
 * 管理员添加用户
 * @param $link
 * @return string
 */
function addUser($link){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    $uploadFile=uploadFile("../uploads");
    if($uploadFile&&is_array($uploadFile)){
        $arr['face']=$uploadFile[0]['name'];
    }else{
        return "添加失败<a href='addUser.php'>重新添加</a>";
    }
    if(insert($link,"imooc_user", $arr)){
        $mes="添加成功!<br/><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看列表</a>";
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        $mes="添加失败!<br/><a href='addUser.php'>重新添加</a>|<a href='listUser.php'>查看列表</a>";
    }
    return $mes;
}

/**
 * 删除指定用户
 * @param $link
 * @param $id
 * @return string
 */
function delUser($link,$id){
    $sql = "select face from imooc_user where id = ".$id;
    $row = fetchOne($link,$sql);
    $face = $row['face'];
    if (file_exists("../uploads/".$face)){
        unlink("../uploads/".$face);
    }
    if (delete($link,"imooc_user","id={$id}")){
        $mes = "删除成功!<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes = "删除失败!<br/><a href='listUser.php'>请重新删除</a>";
    }
    return $mes;
}

/**
 * 编辑指定用户
 * @param $link
 * @param $id
 * @return string
 */
function editUser($link,$id){
    $arr = $_POST;
    $arr['password'] = md5($_POST['password']);
    if (update($link,"imooc_user",$arr,"id={$id}")){
        $mes = "编辑成功!<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes = "编辑失败!<br/><a href='listUser.php'>请重新修改</a>";
    }
    return $mes;
}