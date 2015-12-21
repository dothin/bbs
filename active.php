<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-06 12:55:59
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-20 21:21:03
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
if (!isset($_GET['active'])) {
    alert('非法操作');
}
//开始激活处理
if (isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok' ) {
    $active = mysql_real_escape_string($_GET['active']);
    if (fetch_array("SELECT bbs_active FROM bbs_users WHERE bbs_active='$active' LIMIT 1")) {
        //将bbs_active设置为空
        query("UPDATE bbs_users SET bbs_active=NULL WHERE bbs_active='$active' LIMIT 1");
        if (affected_rows() == 1) {
            close();
            location('账户激活成功','login.php');
        } else {
            close();
            location('账户激活失败','register.php');
        }

        //火狐有兼容问题，？？？？
    } else {
        alert('非法操作');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div class="container tc">
        <h2>激活账户</h2>
        <p>点击右侧链接激活您的账户：
        <a href="active.php?action=ok&amp;active=<?php echo $_GET['active']; ?>" title=""><?php echo 'http://'.$_SERVER["HTTP_HOST"].'/'/*$_SERVER["PHP_SELF"]*/; ?>active.php?action=ok&amp;active=<?php echo $_GET['active']; ?></a></p>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>