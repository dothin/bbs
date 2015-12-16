<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-06 15:41:31
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-06 16:37:48
 */
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
//检查alert()函数是否存在
if (!function_exists('alert')) {
    exit('alert()函数不存在');
}
/**
 * [check_username 过滤用户名字符串]
 * @access public
 * @param  [string] $str [输入的字符串]
 * @param  [int] $min [最小长度]
 * @param  [int] $max [最大长度]
 * @return [string]      [过滤后的字符串]
 */
function check_username($str,$min,$max){
    //trim
    $str = trim($str);
    //限制长度
    if (mb_strlen($str,'utf-8') < $min || mb_strlen($str,'utf-8') > $max) {
        alert('用户名长度为'.$min.'到'.$max);
    }
    //限制敏感字符
    $char_pattern = '/[<>\'\"\\ ]/';
    if (preg_match($char_pattern, $str)) {
        alert('用户名不得包含敏感字符');
    }
    
    //转义输入字符串
    return mysql_real_escape_string($str);
}

/**
 * [check_password 验证密码]
 * @access public
 * @param  [string] $string [密码字符串]
 * @param  [int] $min        [密码最小长度]
 * @return [string]             [返回的加密字符串]
 */
function check_password($str,$min){
    //判断密码
    if(strlen($str) < $min ){
        alert('密码最少'.$min.'位！');
    }
    //加密返回
    return mysql_real_escape_string(sha1($str));
}

function check_time($str){

    //限制敏感用户名
    $time=array('0','1','2','3');
    if (!in_array($str, $time)) {
        alert('保留方式错误');
    }
    return $str;
}

function setcookies($username,$uniqid,$time){
    
    switch ($time) {
        case '0'://会话
            setcookie('username',$username);
            setcookie('uniqid',$uniqid);
            break;
        case '1'://一天
            setcookie('username',$username,time()+86400);
            setcookie('uniqid',$uniqid,time()+86400);
            break;
        case '2'://一周
            setcookie('username',$username,time()+604800);
            setcookie('uniqid',$uniqid,time()+604800);
            break;
        case '3'://一月
            setcookie('username',$username,time()+2592000);
            setcookie('uniqid',$uniqid,time()+2592000);
            break;
        
        default:
            break;
    }
}
?>