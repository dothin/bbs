<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-06 16:42:32
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-06 16:47:30
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
move_cookies();
?>