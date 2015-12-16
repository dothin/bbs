<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 21:22:59
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-16 13:00:46
 */
@session_start();
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
global $system;
?>
<header class="container h150 header">
    <h1><?php echo $system['webname']; ?></h1>
    <nav>
        <ul class="tr">
            <li><a href="../index.php">首页</a></li>
            
            <?php if (isset($_COOKIE['username'])) {
                echo '<li><a href="../userzone.php">'.$_COOKIE['username'].'的'.'个人中心</a></li>';
            }else{
                echo '<li><a href="../register.php">注册</a></li>
            <li><a href="../login.php">登录</a></li>';
                } ?>
            <li><a href="../blog.php">博友</a></li>
            <li><a href="#">风格</a></li>
            <li><a href="message.php" title="查看信息">私信 <?php echo $GLOBALS['message']; ?></a></li>
            
            <?php 
                if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) {
                    echo '<li><a href="manage.php">管理</a></li>';
                }
                if (isset($_COOKIE['username'])) {
                echo '<li><a href="../logout.php">退出</a></li>';
            } ?>
        </ul>
    </nav>
</header>