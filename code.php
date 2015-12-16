<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-04 20:32:40
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-04 21:57:06
 */
//开启session功能
session_start();
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);

//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';

//验证码
code();
?>