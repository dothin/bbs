<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 21:32:17
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-16 12:56:43
 */
//设置编码
header('Content-Type:text/html;charset=utf-8');

//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}

//转换硬路径常量
define('ROOT_PATH', substr(dirname(__FILE__), 0,-8));
//拒绝PHP低版本
if (PHP_VERSION<'4.1.0') {
    echo "PHP version is too low!";
    exit;
}

//引入函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//执行计时开始
define('TIME_START', runtime());
//$GLOBALS['time_start'] = runtime();

//数据库连接
define('DB_HOST', 'localhost');                                       
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'bbs');
//初始化数据库
connect();
select_db();
set_names();

//私信提醒,得到登录用户bbs_state=0的字段的总和
$message = @fetch_array("SELECT COUNT(bbs_id) AS count FROM bbs_message WHERE bbs_state=0 AND bbs_touser='{$_COOKIE['username']}'");
if (empty($message['count'])) {
    $GLOBALS['message'] = '<strong style="color:orange">(0)</strong>';
}else{
    $GLOBALS['message'] = '<strong style="color:orange">('.$message['count'].')</strong>';
}

//网站系统设置初始化
//读取系统表
if (!!$rows = fetch_array("SELECT bbs_webname,bbs_article_num,bbs_blog_num,bbs_photo_num,bbs_skin,bbs_string,bbs_post_time,bbs_repost_time,bbs_code,bbs_register,bbs_last_modify_date,bbs_modify_user FROM bbs_system WHERE  bbs_id=1 LIMIT 1")) {
    $system = array();
    $system['webname']=$rows['bbs_webname'];
    $system['article_num']=$rows['bbs_article_num'];
    $system['blog_num']=$rows['bbs_blog_num'];
    $system['photo_num']=$rows['bbs_photo_num'];
    $system['skin']=$rows['bbs_skin'];
    $system['string']=$rows['bbs_string'];
    $system['post_time']=$rows['bbs_post_time'];
    $system['repost_time']=$rows['bbs_repost_time'];
    $system['code']=$rows['bbs_code'];
    $system['register']=$rows['bbs_register'];
    $system['last_modify_date']=$rows['bbs_last_modify_date'];
    $system['modify_user']=$rows['bbs_modify_user'];
    $system=html($system);
}else{
    exit('系统表读取错误，请联系管理员');
}
?>
