<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-15 23:36:17
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 23:53:38
 */
session_start();
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';

//管理员才能登录进来
admin_login();
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
    <div class="container oh uz">
        <?php require ROOT_PATH.'includes/manage.inc.php'; ?>
        <div class="main fr">
            <section class="user">
                <h2>后台管理中心</h2>
                <dl>
                    <dt>·服务器主机名称：</dt>
                    <dd><?php echo $_SERVER['SERVER_NAME']; ?></dd>
                    <dt>·通信协议名称/版本：</dt>
                    <dd><?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
                    <dt>·服务器IP：</dt>
                    <dd><?php echo $_SERVER["SERVER_ADDR"]; ?></dd>
                    <dt>·客户端IP：</dt>
                    <dd><?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
                    <dt>·服务器端口：</dt>
                    <dd><?php echo $_SERVER['SERVER_PORT']; ?></dd>
                    <dt>·客户端端口：</dt>
                    <dd><?php echo $_SERVER["REMOTE_PORT"]; ?></dd>
                    <dt>·管理员邮箱：</dt>
                    <dd><?php echo $_SERVER['SERVER_ADMIN'] ?></dd>
                    <dt>·Host头部的内容：</dt>
                    <dd><?php echo $_SERVER['HTTP_HOST']; ?></dd>
                    <dt>·服务器主目录：</dt>
                    <dd><?php echo $_SERVER["DOCUMENT_ROOT"]; ?></dd>
                    <dt>·脚本执行的绝对路径：</dt>
                    <dd><?php echo $_SERVER['SCRIPT_FILENAME']; ?></dd>
                    <dt>·Apache及PHP版本：</dt>
                    <dd><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></dd>
                </dl>
            </section>
        </div>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>