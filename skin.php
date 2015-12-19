<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-19 20:59:25
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 21:06:04
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
@$skinurl = $_SERVER['HTTP_REFERER'];
if (empty($skinurl)||!isset($_GET['id'])) {
    alert('非法操作');
}else{
    //生成cooki保存皮肤
    setcookie('skin',$_GET['id']);
    header('Location:'.$skinurl);
}


?>