<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-04 22:37:17
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 19:04:58
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
 * [check_uniqid 判断唯一标识符时候正常]
 * @param  [string] $uniqid         [生成的唯一标识符]
 * @param  [string] $session_uniqid [session保存的唯一标识符]
 * @return [string]                 [唯一标识符正常则返回]
 */
function check_uniqid($uniqid,$session_uniqid){

    if (strlen($uniqid) != 40 || $uniqid != $session_uniqid) {
        alert('唯一标识符异常！请重新检验后再提交');
    }

    return mysql_real_escape_string($uniqid);
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
    //限制敏感用户名
    $spm[0]= '高华斌';
    $spm[1]= '姜文宇';
    $spm[2]= '张超';
    foreach ($spm as $value) {
        @$spms .=$value.'、';
    }
    if (in_array($str, $spm)) {
        alert($spms.'等敏感用户名不能注册');
    }
    //转义输入字符串
    return mysql_real_escape_string($str);
}

/**
 * [check_password 验证密码]
 * @access public
 * @param  [string] $first_pass [密码字符串]
 * @param  [string] $agine_pass [确认密码字符串]
 * @param  [int] $min        [密码最小长度]
 * @return [string]             [返回的加密字符串]
 */
function check_password($first_pass,$agine_pass,$min){
    //判断密码
    if(strlen($first_pass) < $min ){
        alert('密码最少'.$min.'位！');
    }

    //密码和确认密码必须一致
    if ($first_pass != $agine_pass) {
        alert('密码和确认密码必须一致！');
    }
    //加密返回
    return mysql_real_escape_string(sha1($first_pass));
}
/**
 * [check_modify_password 修改密码验证]
 * @param  [type] $str [description]
 * @param  [type] $min [description]
 * @return [type]      [description]
 */
function check_modify_password($str,$min){
    if (!empty($str)) {
        if (strlen($str) < $min) {
            alert('密码最少'.$min.'位！');
        }
    }else{
        return null;
    }
    return mysql_real_escape_string(sha1($str));
}
/**
 * [check_question 过滤密码提示字符串]
 * @access public
 * @param  [string] $str [密码提示字符串]
 * @param  [int] $min [最小长度]
 * @param  [int] $max [最大长度]
 * @return [string]      [返回的过滤后的密码提示字符串]
 */
function check_question($str,$min,$max){
    //trim
    $str = trim($str);
    //限制长度
    if (mb_strlen($str,'utf-8') < $min || mb_strlen($str,'utf-8') > $max) {
        alert('密码提示长度为'.$min.'到'.$max);
    }
    return mysql_real_escape_string($str);
}
/**
 * [check_answer 验证密码回答字符串]
 * @access public
 * @param  [string] $ques [密码提示字符串]
 * @param  [string] $answ [密码回答字符串]
 * @param  [int] $min  [最小长度]
 * @param  [int] $max  [最大长度]
 * @return [string]       [返回的过滤后的密码回答字符串]
 */
function check_answer($ques,$answ,$min,$max){
    //trim
    $ques = trim($ques);
    $answ = trim($answ);
    //限制长度
    if (mb_strlen($answ,'utf-8') < $min || mb_strlen($answ,'utf-8') > $max) {
        alert('密码回答长度为'.$min.'到'.$max);
    }

    //密码提示和密码回答不能相同
    if ($ques == $answ) {
        alert('密码提示和密码回答不能相同');
    }
    //加密返回
    return mysql_real_escape_string(sha1($answ));
}
/**
 * [check_sex 性别]
 * @access public
 * @param  [string] $str [description]
 * @return [string]      [description]
 */
function check_sex($str){
    return mysql_real_escape_string($str);
}
/**
 * [check_photo 头像]
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function check_photo($str){
    return mysql_real_escape_string($str);
}
/**
 * [check_email 检测邮箱是否合法]
 * @access public
 * @param  [string] $str [邮箱地址]
 * @param  [int] $min  [最小长度]
 * @param  [int] $max  [最大长度]
 * @return [string]      [返回检查后的邮箱]
 */
function check_email($str,$min,$max){
    $char_pattern = '/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/';
    if (!preg_match($char_pattern, $str)) {
        alert('邮件格式不正确！');
    }
    if (strlen($str)<$min||strlen($str)>$max) {
        alert('邮箱长度不正确');
    }
    return mysql_real_escape_string($str);
}
/**
 * [check_qq 检测QQ是否合法]
 * @access public
 * @param  [int] $str [QQ号码]
 * @return [int]      [返回检查后的QQ号码]
 */
function check_qq($str){
    if (empty($str)) {
        return null;
    }else{
        $char_pattern = '/^[1-9]{1}[0-9]{4,9}$/';
        if (!preg_match($char_pattern, $str)) {
            alert('QQ号码不正确！');
        }
    }
    return mysql_real_escape_string($str);
}

/**
 * [check_url 检测URL是否合法]
 * @access public
 * @param  [string] $str [URL]
 * @param  [int] $max  [最大长度]
 * @return [string]      [返回检查后的URL]
 */
function check_url($str,$max){
    if (empty($str) || ($str == 'http://')) {
        return null;
    }else{
        $char_pattern = '/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/';
        if (!preg_match($char_pattern, $str)) {
            alert('网址不正确！');
        }
        if (strlen($str)>$max) {
            alert('url长度不能超过'.$max);
        }
    }
    
    return mysql_real_escape_string($str);
}
/**
 * [check_content 验证私信长度]
 * @param  [type] $str [description]
 * @param  [type] $min [description]
 * @param  [type] $max [description]
 * @return [type]      [description]
 */
function check_content($str,$min,$max){
    //限制长度
    if (mb_strlen($str,'utf-8') < $min || mb_strlen($str,'utf-8') > $max) {
        alert('私信长度为'.$min.'到'.$max);
    }
    return $str;
}
/**
 * [check_post_title 验证帖子标题]
 * @param  [type] $str [description]
 * @param  [type] $min [description]
 * @param  [type] $max [description]
 * @return [type]      [description]
 */
function check_post_title($str,$min,$max){
    //限制长度
    if (mb_strlen($str,'utf-8') < $min || mb_strlen($str,'utf-8') > $max) {
        alert('帖子标题为'.$min.'到'.$max);
    }
    return $str;
}
/**
 * [check_post_content 验证帖子内容]
 * @param  [type] $str [description]
 * @param  [type] $min [description]
 * @return [type]      [description]
 */
function check_post_content($str,$min){
    //限制长度
    if (mb_strlen($str,'utf-8') < $min ) {
        alert('帖子内容不得小于'.$min);
    }
    return $str;
}
/**
 * [check_signature 验证签名内容]
 * @param  [type] $str [description]
 * @param  [type] $max [description]
 * @return [type]      [description]
 */
function check_signature($str,$max){
    //限制长度
    if (mb_strlen($str,'utf-8') > $max ) {
        alert('签名内容不得大于'.$max);
    }
    return $str;
}
?>