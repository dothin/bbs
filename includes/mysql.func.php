<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-05 21:39:47
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-07 16:13:17
 */
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
//数据库连接
/**
 * [connect 连接mysql数据库]
 * @access public
 * @return [void] [description]
 */
function connect(){
    //global表示全局变量，为了函数外部也能访问到
    global $conn;
    //创建数据库连接
    if(!$conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD)){
        exit('数据库连接失败');
    }
}
/**
 * [select_db 选择一款数据库]
 * @access public
 * @return [void] [description]
 */
function select_db(){
    if (!mysql_select_db(DB_NAME)) {
        exit('要连接的数据库不存在');
    }
}
/**
 * [set_names 设置字符集]
 * @access public
 * @return [void] [description]
 */
function set_names(){
    if (!mysql_query('SET NAMES UTF8')) {
        exit('字符集错误');
    }
}
/**
 * [query 返回sql查询结果]
 * @param  [type] $sql [description]
 * @return [type]      [description]
 */
function query($sql){
    if(!$result = mysql_query($sql)){
        exit('SQL执行失败'.mysql_error());
    }
    return $result;
}
/**
 * [fetch_array 返回一条数据组]
 * @param  [type] $sql [description]
 * @return [type]      [description]
 */
function fetch_array($sql){
    return mysql_fetch_array(query($sql),MYSQL_ASSOC);
}
/**
 * [fetch_array_list 返回指定数据集的所有数据]
 * @param  [type] $result [description]
 * @return [type]         [description]
 */
function fetch_array_list($result){
    return mysql_fetch_array($result,MYSQL_ASSOC);
}

/**
 * [is_repeat 判断数据库里是否已有该数据]
 * @param  [type]  $sql [description]
 * @param  [type]  $str [description]
 * @return boolean      [description]
 */
function is_repeat($sql,$str){
    if (fetch_array($sql)) {
        alert($str);
    }
}
/**
 * [affected_rows 表示影响到的记录数]
 * @return [type] [description]
 */
function affected_rows(){
    return mysql_affected_rows();
}
/**
 * [num_rows 返回数据总行数]
 * @param  [type] $result [description]
 * @return [type]         [description]
 */
function num_rows($result){
    return mysql_num_rows($result);
}
/**
 * [free_result 销毁结果集]
 * @param  [type] $result [description]
 * @return [type]         [description]
 */
function free_result($result){
    mysql_free_result($result);
}

/**
 * [close description]
 * @return [type] [description]
 */

function close(){
    mysql_error();
}
?>