<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/17
 * Time: 14:47
 */

function alertMes($mes,$url){
    echo "<script>alert('{$mes}')</script>";
    echo "<script>window.location='{$url}'</script>";
}