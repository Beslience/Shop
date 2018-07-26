<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/17
 * Time: 17:50
 */

require_once '../include.php';
$act = $_REQUEST['act'];
$id = @$_REQUEST['id'];

if ($act == 'logout'){
    logout();
}elseif($act == 'addAdmin'){
    $mes = addAdmin($link);
}elseif($act == 'editAdmin'){
    $mes = editAdmin($link,$id);
}elseif ($act == 'delAdmin'){
    $mes = delAdmin($link,$id);
}elseif($act == 'addCate'){
    $mes = addCate($link);
}elseif($act == 'editCate'){
    $mes = editCate($link,$id);
}elseif ($act == 'delCate'){
    $mes = delCate($link,$id);
}elseif($act == 'addPro'){
    $mes = addPro($link);
}elseif($act == 'editPro'){
    $mes = editPro($link,$id);
}elseif($act == 'delPro'){
    $mes = delPro($link,$id);
}elseif($act == 'addUser'){
    $mes = addUser($link);
}elseif($act == 'delUser'){
    $mes = delUser($link,$id);
}elseif($act == 'editUser'){
    $mes = editUser($link,$id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<?php
if($mes){
    echo $mes;
}
?>
</body>
</html>