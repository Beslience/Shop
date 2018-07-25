<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/19
 * Time: 10:52
 */

require_once 'include.php';
$act = $_REQUEST['act'];
$id = $_REQUEST['id'];

if ($act == 'login'){
    $mes = login($link);
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
