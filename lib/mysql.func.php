<?php
/**
 * Created by PhpStorm.
 * User: zjy
 * Date: 2018/7/17
 * Time: 14:47
 */

/**
 * @return mysqli
 */
function connect(){
    $link = mysqli_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败Error:".mysql_errno().":".mysqli_error());
    mysqli_set_charset($link,DB_CHARSET);
    mysqli_select_db($link,DB_DBNAME) or die("打开指定数据库失败");
    return $link;
}

/**
 * 完成记录插入
 * @param $table
 * @param $array
 * @return int
 */
function insert($link,$table,$array){
    $keys = join(",",array_keys($array));
    $vals = "'".join("','",array_values($array))."'";
    $sql = "insert into {$table}({$keys}) values({$vals});";
    mysqli_query($link,$sql);
    return mysqli_insert_id($link);
}

/**
 * 记录更新操作
 * @param $table
 * @param $array
 * @param null $where
 * @return int
 */
function update($link,$table,$array,$where=null){
    $str = null;
    foreach ($array as $key=>$val){
        if ($str==null){
            $sep = "";
        }else{
            $sep = ",";
        }
        $str .= $sep.$key."='".$val."'";
    }
    $sql = "update {$table} set {$str}".($where==null?null:" where ".$where);
    $result = mysqli_query($link,$sql);
    if ($result) {
        return mysqli_affected_rows($link);
    }else{
        return false;
    }
}

/**
 * 删除记录
 * @param $table
 * @param null $where
 * @return int
 */
function delete($link,$table,$where=null){
    $where = ($where==null)?null:" where ".$where;
    $sql = "delete from {$table} {$where}";
    mysqli_query($link,$sql);
    return mysqli_affected_rows($link);
}

/**
 * 得到指定一条记录
 * @param $sql
 * @param int $result_type
 * @return array
 */
function fetchOne($link,$sql,$result_type=MYSQLI_ASSOC){
    $result =  mysqli_query($link,$sql);
    $row = mysqli_fetch_array($result,$result_type);
    return $row;
}

/**
 * 得到所有结果
 * @param $sql
 * @param int $result_type
 * @return array
 */
function fetchAll($link,$sql,$result_type=MYSQLI_ASSOC){
    $result =  mysqli_query($link,$sql);
    if (!$result)
        return ;
    $rows = '';
    while ($row = mysqli_fetch_array($result,$result_type)){
        $rows[] = $row;
    }
    return $rows;
}

/**
 * 得到结果记录条数
 * @param $sql
 * @return int
 */
function getResultNum($link,$sql){
    $result = mysqli_query($link,$sql);
    return mysqli_num_rows($result);
}

/**
 * 得到上一步插入记录的ID
 * @param $link
 * @return int|string
 */
function getInsertId($link){
    return mysqli_insert_id($link);
}

