<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/19
 * Time: 9:31
 */

function login($link){
    $username = $_POST['username'];
    $username = addslashes($username);
    $password = md5($_POST['password']);
    $autoFlag = $_POST['autoFlag'];
    $sql = "select * from imooc_admin where username ='{$username}' and password = '{$password}'";
    $res = checkAdmin($link,$sql);
    if ($res){
        // 如果选了一周内自动登录
        if ($autoFlag){
            setcookie("adminId",$res['id'],time()+7*24*3600);
            setcookie("adminName",$res['username'],time()+7*24*3600);
        }
        $_SESSION['adminName'] = $res['username'];
        $_SESSION['adminId'] = $res['id'];
        alertMes("登录成功","index.php");
    }else{
        alertMes("登录失败,重新登录","login.php");
    }

}